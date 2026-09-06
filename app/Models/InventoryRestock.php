<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRestock extends Model
{
    use HasFactory;


    protected $fillable = [

        'inventory_item_id',

        'quantity',

        'restocked_date',

        'remarks',

    ];


    protected $casts = [

        'restocked_date' => 'date',

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function item()
    {
        return $this->belongsTo(
            InventoryItem::class,
            'inventory_item_id'
        );
    }
}