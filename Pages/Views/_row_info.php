<td><?= esc($page->id) ?></td>
<td><?= esc($page->title) ?></td>
<td><?= esc($page->excerpt) ?></td>
<td><?= esc($page->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('pages.edit') || auth()->user()->can('pages.delete')): ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button"  data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('pages.edit')) : ?>
                    <li><a href="<?= url_to('page-edit', $page->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('pages.delete')): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="<?= url_to('page-delete', $page->id) ?>" class="dropdown-item"
                        onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Pages.page')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>
