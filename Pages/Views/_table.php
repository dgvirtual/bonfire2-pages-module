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

<?php if (auth()->user()->can('pages.delete')) : ?>
    <input type="submit" value="<?= lang('Pages.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>
