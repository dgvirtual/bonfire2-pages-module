<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Pages.id'),
        'title'         => lang('Pages.title'),
        'excerpt'       => lang('Pages.excerpt'),
        'updated_at'    => lang('Pages.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $page) : ?>
            <tr>
                <?= view('App\Modules\Pages\Views\_row_info', ['page' => $page]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>