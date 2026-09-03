<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'admission_number',
        'assessment_number',
        'grade_class',
        'stream',
    ];

    /**
     * Get all borrowing records for this learner.
     */
    public function borrowings()
    {
        return $this->morphMany(Borrowing::class, 'borrower');
    }
}
