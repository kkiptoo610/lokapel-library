<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'department',
        'position',
    ];

    /**
     * Get all borrowing records for this teacher.
     */
    public function borrowings()
    {
        return $this->morphMany(
            Borrowing::class,
            'borrower'
        );
    }
}