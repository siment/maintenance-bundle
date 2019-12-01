<?php

/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siment\MaintenanceBundle\ModeManager;

/**
 * Interface for managing application's maintenance mode.
 */
interface MaintenanceModeManagerInterface
{
    /**
     * Enables application's maintenance mode.
     */
    public function enable(): bool;

    /**
     * Disables application's maintenance mode.
     */
    public function disable(): bool;

    /**
     * Returns true if application is in maintenance mode.
     */
    public function isEnabled(): bool;
}
