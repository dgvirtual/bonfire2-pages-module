<?php

namespace App\Modules\Pages\Config;

use CodeIgniter\Config\BaseConfig;

class Pages extends BaseConfig
{
    // get tinyMCE Api Key at: https://www.tiny.cloud/auth/signup/
    // it will look something like bk3sgosn5c698jq71s7svqpmompgkuzm2wr7knwb4ksxhv6t
    public string $tinymceApiKey = 'no-api-key';

    public $metaFields = [
        'Article Status' => [
            'published' => ['label' => 'Published', 'type' => 'checkbox', 'validation' => ['label' => 'Published', 'rules' => 'permit_empty|string']],
        ],
        'Author Info' => [
            'author_name' => ['label' => 'Author Name', 'type' => 'text', 'validation' => ['label' => 'Author Name', 'rules' => 'required|string']],
            'show_author' => ['label' => 'Show Contacts', 'type' => 'checkbox', 'validation' => ['label' => 'Show Contacts', 'rules' => 'permit_empty|in_list[true,false]']],
            'fb' => ['label' => 'Author Facebook Page', 'type' => 'text', 'validation' => ['label' => 'Author Facebook Page', 'rules' => 'permit_empty|valid_url']],
            'email' => ['label' => 'Author Email', 'type' => 'text', 'validation' => ['label' => 'Author Email', 'rules' => 'permit_empty|valid_email']],
        ],
    ];
}
