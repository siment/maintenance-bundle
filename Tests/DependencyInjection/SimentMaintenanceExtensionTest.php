<?php
/*
 * Copyright (C) 2019 Simen Thorsrud
 * @author Simen Thorsrud <simen.thorsrud@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Siment\MaintenanceBundle\DependencyInjection\SimentMaintenanceExtension;

class SimentMaintenanceExtensionTestTestCase extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new SimentMaintenanceExtension()];
    }

    public function testLoad()
    {
        $this->load();
        $this->assertContainerBuilderHasService('Siment\MaintenanceBundle\Command\MaintenanceDisableCommand');
        $this->assertContainerBuilderHasService('Siment\MaintenanceBundle\Command\MaintenanceEnableCommand');
        $this->assertContainerBuilderHasService('Siment\MaintenanceBundle\Command\MaintenanceStatusCommand');
        $this->assertContainerBuilderHasService('Siment\MaintenanceBundle\EventListener\RequestListener');
        $this->assertContainerBuilderHasService('Siment\MaintenanceBundle\ModeManager\MaintenanceModeManager');
        $this->assertContainerBuilderHasService(
            'Siment\MaintenanceBundle\ModeManager\MaintenanceModeManagerInterface'
        );
    }
}
