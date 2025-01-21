<?php

namespace App\Modules\Pages;

use App\Modules\Pages\Models\PagesModel;
use Bonfire\Core\Traits\SearchInMeta;
use Bonfire\Search\Interfaces\SearchProviderInterface;

class SearchProvider extends PagesModel implements SearchProviderInterface
{
    use SearchInMeta;
    /**
     * Performs a primary search for just this resource.
     *
     * @param string     $term
     * @param int        $limit
     * @param array|null $post
     *
     * @return array
     */
    public function search(string $term, int $limit = 10, array $post = null): array
    {
        $query = $this->select('pages.*')->distinct();

        $searchInMeta = setting('Pages.includeMetaFieldsInSearech');

        if (!empty($searchInMeta)) {
            // first argument is the resource entity name, second – the DB table name
            $query->joinMetaInfo('App\Modules\Pages\Entities\Page', 'pages');
        }

        $query->like('title', $term, 'right', true, true)
            ->orlike('content', $term, 'right', true, true)
            ->orLike('category', $term, 'right', true, true);

        if (!empty($searchInMeta)) {
            foreach ($searchInMeta as $metaField) {
                // here syntax almost exactly like that of orLike()
                $query->orLikeInMetaInfo($metaField, $term, 'both', true, true);
            }
        }

        $query->orderBy('title', 'asc');

        return $query->findAll($limit);
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    public function resourceName(): string
    {
        return lang('Pages.pages');
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     *
     * @return string
     */
    public function resourceUrl(): string
    {
        return ADMIN_AREA .'/pages';
    }

    /**
     * Returns the name of the view to use when
     * displaying the list of results for this
     * resource type.
     *
     * @return string
     */
    public function resultView(): string
    {
        return 'App\Modules\Pages\Views\_search_list';
    }
}
