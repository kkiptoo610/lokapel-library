<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;


    /**
     * Mass assignable attributes.
     */
    protected $fillable = [

        'title',

        'book_code',

        'author',

        'isbn',

        'category_id',

        'subcategory_id',

        'publisher',

        'publication_year',

        'total_copies',

        'available_copies',

        'shelf_location',

    ];


    /**
     * Main category of this book.
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }


    /**
     * Subcategory of this book.
     *
     * Subcategories are also stored in the categories table.
     */
    public function subcategory()
    {
        return $this->belongsTo(
            Category::class,
            'subcategory_id'
        );
    }


    /**
     * Get all borrowing records for this book.
     */
    public function borrowings()
    {
        return $this->hasMany(
            Borrowing::class
        );
    }


    /**
     * Get all individual physical copies of this book.
     */
    public function copies()
    {
        return $this->hasMany(
            BookCopy::class
        );
    }


    /**
     * Get all available physical copies.
     */
    public function availableCopies()
    {
        return $this
            ->hasMany(
                BookCopy::class
            )
            ->where(
                'status',
                'available'
            );
    }
}