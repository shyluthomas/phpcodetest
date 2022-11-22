<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    /**
     * Get menus by Parent ID.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getmenusByParent($parentID){
        return Menu::where('parent', $parentID)->get();
    }
}
