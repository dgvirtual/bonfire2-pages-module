<?php

namespace App\Modules\Pages\Config;

use CodeIgniter\Config\BaseConfig;

class Pages extends BaseConfig
{
    // get tinyMCE Api Key at: https://www.tiny.cloud/auth/signup/
    // it will look something like bk3sgosn5c698jq71s7svqpmompgkuzm2wr7knwb4ksxhv6t
    public string $tinymceApiKey = 'no-api-key';
}
