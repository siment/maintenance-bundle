<?php
/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;

/**
 * Listens for HTTP request to determine if site should be offline.
 */
class RequestListener
{
    /** @var CacheInterface Standard Symfony cache interface */
    private $cache;

    /** @var Environment Twig environment */
    private $twig;

    /**
     * RequestListener constructor.
     *
     * @param CacheInterface $c Standard Symfony cache interface
     * @param Environment    $t Twig environment
     */
    public function __construct(CacheInterface $c, Environment $t)
    {
        $this->cache = $c;
        $this->twig = $t;
    }

    /**
     * This method is executed on every request.
     *
     * @param RequestEvent $event Request event object
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $m = $this->cache->get('maintenance', function () {
            return false;
        });

        if (false === $m) {
            return;
        }

        $event->setResponse(new Response(
            $this->twig->render('@SimentMaintenance/maintenance.html.twig'),
            Response::HTTP_SERVICE_UNAVAILABLE
        ));
    }
}
