<?php
/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Siment\MaintenanceBundle\Command\MaintenanceDisableCommand;
use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MaintenanceDisableCommandTest extends TestCase
{
    /** @var MaintenanceModeManager|MockObject $modeManagerMock Maintenance mode manager */
    private $modeManagerMock;

    /** @var Application Console Application */
    private $application;

    /** @var CommandTester Command tester */
    private $commandTester;

    public function setUp(): void
    {
        $this->modeManagerMock = $this->createMock(MaintenanceModeManager::class);
        $this->application = new Application();
        $this->application->add(new MaintenanceDisableCommand(null, $this->modeManagerMock));

        /** @var Command $command */
        $command = $this->application->find('maintenance:disable');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecute()
    {
        $this->modeManagerMock->expects($this->once())->method('disable');
        $this->commandTester->execute([]);
    }
}
