<?php

Breadcrumbs::for('admin.photo-events.index', function ($trail) {
    $trail->push(__('labels.backend.access.photo-events.management'), route('admin.photo-events.index'));
});

Breadcrumbs::for('admin.photo-events.create', function ($trail) {
    $trail->parent('admin.photo-events.index');
    $trail->push(__('labels.backend.access.photo-events.management'), route('admin.photo-events.create'));
});

/*Breadcrumbs::for('admin.photo-events.edit', function ($trail, $id) {
    $trail->parent('admin.photo-events.index');
    $trail->push(__('labels.backend.access.photo-events.management'), route('admin.photo-events.edit', $id));
});*/
Breadcrumbs::for('admin.photo-events.edit', function ($trail, $id) {
    $trail->parent('admin.photo-events.index');
    $trail->push(__('labels.backend.access.photo-events.management'), route('admin.photo-events.edit', $id));
});

Breadcrumbs::for('admin.photo-events.qrcodegenrate', function ($trail, $id) {
    $trail->parent('admin.photo-events.index');
    $trail->push(__('qrcode'), route('admin.photo-events.qrcodegenrate', $id));
});



