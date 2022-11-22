<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Users extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    /**
     * @return HasOne
     * @description get the credential associated with the User
     */
    public function credentials(): HasOne
    {
        return $this->hasOne(Credentials::class, 'userid');
    }
}
