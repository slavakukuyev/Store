<?php
return array(
    'controllers'=>array(
        'invokables'=>array(
            'CsnUser\Controller\User'=>'CsnUser\Controller\UserController',
        ),
    ),
    
    
    
    'router'=>array(
        'routes'=>array(
            'csn_user'=>array(
                'type'=>'Literal',
                'options'=>array(
                    'route'=>'/csn-user',
                    'defaults'=>array(
                        '__NAMESPACE__'=>'CsnUser\Controller',
                        'controller'=>'User',
                        'action'=>'index',
                    ),
                ),
                'may_terminate'=>true,
                'child_routes'=>array(
                    'default'=>array(
                        'type'=>'Segment',
                        'options'=>array(
                            'route'=>'/[:controller[/:action[/:id]]]',
                            'constraints'=>array(
                                'controller'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'=>'[0-9]*',                               
                            ),
                            'defaults'=>array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
   
        'view_manager'=>array(
            'template_path_stack'=>array(
                'csn_user'=>__DIR__.'/../view'
            ),
        ),
        
);
?>
