<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absences extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'time',
        'reason'
    ];
    /**
     * Get all of the comments for the Absences
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
