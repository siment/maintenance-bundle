<?php

/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\Tests\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Siment\MaintenanceBundle\EventListener\RequestListener;
use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class RequestListenerTest extends TestCase
{
    /** @var RequestListener The object being tested */
    private $requestListener;

    /** @var MockObject&Environment Twig environment */
    private $twigMock;

    /** @var MockObject&MaintenanceModeManager Maintenance mode manager */
    private $maintenanceModeMock;

    /** @var MockObject&RequestEvent Request event */
    private $requestEventMock;

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->twigMock = $this->createMock(Environment::class);
        $this->maintenanceModeMock = $this->createMock(MaintenanceModeManager::class);
        $this->requestEventMock = $this->createMock(RequestEvent::class);
        $this->requestListener = new RequestListener($this->twigMock, $this->maintenanceModeMock);
    }

    /**
     * Test for what should happen when maintenance mode is disabled.
     *
     * @see \Siment\MaintenanceBundle\EventListener\RequestListener::onKernelRequest
     *
     * @throws \InvalidArgumentException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function testMaintenanceModeDisabled()
    {
        // Mock that maintenance mode is disabled ...
        $this->maintenanceModeMock->expects($this->once())->method('isEnabled')->willReturn(false);

        // ... so no methods should be invoked on the RequestEvent object
        $this->requestEventMock->expects($this->never())->method($this->anything());

        // Run the tested method
        $this->requestListener->onKernelRequest($this->requestEventMock);
    }

    /**
     * Test for what should happen when maintenance mode is enabled.
     *
     * @see \Siment\MaintenanceBundle\EventListener\RequestListener::onKernelRequest
     *
     * @throws \InvalidArgumentException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function testMaintenanceModeEnabled()
    {
        // Mock that maintenance mode is enabled ...
        $this->maintenanceModeMock->expects($this->once())->method('isEnabled')->willReturn(true);

        // ... thereby triggering method calls on the twig environment object and the RequestEvent object
        $this->requestEventMock->expects($this->once())->method('setResponse');
        $this->twigMock->expects($this->once())
            ->method('render')
            ->with('@SimentMaintenance/maintenance.html.twig');

        // Run the tested method
        $this->requestListener->onKernelRequest($this->requestEventMock);
    }
}
