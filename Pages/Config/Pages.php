<?php

namespace App\Modules\Pages\Config;

use CodeIgniter\Config\BaseConfig;

class Pages extends BaseConfig
{
    /**
     * TinyMCE API Key
     *
     * you can get tinyMCE Api Key at: https://www.tiny.cloud/auth/signup/
     * it will look something like bk3sgosn5c698jq71s7svqpmompgkuzm2wr7knwb4ksxhv6t
     *
     * Switching to HugeRTE requires no license or api key
     */
    // public string $tinymceApiKey = 'no-api-key';

    /**
     * List of meta info fields with their labels and validation rules
     * @var array
     */
    public $metaFields = [
        'Pages.entry_status' => [
            'published' => ['label' => 'Pages.published', 'type' => 'checkbox', 'validation' => ['label' => 'Published', 'rules' => 'required|in_list[true,false]']],
        ],
        'Pages.author_info' => [
            'author_name' => ['label' => 'Pages.author_name', 'type' => 'text', 'validation' => ['label' => 'Author Name', 'rules' => 'required|string']],
            'show_author' => ['label' => 'Pages.show_contacts', 'type' => 'checkbox', 'validation' => ['label' => 'Pages.show_contacts', 'rules' => 'required|in_list[true,false]']],
            'fb' => ['label' => 'Pages.fb_page','type' => 'text', 'validation' => ['label' => 'Pages.fb_page', 'rules' => 'required|valid_url_strict[https]']],
            'email' => ['label' => 'Pages.author_email', 'type' => 'text', 'validation' => ['label' => 'Pages.author_email', 'rules' => 'required|valid_email']],
        ],
    ];

    /**
     * List of meta info fields that should be included in search within admin area
     * @var array
     */
    public $includeMetaFieldsInSearech = [
        'author_name',
        'fb',
        'email',
    ];
}
