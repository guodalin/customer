<?php

namespace App\UserProviders;

use Illuminate\Auth\EloquentUserProvider;

class AutoUserProvider extends EloquentUserProvider
{
    /**
     * key of auto detected
     */
    const AUTO_KEY = 'auto';

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (isset($credentials[static::AUTO_KEY]) && !empty($credentials[static::AUTO_KEY])) {
            $auto = $credentials[static::AUTO_KEY];

            if (is_email($auto)) {
                $credentials = ['email' => $auto];
            } elseif (is_mobile($auto)) {
                $credentials = ['mobile' => $auto];
            } else {
                $credentials = ['username' => $auto];
            }
        }

        return parent::retrieveByCredentials($credentials);
    }
}
