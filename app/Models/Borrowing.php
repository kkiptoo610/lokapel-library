<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;


    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [

        'book_id',

        'book_copy_id',

        'borrower_id',

        'borrower_type',

        'borrowed_date',

        'due_date',

        'returned_date',

        'status',

        'return_condition',

        'damage_description',

    ];


    /**
     * Get the main book associated with this borrowing.
     *
     * This relationship gives access to:
     * $borrowing->book->book_code
     */
    public function book()
    {
        return $this->belongsTo(
            Book::class
        );
    }


    /**
     * Get the exact physical book copy associated
     * with this borrowing.
     *
     * This relationship gives access to:
     * $borrowing->bookCopy->accession_number
     */
    public function bookCopy()
    {
        return $this->belongsTo(
            BookCopy::class
        );
    }


    /**
     * Get the borrower.
     *
     * The borrower can be a Learner, Teacher or Staff member.
     */
    public function borrower()
    {
        return $this->morphTo();
    }
}