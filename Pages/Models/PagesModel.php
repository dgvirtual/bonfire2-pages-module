<?php

namespace App\Modules\Pages\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table      = 'pages';
    protected $primaryKey = 'id';

    protected $returnType = \App\Modules\Pages\Entities\Page::class; // default array
    protected $useSoftDeletes = true;

    // should match the categories rule in_list
    public $pageCategories = [];
    public $categoriesKeys = [];

    protected $allowedFields = [
        'title',
        'content',
        'excerpt',
        'slug',
        'category',
        'deleted_at'
    ];

    public $validationRules = [];

    protected $allowCallbacks = true;
    protected $beforeDelete   = ['deleteMeta'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deleted_at    = 'deleted_at';

    public function __construct()
    {
        parent::__construct();

        $this->pageCategories = [
            'News'    => lang('Pages.labelNewsSingle'),
            'Article' => lang('Pages.labelArticle'),
            'Page'    => lang('Pages.labelPage')];

        $this->categoriesKeys = implode(',', array_keys($this->pageCategories));

        $this->validationRules = [
            'id'    => [
                'rules' => 'permit_empty|numeric'
            ],
            'title'    => [
                'label' => lang('Pages.title'),
                'rules' => 'required|min_length[10]|max_length[250]'
            ],
            'content'  => [
                'label' => lang('Pages.content'),
                'rules' => 'required|min_length[100]'
            ],
            'excerpt' => [
                'label' => lang('Pages.excerpt'),
                'rules' => 'required|min_length[10]|max_length[250]'
            ],
            'slug'     => [
                'label' => lang('Pages.urlSlug'),
                'rules' => 'permit_empty|valid_url|is_unique[pages.slug,id,{id}]|min_length[3]|max_length[250]'
            ],
            'category' => [
                'label' => lang('Pages.category'),
                'rules' => 'required|in_list[' . $this->categoriesKeys . ']'
            ],
        ];
    }

    /**
     * Event-triggered method to delete page meta info if the page is being purged
     * from the system
     */
    public function deleteMeta(array $data): array
    {
        // if it is a soft delete, return at once
        if (! $data['purge']) {
            return $data;
        }

        $page = $this->withDeleted()->find($data['id'][0]); // Retrieve the entity

        if (! $page) {
            return $data;
        }

        if (! empty($page->allMeta())) {
            $page->deleteResourceMeta();
        }

        return $data;
    }
}
