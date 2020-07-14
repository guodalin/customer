<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'info',
    ];

    public function scopeSearch($query, array $params)
    {
        if(isset($params['q'])){
            $query->where('name', 'like', '%'.$params['q'].'%');
        }
        return $query;
    }
}
