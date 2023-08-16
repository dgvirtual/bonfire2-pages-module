<?php

namespace App\Modules\Pages;

use Bonfire\Core\BaseModule;
use Bonfire\Menus\MenuItem;

use App\Modules\Pages\Models\PagesModel;
use Bonfire\Widgets\Types\Charts\ChartsItem;
use Bonfire\Widgets\Types\Stats\StatsItem;

class Module extends BaseModule
{
    /**
     * Setup our admin area needs.
     */
    public function initAdmin()
    {
        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => lang('Pages.pageTitle'),
            'namedRoute'      => 'pages-list',
            'fontAwesomeIcon' => 'fas fa-file',
            'permission'      => 'pages.view',
        ]);
        $sidebar->menu('sidebar')->collection('content')->addItem($item);

        $widgets = service('widgets');
        $pages = new PagesModel();
        $statsItem = new StatsItem([
            'bgColor' => 'bg-blue',
            'title' => lang('Pages.pageTitle'),
            'value' => $pages->where('deleted_at', null)->countAllResults(),
            'url' => ADMIN_AREA . '/pages',
            'faIcon' => 'fas fa-file',
        ]);
        $widgets->widget("stats")->collection('stats')->addItem($statsItem);

        $statsItem = new ChartsItem([
            'title'   => lang('Pages.pagesClassByCat'),
            'type'   => 'pie',
            'cssClass'   => 'col-3',
        ]);
        $statsItem->addDataset('pages', 'category', 'id');
        $widgets->widget('charts')->collection('charts')->addItem($statsItem);
    }
}
