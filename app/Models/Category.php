<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [

        'name',

        'description',

        'parent_id',

    ];


    /**
     * Parent category.
     *
     * A subcategory belongs to one main category.
     */
    public function parent()
    {
        return $this->belongsTo(
            self::class,
            'parent_id'
        );
    }


    /**
     * Child categories / subcategories.
     *
     * A main category can have many subcategories.
     */
    public function children()
    {
        return $this->hasMany(
            self::class,
            'parent_id'
        )
        ->orderBy(
            'name'
        );
    }


    /**
     * Books assigned directly to this category.
     *
     * Uses books.category_id.
     */
    public function books()
    {
        return $this->hasMany(
            Book::class,
            'category_id'
        );
    }


    /**
     * Books assigned to this category as a subcategory.
     *
     * Uses books.subcategory_id.
     */
    public function subcategoryBooks()
    {
        return $this->hasMany(
            Book::class,
            'subcategory_id'
        );
    }


    /**
     * Check if this is a main category.
     */
    public function isMainCategory()
    {
        return is_null(
            $this->parent_id
        );
    }


    /**
     * Check if this is a subcategory.
     */
    public function isSubcategory()
    {
        return !is_null(
            $this->parent_id
        );
    }
}