<?php

Breadcrumbs::for('admin.menu.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.menu.management'), route('admin.menu.index'));
});
