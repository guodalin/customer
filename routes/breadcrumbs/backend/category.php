<?php

Breadcrumbs::for('admin.category.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('labels.backend.category.management'), route('admin.category.index'));
});
