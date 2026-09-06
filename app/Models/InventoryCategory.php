<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'type',
        'description',
    ];


    /*
    |--------------------------------------------------------------------------
    | Inventory Items Relationship
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(
            InventoryItem::class,
            'inventory_category_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Category Type Helpers
    |--------------------------------------------------------------------------
    */

    public function getIsTeachersCategoryAttribute()
    {
        return $this->type === 'teachers';
    }


    public function getIsLaboratoryCategoryAttribute()
    {
        return $this->type === 'laboratory';
    }


    /*
    |--------------------------------------------------------------------------
    | Total Quantity In Category
    |--------------------------------------------------------------------------
    */

    public function getTotalQuantityAttribute()
    {
        return $this->items()
            ->sum('quantity');
    }


    /*
    |--------------------------------------------------------------------------
    | Low Stock Items Count
    |--------------------------------------------------------------------------
    */

    public function getLowStockItemsCountAttribute()
    {
        return $this->items()
            ->whereColumn(
                'quantity',
                '<=',
                'minimum_quantity'
            )
            ->where(
                'quantity',
                '>',
                0
            )
            ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | Out Of Stock Items Count
    |--------------------------------------------------------------------------
    */

    public function getOutOfStockItemsCountAttribute()
    {
        return $this->items()
            ->where(
                'quantity',
                '<=',
                0
            )
            ->count();
    }
}