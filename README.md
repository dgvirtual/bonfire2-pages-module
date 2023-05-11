# Admin module "Pages" for Bonfire 2

## About

This repo holds the code for an admin module "Pages" for [Bonfire 2](https://github.com/lonnieezell/Bonfire2), an admin panel for CodeIgniter 4 projects.

Pages module is a very basic implementation of a module of Bonfire 2 admin panel for administration of pages on a website. 

Bonfire 2 includes [instructions how to make an admin module](https://github.com/lonnieezell/Bonfire2/blob/develop/docs/building_admin_modules/index.md), but there is no complete example. I followed the instructions and looked at examples in Bonfire 2 code itself to implement this admin module, for learning purposes mostly. But my work might be useful for you as well.

## Features

- CRUD (Create, Read, Update, Delete) functionality for pages, that have Title, Content (and Excerpt for display in admin interface mainly), Slug and Categories fields;
- integration with Bonfire 2 admin interface and functionality (Menu, Widgets, Search, Filter, Recycler);
- full localization (though don't expect too much, Bonfire 2 itself is not yet properly localized);
- HTMX-powered field validation on the frontend (not available elsewhere in Bonfire 2!);

## Installation

You should have a Codeigniter 4 installation with  Bonfire 2 installed (refer to Bonfire 2 docs to learn how to do that). 

1. Check that your `app/Config/Bonfire.php` file includes this location of the Modules: 

    ```
    public $appModules = [
        'App\Modules' => APPPATH . 'Modules',
    ];
    ```

2. Copy the directory `Pages` to `app/Modules` directory of your project (or another directory, if the $appModules points to another one in your installation). 

3. Open the `app/Config/AuthGroups.php` file and add the following permissions to the $permissions array:

    ```
    public array $permissions = [
        // Original permissions here...
        // ...
        // Pages module related permissions: 
        'pages.view'          => 'Can view pages details',
        'pages.create'        => 'Can create new pages',
        'pages.edit'          => 'Can edit existing pages',
        'pages.delete'        => 'Can delete existing pages',
        'pages.settings'      => 'Can manage pages settings in admin area',
    ];
    ```

5. Also review the `array $matrix` in the same file and add the `pages.*` permissions to `superadmin` and `admin` groups and the other groups that should have permissions to access the Pages module in the admin panel. 

6. Configure recycler. Edit `app/Config/Recycler.php` property `$resources` by adding `pages` to it, so it looks something like:

    ```
    public $resources = [
        'users' => [
            'label'   => 'Users',
            'model'   => 'Bonfire\Users\Models\UserModel',
            'columns' => [
                'username', 'first_name', 'last_name', 'email',
            ],
        ],
        'pages' => [
            'label'   => 'Pages',
            'model'   => 'App\Modules\Pages\Models\PagesModel',
            'columns' => [
                'id', 'title', 'excerpt', 'deleted_at',
            ],
        ],
    ];
    ```

7. To update the database, run this command from the base directory of your Codeigniter install: 

    `php spark migrate -n App\\Modules\\Pages`

8. And, if you wish (it is not necessary), you can populate the database with some pages: 

    `php spark php spark db:seed App\\Modules\\Pages\\Database\\Seeds\\InsertSamplePages`

That should be it. 
