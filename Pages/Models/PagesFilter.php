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
    protected $filters = [
        'category' => [
            'title'   => 'Category',
            'options' => ['Article' => 'Articles', 'Page' => 'Pages', 'News' => 'News'],
        ],
        'created_at' => [
            'title'   => 'Created',
            'options' => [
                1   => '1 day',
                2   => '2 days',
                3   => '3 days',
                7   => '1 week',
                14  => '2 weeks',
                30  => '1 month',
                90  => '3 months',
                180 => '6 months',
                365 => '1 year',
                366 => '> 1 year',
            ],
        ],
    ];

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
