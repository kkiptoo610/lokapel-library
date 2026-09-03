<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',

        'description',

        'parent_id',

    ];


    /**
     * Parent category.
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
     */
    public function books()
    {
        return $this->hasMany(
            Book::class,
            'category_id'
        );
    }


    public function isMainCategory()
    {
        return is_null(
            $this->parent_id
        );
    }


    public function isSubcategory()
    {
        return !is_null(
            $this->parent_id
        );
    }
}