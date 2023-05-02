<?php

namespace App\Modules\Pages\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class PagesFilter extends PagesModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Pages
     *
     * @var array
     */
    protected $filters = [];

    function __construct() {
        parent::__construct();

        $this->filters = [
            'category' => [
                'title'   => lang('Pages.headingCategory'),
                'options' => ['Article' => lang('Pages.labelArticles'), 'Page' => lang('Pages.labelPages'), 'News' => lang('Pages.labelNews')],
            ],
            'created_at' => [
                'title'   => lang('Pages.headingCreated'),
                'options' => [
                    1   => '1 ' . lang('Pages.labelDay'),
                    2   => '2 ' . lang('Pages.labelDays'),
                    3   => '3 ' . lang('Pages.labelDays'),
                    7   => '1 ' . lang('Pages.labelWeek'),
                    14  => '2 ' . lang('Pages.labelWeeks'),
                    30  => '1 ' . lang('Pages.labelMonth'),
                    90  => '3 ' . lang('Pages.labelMonths'),
                    180 => '6 ' . lang('Pages.labelMonths'),
                    365 => '1 ' . lang('Pages.year'),
                    366 => '> 1 ' . lang('Pages.year'),
                ],
            ],
        ];
        
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return PagesFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('pages.*');

        if (isset($params['category']) && count($params['category'])) {
            $this->whereIn('pages.category', $params['category']);
        }

        if (isset($params['created_at']) && count($params['created_at'])) {
            // We only use the largest value
            $days = max($params['created_at']);
            $this->where('created_at >=', Time::now()->subDays($days)->toDateTimeString());
        }

        return $this;
    }
}
