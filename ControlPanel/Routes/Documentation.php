<?php

namespace JavidFazaeli\AddonInstaller\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;

class Documentation extends AbstractRoute
{
    use LoadsStyle;

    /**
     * @var string
     */
    protected $route_path = 'documentation';

    /**
     * @var string
     */
    protected $cp_page_title = 'Documentation';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $this->addBreadcrumb('index', 'Addon Manager +');
        $this->addBreadcrumb('documentation', 'Documentation');
        $this->loadStyle();

        $this->setBody('Documentation', [
            'upload_url' => ee('CP/URL')->make('addons/settings/addon_installer/index')->compile(),
            'packages_url' => ee('CP/URL')->make('addons/settings/addon_installer/packages')->compile(),
            'manager_url' => ee('CP/URL')->make('addons')->compile(),
        ]);

        return $this;
    }
}
