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
            'fieldGroups' => $this->augmentMetafields(),
            'page' => $page,
        ]);
    }

    private function augmentMetafields()
    {
        $metaFields = setting('Pages.metaFields');
        $metaFieldsUpd = [];
        foreach ($metaFields as $fieldGroup => $groupValue) {
            foreach ($groupValue as $key => $value) {
                if (!isset($value['label'])) {
                    $metaFields[$fieldGroup][$key]['label'] = esc(ucwords(strtolower(str_replace(['-', '_'], ' ', $key))));
                } elseif (lang($value['label']) !== $value['label']) {
                    // if !==, there is a translation string, use it
                    $metaFields[$fieldGroup][$key]['label'] = lang($value['label']);
                }
            }
            //dd(lang($fieldGroup));
            if (lang($fieldGroup) !== $fieldGroup) {
                $metaFieldsUpd[lang($fieldGroup)] = $metaFields[$fieldGroup];
            }
            else {
                $metaFieldsUpd[$fieldGroup] = $metaFields[$fieldGroup];
            }
        }
        return $metaFieldsUpd;
    }
}
