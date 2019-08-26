<?php

return [
    // Commenter settings
    'commenter' => [
        'cascade_on_delete' => false,

        'table' => [
            'name' => 'users',
            'primary_key' => 'id',
        ],

        'model' => env('COMMENT_COMMENTER_MODEL', config('auth.providers.users.model')),
    ],

    // comments media settings
    'media' => [
        'thumb' => [
            'width' => env('COMMENT_MEDIA_THUMB_WIDTH', 200),
            'height' => env('COMMENT_MEDIA_THUMB_HEIGHT', 200),
        ],
    ],
];
