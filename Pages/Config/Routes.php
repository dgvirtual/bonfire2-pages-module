<?php
/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Pages\Controllers'], static function ($routes) {
    //  Manage Pages
    $routes->match(['GET', 'POST'],'pages', 'PagesController::list', ['as' => 'pages-list']);
    $routes->get('pages/new', 'PagesController::create', ['as' => 'page-new']);
    $routes->post('pages/save', 'PagesController::save');
    $routes->get('pages/(:num)', 'PagesController::edit/$1', ['as' => 'page-edit']);
    $routes->get('pages/(:num)/delete', 'PagesController::delete/$1', ['as' => 'page-delete']);
    $routes->post('pages/delete-batch', 'PagesController::deleteBatch');
    $routes->post('pages/validateField/(:any)', 'PagesController::validateField/$1');
});
