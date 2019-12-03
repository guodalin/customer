<?php

namespace App\Models\Traits;

use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

/**
 * Hashid trait
 */
trait HashidTrait
{
    use HasHashid, HashidRouting;

    /**
     * @see parent
     */
    public function getHashidsConnection()
    {
        return property_exists($this, 'hashidConnection')
            ? $this->hashidConnection
            : config('hashids.default');
    }
}
