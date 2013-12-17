<?php

namespace Delivery;

return array(
    'router' => array(
        'routes' => array(
            // Roda padrão
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Delivery\Controller\Produto',
                        'action' => 'index',
                    ),
                ),
            ),
            //Rota criada para o produto
            'produto' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/produto[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Delivery\Controller\Produto',
                        'action' => 'index',
                    ),
                ),
            ),
            // Rota aninhada
            'delivery' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/delivery',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Delivery\Controller',
                        'controller' => 'Produto',
                        'action' => 'index',
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
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Delivery\Controller\Produto' => 'Delivery\Controller\ProdutoController',
            'Delivery\Controller\Session' => 'Delivery\Controller\SessionController'
        ),
    ),
    
    //Configuração de Views
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'delivery/produto/index' => __DIR__ . '/../view/delivery/produto/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',

                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__ => 'my_annotation_driver'
                )
            )
        ),
        // Autenticação com doctrine
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Delivery\Entity\Usuario',
                'identity_property' => 'login',
                'credential_property' => 'senha',
            ),
        ),
    )
);
