<?php

namespace App\Modules\Pages\Entities;

use Bonfire\Core\Traits\HasMeta;
use CodeIgniter\Entity\Entity;

class Page extends Entity
{
    use HasMeta;

    /**
     * Returns the validation rules for all Page meta fields, if any.
     */
    public function validationRules(?string $prefix = null): array
    {
        return $this->metaValidationRules('Pages', $prefix);
    }
}
