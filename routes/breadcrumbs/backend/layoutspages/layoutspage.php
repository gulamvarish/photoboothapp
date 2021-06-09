<?php

Breadcrumbs::for('admin.layoutspages.index', function ($trail) {
    $trail->push(__('labels.backend.access.layoutspages.management'), route('admin.layoutspages.index'));
});

Breadcrumbs::for('admin.layoutspages.create', function ($trail) {
    $trail->parent('admin.layoutspages.index');
    $trail->push(__('labels.backend.access.layoutspages.management'), route('admin.layoutspages.create'));
});

Breadcrumbs::for('admin.layoutspages.edit', function ($trail, $id) {
    $trail->parent('admin.layoutspages.index');
    $trail->push(__('labels.backend.access.layoutspages.management'), route('admin.layoutspages.edit', $id));
});





