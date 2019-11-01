<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Attribute\RoleAttribute;
use App\Models\Auth\Traits\Method\RoleMethod;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 */
class Role extends SpatieRole
{
    use LogsActivity,
        RoleAttribute,
        RoleMethod;

    /*-------------------------------------------
     * Attributes to log the event.
     */
    protected static $logName = 'system';

    protected static $logAttributes = ['name'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    // ------------------------------------------
}
