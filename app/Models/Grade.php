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
        'grade',
        'remarks'
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
                $grade->grade = ($grade->midterm + $grade->final) / 2;
                
                // BukSU Grading System
                if ($grade->grade >= 97) $grade->remarks = '1.00';
                elseif ($grade->grade >= 94) $grade->remarks = '1.25';
                elseif ($grade->grade >= 91) $grade->remarks = '1.50';
                elseif ($grade->grade >= 88) $grade->remarks = '1.75';
                elseif ($grade->grade >= 85) $grade->remarks = '2.00';
                elseif ($grade->grade >= 82) $grade->remarks = '2.25';
                elseif ($grade->grade >= 79) $grade->remarks = '2.50';
                elseif ($grade->grade >= 76) $grade->remarks = '2.75';
                elseif ($grade->grade >= 75) $grade->remarks = '3.00';
                else $grade->remarks = '5.00';
            }
        });
    }
}
