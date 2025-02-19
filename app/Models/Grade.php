<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'enrollment_id',
        'midterm',
        'final',
        'total_grade'
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            if ($grade->midterm && $grade->final) {
                // Calculate average
                $average = ($grade->midterm + $grade->final) / 2;
                
                // Different rounding based on grade range
                if ($average <= 3.00) {
                    // Round up to next 0.25 for passing grades
                    $grade->total_grade = ceil($average * 4) / 4;
                } else {
                    // Round down to previous 0.25 for failing grades
                    $grade->total_grade = floor($average * 4) / 4;
                }

                // Set remarks based on total grade
                $grade->remarks = $grade->total_grade <= 3.00 ? 'Passed' : 'Failed';
            }
        });
    }
}
