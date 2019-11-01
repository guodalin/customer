<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы вывода оповещений
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются для вывода
    | сообщений в различных сценариях CRUD.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'Новая роль создана.',
            'deleted' => 'Роль удалена.',
            'updated' => 'Роль обновлена.',
        ],
        'users' => [
            'cant_resend_confirmation' => 'В настоящее время приложение настроено на одобрение пользователей вручную.',
            'confirmation_email'       => 'Новые параметры для подтверждения отправлены на Ваш E-mail.',
            'confirmed'                => 'Пользователь подтвержден.',
            'created'                  => 'Новый пользователь создан.',
            'deleted'                  => 'Пользователь удален.',
            'deleted_permanently'      => 'Пользователь удален навсегда.',
            'restored'                 => 'Пользователь восстановлен.',
            'session_cleared'          => 'Сессия пользователя очищена.',
            'social_deleted'           => 'Социальная учетная запись успешно удалена',
            'unconfirmed'              => 'Пользователь изменен на статус не подтвержден',
            'updated'                  => 'Параметры пользователя обновлены.',
            'updated_password'         => 'Пароль пользователя обновлен.',
        ],
    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Спасибо! Ваша информация принята и будет обработанна в ближайшее время.',
        ],
    ],
];
