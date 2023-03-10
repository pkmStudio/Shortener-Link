<?php

/**  Этот файл просто содержит какие ссылки есть на сайте.
 *  И к каким классам и методам относятся.
 * 
 * К примеру: в ссылке nameProject/account/login =>
 * Он вернет массив, который скажет нам, что в таком случае
 * надо обратиться к контроллеру Account, а метод в нем вызвать login. 
*/
return 
[
    // Главная страница
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ], 

    'about' => [
        'controller' => 'main',
        'action' => 'about',
    ],


    // Аккаунт
    'account' => [
        'controller' => 'account',
        'action' => 'lk',
    ],

    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],

    'account/exit' => [
        'controller' => 'account',
        'action' => 'exit',
    ],

    'account/contacts' => [
        'controller' => 'account',
        'action' => 'contacts',
    ],

    // Сервис по сокращению ссылок
    'link/add' => [
        'controller' => 'link',
        'action' => 'add',
    ],

    'link/view' => [
        'controller' => 'link',
        'action' => 'view',
    ],

    'link/delete' => [
        'controller' => 'link',
        'action' => 'delete',
    ],    
    
    'link/relocation' => [
        'controller' => 'link',
        'action' => 'relocation',
    ],

    // Новости
    'news/show' => [
        'controller' => 'news',
        'action' => 'show',
    ],
];