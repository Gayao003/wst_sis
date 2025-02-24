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
        'total_grade',
        'status',
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
            if ($grade->status === 'FDA') {
                $grade->total_grade = 5.00;
                $grade->remarks = 'Failed (FDA)';
                return;
            }

            if ($grade->status === 'LOA') {
                $grade->total_grade = null;
                $grade->remarks = 'Leave of Absence';
                return;
            }

            if ($grade->status === 'INC') {
                $grade->total_grade = null;
                $grade->remarks = 'Incomplete';
                return;
            }

            if ($grade->midterm && $grade->final) {
                // If either grade is above 3.00, set total grade to 5.00
                if ($grade->midterm > 3.00 || $grade->final > 3.00) {
                    $grade->total_grade = 5.00;
                    $grade->remarks = 'Failed';
                    return;
                }

                // Calculate average for passing grades
                $average = ($grade->midterm + $grade->final) / 2;
                
                // Round up to next 0.25
                $grade->total_grade = ceil($average * 4) / 4;
                
                // Set remarks
                $grade->remarks = $grade->total_grade <= 3.00 ? 'Passed' : 'Failed';
            }
        });
    }
}
