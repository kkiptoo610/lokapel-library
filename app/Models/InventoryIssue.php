<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryIssue extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'inventory_item_id',
        'teacher_id',
        'department',
        'quantity',
        'issued_date',
        'remarks',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'quantity' => 'integer',
        'issued_date' => 'date',
    ];


    /*
    |--------------------------------------------------------------------------
    | Inventory Item Relationship
    |--------------------------------------------------------------------------
    */

    public function item()
    {
        return $this->belongsTo(
            InventoryItem::class,
            'inventory_item_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Teacher Relationship
    |--------------------------------------------------------------------------
    */

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Recipient Name
    |--------------------------------------------------------------------------
    |
    | Returns the teacher's name when an item is issued directly
    | to a teacher. Otherwise, returns the department.
    |
    */

    public function getRecipientNameAttribute()
    {
        if ($this->teacher) {
            return $this->teacher->name;
        }

        if ($this->department) {
            return $this->department;
        }

        return 'Not specified';
    }


    /*
    |--------------------------------------------------------------------------
    | Recipient Type
    |--------------------------------------------------------------------------
    */

    public function getRecipientTypeAttribute()
    {
        if ($this->teacher_id) {
            return 'Teacher';
        }

        if ($this->department) {
            return 'Department';
        }

        return 'Unknown';
    }


    /*
    |--------------------------------------------------------------------------
    | Issue Summary
    |--------------------------------------------------------------------------
    */

    public function getIssueSummaryAttribute()
    {
        $itemName = $this->item
            ? $this->item->name
            : 'Unknown Item';

        return $this->quantity
            . ' '
            . ($this->item?->unit ?? 'item(s)')
            . ' of '
            . $itemName;
    }
}