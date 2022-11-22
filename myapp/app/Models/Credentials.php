<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credentials extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'user_credentails';
    
    /**
     * @return BelongsTo
     * @description Get the User that owns the Credential
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'userid');
    }
}
