<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Commenter Settings
    |--------------------------------------------------------------------------
    |
    | when deleting a user from users table, all comments comes to him will be
    | deleted if cascade_on_delete set to true
    |
    | `table` setting will be used to table migrations.
    |
    | The `model` is point to the commenter relationship
    | And you can use your own user model
    |
    */

    'commenter' => [
        'table' => [
            'name'              => 'users',
            'primary_key'       => 'id',
            'cascade_on_delete' => false,
        ],

        'model' => config('auth.providers.users.model'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Settings
    |--------------------------------------------------------------------------
    |
    | add or reply a comment can also upload one or more medias.
    | A thumb will be generated for the medias, and can be used for
    | comment list
    |
    | You can specific the width and height here for the uploaded medias
    |
    */
    'media' => [
        'thumb' => [
            'width'  => env('AIO_COMMENT_MEDIA_THUMB_WIDTH', 200),
            'height' => env('AIO_COMMENT_MEDIA_THUMB_HEIGHT', 200),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Settings
    |--------------------------------------------------------------------------
    |
    | You can use your own comment model here for extending functions
    |
    */
    'model' => Comcsoft\Comment\Models\Comment::class,
];
