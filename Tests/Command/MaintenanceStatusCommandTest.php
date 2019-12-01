<?php

/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\Tests\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Siment\MaintenanceBundle\Command\MaintenanceStatusCommand;
use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MaintenanceStatusCommandTest extends TestCase
{
    /** @var MaintenanceModeManager|MockObject $modeManagerMock Maintenance mode manager */
    private $modeManagerMock;

    /** @var Application Console Application */
    private $application;

    /** @var CommandTester Command tester */
    private $commandTester;

    /**
     * Set up test.
     */
    public function setUp(): void
    {
        $this->modeManagerMock = $this->createMock(MaintenanceModeManager::class);
        $this->application = new Application();
        $this->application->add(new MaintenanceStatusCommand(null, $this->modeManagerMock));

        /** @var Command $command */
        $command = $this->application->find('maintenance:status');
        $this->commandTester = new CommandTester($command);
    }

    /**
     * Test for when application is in maintenance mode.
     *
     * @see \Siment\MaintenanceBundle\Command\MaintenanceStatusCommand::execute
     */
    public function testOutputInMaintenanceMode()
    {
        $this->modeManagerMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);
        $this->commandTester->execute([]);

        /** @var string $output Output from command */
        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Maintenance mode is ENABLED.', $output);
    }

    /**
     * Test for when application is not in maintenance mode.
     *
     * @see \Siment\MaintenanceBundle\Command\MaintenanceStatusCommand::execute
     */
    public function testOutputNotInMaintenanceMode()
    {
        $this->modeManagerMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(false);
        $this->commandTester->execute([]);

        /** @var string $output Output from command */
        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Maintenance mode is DISABLED.', $output);
    }
}
