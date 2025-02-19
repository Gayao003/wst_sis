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
                $grade->total_grade = ($grade->midterm + $grade->final) / 2;
            }
        });
    }
}
