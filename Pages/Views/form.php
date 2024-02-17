<?php $this->extend('master') ?>

<?php $this->section('main') ?>
<x-page-head>
    <a href="<?= site_url(ADMIN_AREA . '/pages') ?>" class="back">&larr; <?= lang('Pages.pageTitle') ?></a>
    <h2><?= isset($page) ? lang('Pages.editPage') : lang('Pages.newPage') ?></h2>
</x-page-head>

<?php if (isset($page) && $page->deleted_at !== null) : ?>
    <div class="alert danger">
        <?= lang('Pages.pageWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($page->deleted_at)->humanize() ?>.
        <a href="<?= url_to('recycler-restore', 'pages', $page->id) ?>"><?= lang('Pages.restorePage')?></a>
    </div>
<?php endif; ?>

<x-admin-box>
    <form action="<?= $adminLink . 'save' ?>" method="post">
        <?= csrf_field() ?>

        <?php if (isset($page) && $page !== null) : ?>
            <input type="hidden" name="id" value="<?= $page->id ?>">
        <?php endif ?>

        <div class="row">
            <!-- Title -->
            <div class="form-group col-12 col-lg-6">
                <label for="title" class="form-label"><?= lang('Pages.title') ?></label>
                <input type="text" hx-target="#title_error" hx-post="<?= $adminLink . 'validateField/title' ?>" name="title" class="form-control" autocomplete="title" value="<?= old('title', $page->title ?? '') ?>">
                <p id="title_error" class="text-danger"><?php if (has_error('title')) echo error('title') ?></p>
            </div>

            <!-- URL slug -->
            <?php if (isset($page) && $page !== null) : ?>
                <div class="form-group col-12 col-lg-6">
                    <label for="slug" class="form-label"><?= lang('Pages.urlSlug') ?></label>
                    <input type="text" hx-target="#slug_error" hx-trigger="keyup changed delay:500ms" hx-post="<?= $adminLink . 'validateField/slug' ?>" name="slug" class="form-control form-control-sm" autocomplete="slug" value="<?= old('slug', $page->slug ?? '') ?>">
                    <p id="slug_error" class="text-danger"><?php if (has_error('slug')) echo error('slug') ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <!-- Content -->
            <div class="form-group col-12">
                <label for="content" class="form-label"><?= lang('Pages.content') ?></label>
                <textarea id="content" name="content" hx-target="#content_error" hx-post="<?= $adminLink . 'validateField/content' ?>" class="form-control" rows="5" autocomplete="content"><?= old('content', $page->content ?? '') ?></textarea>
                <p id="content_error" class="text-danger"><?php if (has_error('content')) echo error('content') ?></p>
            </div>
        </div>

        <div class="row">
            <!-- Category -->
            <div class="form-group col-12 col-sm-6">
                <label for="category" class="form-label"><?= lang('Pages.category') ?></label>
                <select name="category" class="form-select">
                    <?php foreach ($pageCategories as $key => $value) : ?>
                        <option value="<?= $key ?>" <?php if (isset($page) && $page->category == $key) : ?> selected <?php endif ?>>
                            <?= $value ?>
                        </option>
                    <?php endforeach ?>
                </select>

                <?php if (has_error('category')) : ?>
                    <p class="text-danger"><?= error('category') ?></p>
                <?php endif ?>
            </div>
        </div>


        <div class="text-end py-3">
            <input type="submit" value="<?= lang('Pages.savePage') ?>" class="btn btn-primary btn-lg">
        </div>

    </form>

</x-admin-box>

<?php $this->endSection() ?>
