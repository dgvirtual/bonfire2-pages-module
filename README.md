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

1. Check that your `app/Config/Bonfire.php` file includes this location of the Modules (you will have to uncomment the
`'App\Modules' => APPPATH . 'Modules'` line):

    ```php
    public $appModules = [
        'App\Modules' => APPPATH . 'Modules',
    ];
    ```

2. Copy the directory `Pages` to `app/Modules` directory of your project (or another directory, if the $appModules points to another one in your installation).

3. Open the `app/Config/AuthGroups.php` file and add the following permissions to the $permissions array:

    ```php
    public array $permissions = [
        // Original permissions here...
        // ...
        // Pages module related permissions:
        'pages.list'          => 'Can view list of pages',
        'pages.view'          => 'Can view pages details',
        'pages.create'        => 'Can create new pages',
        'pages.edit'          => 'Can edit existing pages',
        'pages.delete'        => 'Can delete existing pages',
        'pages.settings'      => 'Can manage pages settings in admin area',
    ];
    ```

4. Also review the `array $matrix` in the same file and add the `pages.*` permissions to `superadmin` and `admin` groups and the other groups that should have permissions to access the Pages module in the admin panel.

Note that any changes you make in an existing installation, where you have done changes to permissions on live website via admin interface, will
require you to delete the corresponding entries from admin interface and configure them anew, since the permissions from config in Bonfire are only picked one time, and then they are managed from database exclusively.

5. Configure recycler. Edit `app/Config/Recycler.php` property `$resources` by adding `pages` to it, so it looks something like:

    ```php
    public $resources = [
        // Original users array here...
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

6. If you are using other than English language in your admin area, you will need to download
    TinyMCE 6 language pack for your language (check [here](https://www.tiny.cloud/get-tiny/language-packages/)).
    Download the language pack that you use and see among the community - supported ones. Extract, rename to conform to this
    pattern (tinymce6-lt.js") (where `lt` stands for `Lithuanian`), and copy to your theme folder
    `themes/Admin/js/`. Language code needs to correspond to the locale code of your language as defined in `app/Config/App.php`.

7. Copy Pages/Config/Pages.php file to app/Config, in the copied file change the namespace declaration to `Config`
   and `use` line to `use App\Modules\Pages\Config\Pages;

8. Get your own TinyMCE API key (https://www.tiny.cloud/auth/signup/), add a section to your project `.env` file with your api key:

    ```env
    #--------------------------------------------------------------------
    # PAGES
    #--------------------------------------------------------------------
    pages.tinymceApiKey = 'your-api-key-goes-here'
    ```

    Without this step the page editor will be read-only.

9.  To update the database, run this command from the base directory of your Codeigniter install:

    `php spark migrate -n App\\Modules\\Pages --all`

10. And, if you wish (it is not necessary), you can populate the database with some randomly generated pages:

    `php spark db:seed App\\Modules\\Pages\\Database\\Seeds\\InsertSamplePages`

(on Windows replace double slashes with single).

That should be it.

## Updating

When updating, repeat step 2, and see if there are any significant changes in the config file `Pages.php` to be merged with the file in your `app/Config/Pages.php`.
