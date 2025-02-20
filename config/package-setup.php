<?php

return [
    'packages' => [
        // [
        //     'name' => 'Spatie Media Library',
        //     'package' => '"spatie/laravel-medialibrary"',
        //     'installer' => \Mnhazim\PackageSetup\Installers\BasicStepInstaller::class,
        //     'has_migrations' => true,
        //     'publishes' => [
        //         [
        //             'provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
        //             'tag' => 'medialibrary-migrations'
        //         ],
        //         [
        //             'provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
        //             'tag' => 'medialibrary-config'
        //         ],
        //     ]
        // ],
        [
            'name' => 'Breeze by Laravel',
            'package' => 'laravel/breeze --dev',
            'installer' => \Mnhazim\PackageSetup\Installers\BreezeInstaller::class,
            'has_migrations' => true,
            'publishes' => [
                [
                    'provider' => 'MarvinLabs\DiscordLogger\ServiceProvider',
                    'tag' => null
                ],
            ]
        ],
        [
            'name' => 'Spatie Laravel Permission',
            'package' => 'spatie/laravel-permission',
            'installer' => \Mnhazim\PackageSetup\Installers\BasicStepInstaller::class,
            'has_migrations' => true,
            'publishes' => [
                [
                    'provider' => 'Spatie\Permission\PermissionServiceProvider',
                    'tag' => null
                ],
            ]
        ],
        [
            'name' => 'Discord Logger by Marvinlabs',
            'package' => 'marvinlabs/laravel-discord-logger',
            'installer' => \Mnhazim\PackageSetup\Installers\BasicStepInstaller::class,
            'has_migrations' => true,
            'publishes' => [
                [
                    'provider' => 'MarvinLabs\DiscordLogger\ServiceProvider',
                    'tag' => null
                ],
            ]
        ],
    ],
    // 'components' => [
    //     [
    //         'name' => 'alert',
    //         'class' => \Mnhazim\PackageSetup\Components\Alert::class,
    //     ],
    //     [
    //         'name' => 'button',
    //         'class' => \Mnhazim\PackageSetup\Components\Button::class,
    //     ]
    // ],
    // 'templates' => [
    //     [
    //         'name' => 'Main Layout',
    //         'path' => 'layouts/app',
    //         'description' => 'Main application layout with navigation'
    //     ]
    // ]
];