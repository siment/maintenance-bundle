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
use Psr\Cache\CacheItemInterface;
use Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/*
 * Tests for \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager.
 */
class MaintenanceModeManagerTest extends TestCase
{
    /** @var MaintenanceModeManager Maintenance mode manager (The tested object) */
    private $maintenanceModeManager;

    /** @var FilesystemAdapter|MockObject Cache pool mock object */
    private $cacheMock;

    /** @var string The cache key that defines if application is in maintenance mode */
    private static $modeIdentifier = 'maintenance';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->cacheMock = $this->createMock(FilesystemAdapter::class);
        $this->maintenanceModeManager = new MaintenanceModeManager($this->cacheMock);
    }

    /**
     * Test for \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::enable.
     *
     * @see \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::enable
     */
    public function testEnable()
    {
        $cacheItemMock = $this->createMock(CacheItemInterface::class);
        $cacheItemMock->expects($this->once())->method('set')->with(true);
        $this->cacheMock->expects($this->once())
            ->method('getItem')
            ->with(self::$modeIdentifier)
            ->willReturn($cacheItemMock);
        $this->cacheMock->expects($this->once())->method('save')->with($cacheItemMock);
        $this->assertTrue($this->maintenanceModeManager->enable());
    }

    /**
     * Test for \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::disable.
     *
     * @see \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::disable
     */
    public function testDisable()
    {
        $this->cacheMock->expects($this->once())->method('deleteItem')->with(self::$modeIdentifier);
        $this->assertTrue($this->maintenanceModeManager->disable());
    }

    /**
     * Test for \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::isEnabled.
     *
     * .. when in maintenance mode.
     *
     * @see \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::isEnabled
     */
    public function testIsEnabledWhenInMaintenanceMode()
    {
        $cacheItemMock = $this->createMock(CacheItemInterface::class);
        $cacheItemMock->expects($this->once())->method('isHit')->willReturn(true);
        $this->cacheMock->expects($this->once())
            ->method('getItem')
            ->with(self::$modeIdentifier)
            ->willReturn($cacheItemMock);
        $this->assertTrue($this->maintenanceModeManager->isEnabled());
    }

    /**
     * Test for \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::isEnabled.
     *
     * .. when NOT in maintenance mode.
     *
     * @see \Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager::isEnabled
     */
    public function testIsEnabledWhenNotInMaintenanceMode()
    {
        $cacheItemMock = $this->createMock(CacheItemInterface::class);
        $cacheItemMock->expects($this->once())->method('isHit')->willReturn(false);
        $this->cacheMock->expects($this->once())
            ->method('getItem')
            ->with(self::$modeIdentifier)
            ->willReturn($cacheItemMock);
        $this->assertFalse($this->maintenanceModeManager->isEnabled());
    }
}
