<div class="dashboard-cell-container row">
    <div class="col-12 col-xl-6">
        <div class="widget-stats bg-lime">
            <div class="widget-stats-info">
                <h3><?= $title ?></h3>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Updated</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>

                        <?php foreach ($pages as $page) : ?>
                            <tr>
                                <td scope="row"><?= $page->id ?></td>
                                <td><?= $page->title ?></td>
                                <td><?= $page->category ?></td>
                                <td><?= substr($page->updated_at, 0, 10) ?></td>
                                <td><?= substr($page->created_at, 0, 10) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <div class="widget-stats-link">
                <a href="<?= $moreLink ?>" class="btn btn-sm-primary"><?= $moreLabel ?> <i class="fa fa-arrow-alt-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>