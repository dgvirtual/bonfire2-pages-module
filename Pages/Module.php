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
        // true if we are on Dashboard page
        $isDashboard = current_url() === config('App')->baseURL . '/' . ADMIN_AREA;

        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => lang('Pages.pageTitle'),
            'namedRoute'      => 'pages-list',
            'fontAwesomeIcon' => 'fas fa-file',
            'permission'      => 'pages.view',
        ]);
        $sidebar->menu('sidebar')->collection('content')->addItem($item);

        $widgets   = service('widgets');
        $pages     = new PagesModel();
        $itemId0    = 'pagesCount2347';
        $statsItem = new StatsItem([
            'bgColor' => 'bg-blue',
            'title'   => lang('Pages.pageTitle'),
            'id'      => 'pagesCount2347',
            'value'   => (setting('Stats.Stats_' . $itemId0) === 'on' && $isDashboard) ? $pages->where('deleted_at', null)->countAllResults() : null,
            'url'     => ADMIN_AREA . '/pages',
            'faIcon'  => 'fas fa-file',
        ]);
        $widgets->widget('stats')->collection('stats')->addItem($statsItem);

        $itemId    = 'pagesByCategory129';
        $statsItem = new ChartsItem([
            'title'    => lang('Pages.pagesClassByCat'),
            'type'     => 'pie',
            'id'       => $itemId,
            'cssClass' => 'col-3',
        ]);
        if (setting('Stats.Charts_' . $itemId) === 'on' && $isDashboard) {
            $statsItem->addDataset('pages', 'category', 'id');
        }
        $widgets->widget('charts')->collection('charts')->addItem($statsItem);

        $itemId2    = 'pagesByCategory435';
        $statsItem2 = new ChartsItem([
            'title'    => lang('Pages.pagesClassByCat'),
            'type'     => 'bar',
            'id'       => $itemId2,
            'cssClass' => 'col-6',
        ]);
        if (setting('Stats.Charts_' . $itemId2) === 'on' && $isDashboard) {
            $statsItem2->addDataset('pages', 'category', 'id');
        }
        $widgets->widget('charts')->collection('charts')->addItem($statsItem2);
    }
}
