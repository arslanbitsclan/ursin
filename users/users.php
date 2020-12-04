<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Users
Description: User module description |BitsClan.
Author – module author name
Version: 2.3.0| BitsClan
Requires at least: 2.3.*
*/
define('USERS_MODULE_NAME', 'users');

/**
* Register activation module hook
*/
register_activation_hook(USERS_MODULE_NAME, 'users_module_activation_hook');

function users_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(USERS_MODULE_NAME, [USERS_MODULE_NAME]);

/**
 * Init users module menu items in setup in admin_init hook
 * @return null
 */

hooks()->add_action('admin_init', 'users_module_init_menu_items');



function users_module_init_menu_items(){
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('custom-menu-unique-id', [
        'name'     => 'Users', // The name if the item
        'href'     => admin_url('Users'), // URL of the item
        'position' => 47, // The menu position, see below for default positions.
        'icon'     => 'fa fa-question-circle', // Font awesome icon
    ]);


 hooks()->add_action('admin_init', 'users_permissions');
function users_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => l('permission_view') . '(' . l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('users', $capabilities, _l('users'));
}
}

