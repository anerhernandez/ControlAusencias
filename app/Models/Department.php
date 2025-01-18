<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'dp_name',
    ];

        /**
         * Get all of the comments for the Department
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function user(): HasMany
        {
            return $this->hasMany(User::class);
        }
}
