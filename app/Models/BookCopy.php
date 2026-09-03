<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'accession_number',
        'copy_number',
        'status',
    ];


    /**
     * The main book this physical copy belongs to.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }


    /**
     * Borrowing records for this physical copy.
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }


    /**
     * Check whether the copy is available.
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}