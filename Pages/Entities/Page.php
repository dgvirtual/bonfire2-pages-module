<?php

namespace App\Modules\Pages\Entities;

use Bonfire\Core\Traits\HasMeta;
use CodeIgniter\Entity\Entity;

class Page extends Entity
{
    use HasMeta;
    
    protected string $configClass = 'Pages';

    /**
     * Returns the validation rules for all Page meta fields, if any.
     */
    public function validationRules(?string $prefix = null): array
    {
        return $this->metaValidationRules($prefix);
    }
}
