<?php

namespace App\Modules\Pages;

use App\Modules\Pages\Models\PagesModel;

class PagesDashboard
{
    public function latestPages(int $count = 3, bool $updated = true, string $color = 'primary'): string
    {
        $criterion = $updated ? 'updated_at' : 'created_at';
        $title = $updated ? 'Pages Last Updated' : 'Pages Last Created';
        $pages = model('App\Modules\Pages\Models\PagesModel')
            ->orderBy($criterion, 'DESC')
            ->limit($count)
            ->findAll();
//dd($pages);
        return view('App\Modules\Pages\Views\_card', [
            'pages' => $pages,
            'title' => $title,
            'color' => $color,
            'moreLink' => url_to('pages-list'),
            'moreLabel' => 'All Pages',
        ]);
    }
}
