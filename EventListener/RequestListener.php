<?php

/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\EventListener;

use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

/**
 * Listens for HTTP request to determine if site should be offline.
 */
class RequestListener
{
    /** @var Environment Twig environment */
    private $twig;

    /** @var MaintenanceModeManagerInterface Maintenance mode manager */
    private $mode;

    /**
     * RequestListener constructor.
     *
     * @param Environment                     $t    Twig environment
     * @param MaintenanceModeManagerInterface $mode Maintenance mode manager
     */
    public function __construct(Environment $t, MaintenanceModeManagerInterface $mode)
    {
        $this->twig = $t;
        $this->mode = $mode;
    }

    /**
     * This method is executed on every request.
     *
     * @param RequestEvent $event Request event object
     *
     * @throws \InvalidArgumentException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->mode->isEnabled()) {
            return;
        }

        $event->setResponse(new Response(
            $this->twig->render('@SimentMaintenance/maintenance.html.twig'),
            Response::HTTP_SERVICE_UNAVAILABLE
        ));
    }
}
