<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Exam types setting
    |--------------------------------------------------------------------------
    |
    | In question section, available types are 'radio', 'checkbox', 'judge', and
    | 'text'
    | -- radio: single selection
    | -- checkbox: one or more selections
    | -- judge: as same as radio, but only two options.
    | -- text: it can not be audited by system, and should score by manual.
    |
    */

    'types' => [
        'question' => [
            'radio', 'checkbox', 'judge', 'text'
        ]
    ]
];
