<?php

namespace App\Modules\Pages;

use App\Modules\Pages\Models\PagesModel;
use Bonfire\Core\BaseModule;
use Bonfire\Menus\MenuItem;
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

        $statsItem = new StatsItem([
            'bgColor' => 'bg-blue',
            'title'   => lang('Pages.pageTitle'),
            'id'      => 'pagesCount2347',
            'url'     => ADMIN_AREA . '/pages',
            'faIcon'  => 'fas fa-file',
            // 'value'   => (new PagesModel())->countAllResults(),
        ]);
        $statsItem->addValue('auth_groups_users');
        $widgets->widget('stats')->collection('stats')->addItem($statsItem);

        $chartsItem = new ChartsItem([
            'title'    => lang('Pages.pagesClassByCat'),
            'type'     => 'pie',
            'id'       => 'pagesByCategoryPie129',
            'cssClass' => 'col-3',
        ]);
        $chartsItem->addDataset('pages', 'category', 'id');
        $widgets->widget('charts')->collection('charts')->addItem($chartsItem);

        $chartsItem1 = new ChartsItem([
            'title'    => lang('Pages.pagesClassByCat'),
            'type'     => 'bar',
            'id'       => 'pagesByCategoryBar654',
            'cssClass' => 'col-6',
        ]);
        $chartsItem1->addDataset('pages', 'category', 'id');
        $widgets->widget('charts')->collection('charts')->addItem($chartsItem1);
    }
}
