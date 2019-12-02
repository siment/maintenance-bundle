<?php

/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\Command;

use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command that outputs current status of application's maintenance mode.
 */
class MaintenanceStatusCommand extends Command
{
    /** @var string The name of the command */
    protected static $defaultName = 'maintenance:status';

    /** @var MaintenanceModeManagerInterface Maintenance mode manager */
    private $mode;

    /**
     * MaintenanceEnableCommand constructor.
     *
     * @param string|null                     $name Name of command
     * @param MaintenanceModeManagerInterface $mode Maintenance mode manager
     */
    public function __construct(string $name = null, MaintenanceModeManagerInterface $mode)
    {
        parent::__construct($name);
        $this->mode = $mode;
    }

    /**
     * Configuring the command.
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Outputs current status of application\'s maintenance mode');
    }

    /**
     * Executing the command.
     *
     * @param InputInterface  $input  Input to command
     * @param OutputInterface $output Output from command
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->mode->isEnabled()) {
            $text = 'Maintenance mode is ENABLED.';
        } else {
            $text = 'Maintenance mode is DISABLED.';
        }

        $output->writeln($text);

        return 0;
    }
}
