<form action="<?= site_url(ADMIN_AREA . '/pages/delete-batch') ?>" method="post">
    <?= csrf_field() ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <?= $this->include('_table_head') ?>
            <tbody>
            <?php if (isset($pages) && count($pages)) : ?>
                <?php foreach ($pages as $page) : ?>
                    <tr>
                        <?php if (auth()->user()->can('pages.delete')): ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $page->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Pages\Views\_row_info', ['page' => $page]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>

    <?php if (auth()->user()->can('pages.delete')) : ?>
        <x-button color="outline-danger"><?= lang('Pages.deleteSelected') ?></x-button>
    <?php endif ?>
</form>
<div class="text-center">
    <?= $pager->links('default', 'bonfire_full_hx') ?>
</div>
