<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'helloworld' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/helloworld',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Helloworld\Controller',
                        'controller' => 'Index',
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
                            )
                        )
                    )
                )
            )
        )
    ),
//    'controllers' => array(
//        'invokables' => array(
//            'Helloworld\Controller\Index'
//            => 'Helloworld\Controller\IndexController'
//        )
//    )
    'controllers' => array(
        'factories' => array(
            'Helloworld\Controller\Index' => function($serviceLocator) {
                $ctr = new Helloworld\Controller\IndexController();

                $ctr->setGreetingService(
                        $serviceLocator->getServiceLocator()
                                ->get('greetingService')
                );

                return $ctr;
            }
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'displayCurrentDate'
            => 'Helloworld\View\Helper\DisplayCurrentDate'
        )
    )
);
?>