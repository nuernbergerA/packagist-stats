<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];
    protected function casts(): array
    {
        return [
            'downloads' => 'integer',
            'favers' => 'integer',
            'type' => 'string',
            'version_string' => 'string',
            'min_version' => 'string',
            'max_version' => 'string',
            'last_released_at' => 'immutable_datetime',
            'checked_at' => 'immutable_datetime',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
