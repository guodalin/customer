<?php

Breadcrumbs::for('aio-comment::admin.comment.index', function ($trail) {
    $trail->push(__('aio-comment::backend.label.management'), route('aio-comment::admin.comment.index'));
});
