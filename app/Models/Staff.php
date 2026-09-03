<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
    ];

    /**
     * Get all borrowing records for this staff member.
     */
    public function borrowings()
    {
        return $this->morphMany(Borrowing::class, 'borrower');
    }
}
