<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.customer.index', function ($trail) {
    $trail->push('客服', route('admin.customer.index'));
});

Breadcrumbs::for('admin.customer.create', function ($trail) {
    $trail->parent('admin.customer.index');
    $trail->push('添加客服', route('admin.customer.create'));
});

Breadcrumbs::for('admin.customer.show', function ($trail, $id) {
    $trail->parent('admin.customer.index');
    $trail->push('查看', route('admin.customer.show', $id));
});

Breadcrumbs::for('admin.customer.edit', function ($trail, $id) {
    $trail->parent('admin.customer.index');
    $trail->push('编辑客服信息', route('admin.customer.edit', $id));
});

Breadcrumbs::for('admin.earning.index', function ($trail) {
    $trail->push('网赚', route('admin.earning.index'));
});

Breadcrumbs::for('admin.earning.create', function ($trail) {
    $trail->parent('admin.earning.index');
    $trail->push('添加', route('admin.earning.create'));
});

Breadcrumbs::for('admin.earning.show', function ($trail, $id) {
    $trail->parent('admin.earning.index');
    $trail->push('查看', route('admin.earning.show', $id));
});

Breadcrumbs::for('admin.earning.edit', function ($trail, $id) {
    $trail->parent('admin.earning.index');
    $trail->push('编辑信息', route('admin.earning.edit', $id));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
require __DIR__.'/menu.php';
require __DIR__.'/category.php';
