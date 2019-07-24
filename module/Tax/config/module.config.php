<?php
namespace Tax;

use Zend\Router\Http\Segment;

return [

    'router' => [
        'routes' => [
            'home' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'country' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/country[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CountryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'state' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/state[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\StateController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'county' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/county[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CountyController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'payment' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/payment[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\PaymentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'dashboard' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/dashboard[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'tax' => __DIR__ . '/../view',
        ],
    ],
];