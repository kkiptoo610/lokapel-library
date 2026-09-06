<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'inventory_category_id',

        'name',

        'unit',

        'quantity',

        'minimum_quantity',

        'description',

    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'quantity' => 'integer',

        'minimum_quantity' => 'integer',

    ];


    /*
    |--------------------------------------------------------------------------
    | Category Relationship
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(

            InventoryCategory::class,

            'inventory_category_id'

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Issue History Relationship
    |--------------------------------------------------------------------------
    */

    public function issues()
    {
        return $this->hasMany(

            InventoryIssue::class,

            'inventory_item_id'

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Restock History Relationship
    |--------------------------------------------------------------------------
    */

    public function restocks()
    {
        return $this->hasMany(

            InventoryRestock::class,

            'inventory_item_id'

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Stock Status
    |--------------------------------------------------------------------------
    |
    | Possible values:
    |
    | - out_of_stock
    | - critical
    | - low
    | - good
    |
    */

    public function getStockStatusAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | Out Of Stock
        |--------------------------------------------------------------------------
        */

        if ($this->quantity <= 0) {

            return 'out_of_stock';

        }


        /*
        |--------------------------------------------------------------------------
        | Critical Stock
        |--------------------------------------------------------------------------
        |
        | Critical means the item has less than or equal to
        | half of its configured minimum quantity.
        |
        */

        $criticalLevel = max(

            1,

            (int) floor(

                $this->minimum_quantity / 2

            )

        );


        if ($this->quantity <= $criticalLevel) {

            return 'critical';

        }


        /*
        |--------------------------------------------------------------------------
        | Low Stock
        |--------------------------------------------------------------------------
        |
        | The quantity has reached the configured minimum quantity.
        |
        */

        if ($this->quantity <= $this->minimum_quantity) {

            return 'low';

        }


        /*
        |--------------------------------------------------------------------------
        | Good Stock
        |--------------------------------------------------------------------------
        */

        return 'good';
    }


    /*
    |--------------------------------------------------------------------------
    | Is Low Stock
    |--------------------------------------------------------------------------
    |
    | Returns true when:
    |
    | - Quantity is greater than zero.
    | - Quantity is less than or equal to the minimum quantity.
    | - The item is not in the critical range.
    |
    */

    public function getIsLowStockAttribute()
    {
        if ($this->quantity <= 0) {

            return false;

        }


        return $this->stock_status === 'low';
    }


    /*
    |--------------------------------------------------------------------------
    | Is Critical
    |--------------------------------------------------------------------------
    */

    public function getIsCriticalAttribute()
    {
        return $this->stock_status === 'critical';
    }


    /*
    |--------------------------------------------------------------------------
    | Is Out Of Stock
    |--------------------------------------------------------------------------
    */

    public function getIsOutOfStockAttribute()
    {
        return $this->stock_status === 'out_of_stock';
    }


    /*
    |--------------------------------------------------------------------------
    | Is Good Stock
    |--------------------------------------------------------------------------
    */

    public function getIsGoodStockAttribute()
    {
        return $this->stock_status === 'good';
    }


    /*
    |--------------------------------------------------------------------------
    | Remaining Stock Percentage
    |--------------------------------------------------------------------------
    |
    | This can later be used for progress bars and visual
    | inventory indicators.
    |
    */

    public function getStockPercentageAttribute()
    {
        if ($this->minimum_quantity <= 0) {

            return 100;

        }


        $recommendedMaximum =

            $this->minimum_quantity * 3;


        if ($recommendedMaximum <= 0) {

            return 100;

        }


        $percentage =

            ($this->quantity / $recommendedMaximum)

            * 100;


        return max(

            0,

            min(

                100,

                round($percentage)

            )

        );
    }
}