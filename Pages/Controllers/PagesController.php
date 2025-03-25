<?php

namespace App\Modules\Pages\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\I18n\Time;
use App\Modules\Pages\Entities\Page;

//use CodeIgniter\Database\Exceptions\DataException;

class PagesController extends AdminController
{
    protected $pagesFilter;
    protected $pagesModel;
    protected $adminLink;

    protected $theme      = 'Admin';
    protected $viewPrefix = 'App\Modules\Pages\Views\\';
    protected $modelPrefix = 'App\Modules\Pages\Models\\';


    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        /** user code below */
        $this->pagesFilter = model($this->modelPrefix . 'PagesFilter');
        $this->adminLink = site_url(ADMIN_AREA . '/pages/');
    }

    public function list()
    {
        if (!auth()->user()->can('pages.list')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
        }

        // will need to replace next with
        $this->pagesFilter->filter($this->request->getGet('filters'));

        $view = $this->request->hasHeader('HX-Request')
            ? $this->viewPrefix . '_table'
            : $this->viewPrefix . 'list';


        return $this->render($view, [
            'headers' => [
                'id'            => lang('Pages.id'),
                'title'         => lang('Pages.title'),
                'excerpt'       => lang('Pages.excerpt'),
                'category'      => lang('Pages.category'),
                'updated_at'    => lang('Pages.updated'),
            ],
            'showSelectAll' => true,
            'pages'         => $this->pagesFilter->paginate(setting('Site.perPage')),
            'pager'         => $this->pagesFilter->pager,
        ]);
    }


    /**
     * Display the "new page" form.
     */
    public function create()
    {
        if (!auth()->user()->can('pages.create')) {
            return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
        }

        $pagesModel = model($this->modelPrefix . 'PagesModel');
        $page       = new Page();
        //dd($page->id);
        // TODO: transfer this to templates / views and make automatic
        // $viewMeta = service('viewMeta');
        // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));
        $this->getHugeRTE();

        helper('form');
        return $this->render($this->viewPrefix . 'form', [
            'page' => $page,
            'adminLink' => $this->adminLink,
            'pageCategories' => $pagesModel->pageCategories,
        ]);
    }

    /**
     * Display the Edit form for a single page.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function edit(int $pageId)
    {
        if (!auth()->user()->can('users.edit')) {
            return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
        }

        $pagesModel = model($this->modelPrefix . 'PagesModel');

        $page = $pagesModel->withDeleted()->find($pageId);
        if ($page === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pages.page')]));
        }
		
        $this->getHugeRTE();

        helper('form');
        return $this->render($this->viewPrefix . 'form', [
            'page'   => $page,
            'adminLink' => $this->adminLink,
            'pageCategories' => $pagesModel->pageCategories,
        ]);
    }

    /**
     * Creates new or saves an edited a page.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|void
     *
     * @throws ReflectionException
     */
    public function save()
    {
        $pageId = $this->request->getPost('id');
        //need this link to use in ->to instead of ->back
        //(because it is messed up by htmx validation calls)
        $currentUrl = $this->adminLink . ($pageId ?: 'new');

        if (!auth()->user()->can('pages.edit')) {
            return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
        }

        $pagesModel = model($this->modelPrefix . 'PagesModel');

        $page = $pageId !== null
            ? $pagesModel->find($pageId)
            : new Page();

        /**
         * if there is a page id (so we run an update operation)
         * but such page is not in db:
         */
        /** @phpstan-ignore-next-line */
        if ($page === null) {
            return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Pages.page')]));
        }

        /** set the post values to the object */
        // foreach ($this->request->getPost() as $key => $value) {
        //     $page->$key = $value;
        // }
        $page->fill($this->request->getPost());

        /** update slug if needed; should this go into entity? */
        $page->slug = $this->updateSlug($page->slug, $page->title, ($page->id ?? null));
        $page->excerpt = mb_substr(strip_tags($page->content), 0, 100) . '...';

        $validation = \Config\Services::validation();

        /** add validation rules of meta to the model */
        $validation->setRules(array_merge($pagesModel->validationRules, $page->validationRules('meta')));

        //$pagesModel->checkRules();

        /** attempt validate */
        if (! $validation->run($page->toArray())) {
            //dd($validation->getErrors());
            return redirect()->to($currentUrl)->withInput()->with('errors', $validation->getErrors());
        }

        /** do the saving */
        if ($page->hasChanged('title') || $page->hasChanged('slug') || $page->hasChanged('content') || $page->hasChanged('category')) {
            $pagesModel->save($page);
        }

        if (!isset($page->id) || !is_numeric(($page->id))) {
            $page->id = $pagesModel->getInsertID();
        }

        $page->syncMeta($this->request->getPost('meta') ?? []);

        return redirect()->to($this->adminLink . $page->id)->with('message', lang('Bonfire.resourceSaved', [lang('Pages.page')]));
    }

    /**
     * Delete the specified user.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(int $pageId)
    {
        if (!auth()->user()->can('pages.delete')) {
            return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
        }

        $pagesModel = model($this->modelPrefix . 'PagesModel');
        /** @var User|null $user */
        $page = $pagesModel->find($pageId);

        if ($page === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pages.page')]));
        }

        if (!$pagesModel->delete($page->id)) {
            return redirect()->back()->with('error', lang('Bonfire.unknownError'));
        }

        return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Pages.page')]));
    }


    /**
     * Deletes multiple pages from the database.
     * Called via the checked() records in the table.
     */
    public function deleteBatch()
    {
        if (!auth()->user()->can('pages.delete')) {
            return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
        }

        $ids = $this->request->getPost('selects');

        if (empty($ids)) {
            return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Pages.pages')]));
        }
        $ids = array_keys($ids);

        $pagesModel = model($this->modelPrefix . 'PagesModel');

        if (!$pagesModel->delete($ids)) {
            return redirect()->back()->with('error', lang('Bonfire.unknownError'));
        }

        return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Pages.pages')]));
    }

    /**
     * Validation for any field
     */
    public function validateField(string $fieldName): string
    {
        $pagesModel = model($this->modelPrefix . 'PagesModel');
        $validation = \Config\Services::validation();
        $validation->setRules($pagesModel->getValidationRules(['only' => [$fieldName, 'id']]));
        $validation->withRequest($this->request)->run();

        return $validation->getError($fieldName);
    }


    // deal with page slug; geterate unique if needed; if it is supplied, do nothing
    private function updateSlug($inputSlug, $inputTitle, $inputId)
    {
        $sep = '-';
        if (is_null($inputSlug) || empty(trim($inputSlug))) {
            $pagesModel = model($this->modelPrefix . 'PagesModel');
            $pgId = $inputId ?? 0;
            $i = 0;
            $slug = mb_url_title($inputTitle, $sep, true);
            $list = $pagesModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
            $flatList = $this->flattenArray($list, 'slug');
            // TODO: rewrite with text helper increment_string('file-4') function ?
            if (in_array($slug, $flatList)) {
                $i++;
                while (in_array($slug . $sep . $i, $flatList)) {
                    $i++;
                }
            }

            return $i > 0 ? ($slug . $sep . $i) : $slug;
        }
        return $inputSlug;
    }

    private function flattenArray($array, $key)
    {
        $result = array();
        foreach ($array as $subarray) {
            $result[] = $subarray[$key];
        }
        return $result;
    }

    private function getHugeRTE()
    {

        $viewMeta = service('viewMeta');
        $viewMeta->addScript([
			'src'=> 'https://cdn.jsdelivr.net/npm/hugerte@1/hugerte.min.js',
            'referrerpolicy' => 'origin'
        ]);
        $script = view('\App\Modules\Pages\Views\_hugerte', [
            'locale' => $this->request->getLocale(),
            'url' => $this->adminLink . 'validateField/content',
        ]);
        $viewMeta->addRawScript($script);
    }
}
