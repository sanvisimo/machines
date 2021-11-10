<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User model class
    |--------------------------------------------------------------------------
    */

    'user_model' => 'App\Models\User',

    /*
    |--------------------------------------------------------------------------
    | Nova User resource tool class
    |--------------------------------------------------------------------------
    */

    'user_resource' => 'App\Nova\User',

    /*
    |--------------------------------------------------------------------------
    | The group associated with the resource
    |--------------------------------------------------------------------------
    */

    'role_resource_group' => 'Contacts',

    /*
    |--------------------------------------------------------------------------
    | Database table names
    |--------------------------------------------------------------------------
    | When using the "HasRoles" trait from this package, we need to know which
    | table should be used to retrieve your roles. We have chosen a basic
    | default value but you may easily change it to any table you like.
    */

    'table_names' => [
        'roles' => 'roles',

        'role_permission' => 'role_permission',

        'role_user' => 'role_user',

        'users' => 'users',

        'articles' => 'articles',

        'customers' => 'customers'
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        'view users' => [
            'display_name' => 'View users',
            'description'  => 'Can view users',
            'group'        => 'User',
        ],

        'create users' => [
            'display_name' => 'Create users',
            'description'  => 'Can create users',
            'group'        => 'User',
        ],

        'edit users' => [
            'display_name' => 'Edit users',
            'description'  => 'Can edit users',
            'group'        => 'User',
        ],

        'delete users' => [
            'display_name' => 'Delete users',
            'description'  => 'Can delete users',
            'group'        => 'User',
        ],

        'view roles' => [
            'display_name' => 'View roles',
            'description'  => 'Can view roles',
            'group'        => 'Role',
        ],

        'create roles' => [
            'display_name' => 'Create roles',
            'description'  => 'Can create roles',
            'group'        => 'Role',
        ],

        'edit roles' => [
            'display_name' => 'Edit roles',
            'description'  => 'Can edit roles',
            'group'        => 'Role',
        ],

        'delete roles' => [
            'display_name' => 'Delete roles',
            'description'  => 'Can delete roles',
            'group'        => 'Role',
        ],

        'view articles' => [
            'display_name' => 'View articles',
            'description'  => 'Can view articles',
            'group'        => 'Article',
        ],

        'manage articles' => [
            'display_name' => 'Manage articles',
            'description'  => 'Can manage articles',
            'group'        => 'Article',
        ],

        'view customers' => [
            'display_name' => 'View customers',
            'description'  => 'Can view customers',
            'group'        => 'Customer',
        ],

        'manage customers' => [
            'display_name' => 'Manage customers',
            'description'  => 'Can manage customers',
            'group'        => 'Customer',
        ],

        'view machine' => [
            'display_name' => 'View machines',
            'description'  => 'Can view customers',
            'group'        => 'Machine',
        ],

        'manage machine' => [
            'display_name' => 'Manage machines',
            'description'  => 'Can manage machines',
            'group'        => 'Machine',
        ],

        'view any machine' => [
            'display_name' => 'View any machines',
            'description'  => 'Can view any machines',
            'group'        => 'Machine',
        ],

        'manage any machine' => [
            'display_name' => 'Manage machines',
            'description'  => 'Can manage machines',
            'group'        => 'Machine',
        ],

        'view any customers' => [
            'display_name' => 'View any customers',
            'description'  => 'Can view any customers',
            'group'        => 'Customer',
        ],

        'manage any customers' => [
            'display_name' => 'Manage any customers',
            'description'  => 'Can manage any customers',
            'group'        => 'Customer',
        ],

        'view manutention' => [
            'display_name' => 'View manutentions',
            'description'  => 'Can view manutentions',
            'group'        => 'Manutention',
        ],

        'manage manutention' => [
            'display_name' => 'Manage manutentions',
            'description'  => 'Can manage manutentions',
            'group'        => 'Manutention',
        ],

        'view any manutention' => [
            'display_name' => 'View any manutentions',
            'description'  => 'Can view any manutentions',
            'group'        => 'Manutention',
        ],

        'manage any manutention' => [
            'display_name' => 'Manage manutentions',
            'description'  => 'Can manage manutentions',
            'group'        => 'Manutention',
        ],
    ],
];
