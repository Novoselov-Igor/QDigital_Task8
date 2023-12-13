<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'main',
    ],
    'logout' => [
        'controller' => 'main',
        'action' => 'logout'
    ],
    'addTask' => [
        'controller' => 'main',
        'action' => 'taskAddition'
    ],
    'removeTask' => [
        'controller' => 'main',
        'action' => 'taskRemoval'
    ],
    'readyTask' => [
        'controller' => 'main',
        'action' => 'taskReadiness'
    ],

    'auth' => [
        'controller' => 'auth',
        'action' => 'auth'
    ],
    'authenticate' => [
        'controller' => 'auth',
        'action' => 'authenticate'
    ],
];