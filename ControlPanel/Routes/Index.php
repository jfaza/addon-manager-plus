<?php

namespace JavidFazaeli\AddonInstaller\ControlPanel\Routes;

use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;

class Index extends AbstractRoute
{
    use LoadsStyle;

    /**
     * @var string
     */
    protected $route_path = 'index';

    /**
     * @var string
     */
    protected $cp_page_title = 'Addon Installer';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $this->addBreadcrumb('index', 'Addon Installer');
        $this->loadStyle();

        $installer = ee('addon_installer:packageInstaller');
        $result = null;

        if (ee('Request')->isPost() && ee()->input->post('install_package')) {
            try {
                $result = $installer->installUploaded(
                    $_FILES['addon_package'] ?? [],
                    (bool) ee()->input->post('overwrite_existing')
                );

                ee('CP/Alert')->makeBanner('addon-installer-upload')
                    ->asSuccess()
                    ->withTitle('Package uploaded')
                    ->addToBody($result['name'] . ' was extracted to the ExpressionEngine add-ons folder.')
                    ->defer();

                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/addon_installer/index', [
                    'installed' => $result['short_name'],
                ]));
            } catch (\Throwable $e) {
                ee('CP/Alert')->makeBanner('addon-installer-upload')
                    ->asIssue()
                    ->withTitle('Package was not installed')
                    ->addToBody($e->getMessage())
                    ->defer();

                ee()->functions->redirect(ee('CP/URL')->make('addons/settings/addon_installer/index'));
            }
        }

        $installedShortName = (string) ee()->input->get('installed', true);
        $installedAddon = $installedShortName !== '' ? ee('Addon')->get($installedShortName) : null;
        $isInstalled = $installedAddon ? (bool) $installedAddon->isInstalled() : false;
        $updateAvailable = $installedAddon ? (bool) $installedAddon->hasUpdate() : false;
        $settingsAvailable = $isInstalled && $installedAddon && (bool) $installedAddon->get('settings_exist');
        $packagesUrl = ee('CP/URL')->make('addons/settings/addon_installer/packages');

        $this->setBody('Index', [
            'status' => $installer->status(),
            'installed_short_name' => $installedShortName,
            'installed_is_installed' => $isInstalled,
            'update_available' => $updateAvailable,
            'manager_url' => ee('CP/URL')->make('addons')->compile(),
            'install_url' => $installedShortName !== '' && ! $isInstalled
                ? ee('CP/URL')->make('addons/install/' . $installedShortName, [
                    'return' => $packagesUrl->encode(),
                ])->compile()
                : '',
            'update_url' => $updateAvailable
                ? ee('CP/URL')->make('addons/update/' . $installedShortName, [
                    'return' => $packagesUrl->encode(),
                ])->compile()
                : '',
            'remove_url' => $isInstalled
                ? ee('CP/URL')->make('addons/remove/' . $installedShortName, [
                    'return' => $packagesUrl->encode(),
                ])->compile()
                : '',
            'settings_url' => $settingsAvailable
                ? ee('CP/URL')->make('addons/settings/' . $installedShortName)->compile()
                : '',
            'packages_url' => $packagesUrl->compile(),
            'docs_url' => ee('CP/URL')->make('addons/settings/addon_installer/documentation')->compile(),
            'csrf_token' => $installer->csrfToken(),
        ]);

        return $this;
    }
}
