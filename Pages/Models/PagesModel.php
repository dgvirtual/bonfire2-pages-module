<?php

namespace App\Modules\Pages\Models;

use CodeIgniter\Model;
use stdClass;

class PagesModel extends Model
{
    protected $table      = 'pages';
    protected $primaryKey = 'id';

    protected $returnType = 'object'; // default array
    protected $useSoftDeletes = true;

    // should match the categories rule in_list
    public $pageCategories = ['News', 'Article', 'Page'];

    protected $allowedFields = [
        'title',
        'content',
        'excerpt',
        'slug',
        'category',
        'deleted_at'
    ];

    protected $validationRules = [
        'title'    => [
            'label' => 'Title',
            'rules' => 'required|min_length[10]|max_length[250]'
        ],
        'content'  => [
            'label' => 'Content',
            'rules' => 'required|min_length[100]'
        ],
        'excerpt' => [
            'label' => 'Excerpt',
            'rules' => 'required|min_length[10]|max_length[250]'
        ],
        'slug'     => [
            'label' => 'Slug',
            'rules' => 'permit_empty|valid_url|is_unique[pages.slug,id,{id}]|min_length[3]|max_length[250]'
        ],
        'category' => [
            'label' => 'Category',
            'rules' => 'required|in_list[News,Article,Page]'
        ],
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deleted_at    = 'deleted_at';

    /**
     * create empty database entry
     */
    public function newPage(): object
    {
        $page = new stdClass();
        foreach ($this->allowedFields as $field) {
            $page->$field = null;
        }
        return $page;
    }
}
