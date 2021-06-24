<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Leaderboard
 * @package App\Models
 */
class Leaderboard extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'leaderboard';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('');

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'age',
        'points',
        'address'
    ];
}
