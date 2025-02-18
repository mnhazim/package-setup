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