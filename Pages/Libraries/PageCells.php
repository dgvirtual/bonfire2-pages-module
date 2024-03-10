<?php

namespace App\Modules\Pages\Libraries;

/**
 * Provides view cells for Pages
 */
class PageCells
{
    protected $viewPrefix = 'App\Modules\Pages\Views\\';

    /**
     * Displays the form fields for pages meta fields.
     */
    public function metaFormFields($page)
    {
        return view($this->viewPrefix . '_meta', [
            'fieldGroups' => setting('Pages.metaFields'),
            'page' => $page,
        ]);
    }
}
