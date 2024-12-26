<?php $this->extend('master') ?>

<?php $this->section('main') ?>
    <x-page-head>
        <div class="row">
            <div class="col">
                <h2><?= lang('Pages.pageTitle') ?></h2>
            </div>
            <?php if (auth()->user()->can('pages.create')): ?>
                <div class="col-auto">
                    <a href="<?= url_to('page-new') ?>" class="btn btn-primary"><?= lang('Pages.newPage') ?></a>
                </div>
            <?php endif ?>
        </div>
    </x-page-head>

    <x-admin-box>
        <div x-data="{filtered: false}">
            <x-filter-link />

            <div class="row">
                <!-- List Pages -->
                <div class="col" id="content-list">
                    <?= $this->include('App\Modules\Pages\Views\_table') ?>
                </div>

                <!-- Filters -->
                <div class="col-auto" x-show="filtered" x-transition.duration.240ms>
                    <?= view_cell('Bonfire\Core\Cells\Filters::renderList', 'model=App\Modules\Pages\Models\PagesFilter target=#content-list') ?>
                </div>
            </div>
        </div>

    </x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>
