<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'tokens';
    protected $fillable = [
        'account_id',
        'access_token',
        'refresh_token',
        'expires_in',
        'base_domain',
    ];
    public $timestamps = false;
}
