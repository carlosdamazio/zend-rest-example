<?php
namespace Category;

use Zend\Router\Http\Segment;

return [
    'Zend\Db',
    'Zend\Router',
    'Zend\Validator',

    'view_manager' => [
      'strategies' => [
        'ViewJsonStrategy',
      ],
    ],

    'router' => [
        'routes' => [
            'category' => [
                'type'    => segment::class,
                'options' => [
                  'route' => '/[:id]',
                    'constraints' => [
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
];
