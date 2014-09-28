<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Menu\Controller\Manage' => 'Menu\Controller\ManageController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'menu' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/menu',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Menu\Controller',
                        'controller' => 'Manage',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                    'manage' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/manage[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Menu\Controller\Manage',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'menu' => __DIR__ . '/../view',
        ),
    ),
);
