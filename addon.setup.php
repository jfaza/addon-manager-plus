<?php

use JavidFazaeli\AddonInstaller\Service\PackageInstaller;

return [
    'name'              => 'Addon Installer',
    'description'       => 'Install and download ExpressionEngine add-ons from ZIP packages through the control panel.',
    'version'           => '1.1.0',
    'author'            => 'Javid Fazaeli',
    'author_url'        => 'https://fazaeli.dev',
    'namespace'         => 'JavidFazaeli\AddonInstaller',
    'settings_exist'    => true,
    'services.singletons' => [
        'packageInstaller' => function($addon) {
            return new PackageInstaller();
        },
        'PackageInstaller' => function($addon) {
            return ee('addon_installer:packageInstaller');
        },
    ],
];
