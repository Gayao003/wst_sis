<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'enrollment_id',
        'midterm',
        'finals',
        'final_grade',
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
            if ($grade->midterm && $grade->finals) {
                $grade->final_grade = ($grade->midterm + $grade->finals) / 2;
                
                // BukSU Grading System
                if ($grade->final_grade >= 97) $grade->remarks = '1.00';
                elseif ($grade->final_grade >= 94) $grade->remarks = '1.25';
                elseif ($grade->final_grade >= 91) $grade->remarks = '1.50';
                elseif ($grade->final_grade >= 88) $grade->remarks = '1.75';
                elseif ($grade->final_grade >= 85) $grade->remarks = '2.00';
                elseif ($grade->final_grade >= 82) $grade->remarks = '2.25';
                elseif ($grade->final_grade >= 79) $grade->remarks = '2.50';
                elseif ($grade->final_grade >= 76) $grade->remarks = '2.75';
                elseif ($grade->final_grade >= 75) $grade->remarks = '3.00';
                else $grade->remarks = '5.00';
            }
        });
    }
}
