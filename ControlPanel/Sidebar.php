<?php

namespace JavidFazaeli\AddonInstaller\ControlPanel;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractSidebar;

class Sidebar extends AbstractSidebar
{
    public $automatic = false;

    public $header = 'Addon Installer';

    private string $base = 'addons/settings/addon_installer/';

    public function process()
    {
        $sidebar = ee('CP/Sidebar')->make();
        $list = $sidebar->addHeader($this->header)->addBasicList();

        $current = ee()->uri->uri_string;
        $mk = fn($suffix) => ee('CP/URL')->make($this->base . $suffix);

        $list->addItem('Install ZIP', $mk('index'))
            ->withIcon('upload')
            ->isActive(
                strpos($current, $this->base . 'index') !== false
                || rtrim($current, '/') === rtrim($this->base, '/')
            );

        $list->addItem('Packages', $mk('packages'))
            ->withIcon('puzzle-piece')
            ->isActive(strpos($current, $this->base . 'packages') !== false);

        $list->addItem('Documentation', $mk('documentation'))
            ->withIcon('book')
            ->isActive(strpos($current, $this->base . 'documentation') !== false);

        ee()->view->sidebar = $sidebar->render();
    }
}
