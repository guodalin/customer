<?php

Breadcrumbs::for('aio-exam::admin.question.index', function ($trail) {
    $trail->push(__('aio-exam::labels.backend.question.management'), route('aio-exam::admin.question.index'));
});
