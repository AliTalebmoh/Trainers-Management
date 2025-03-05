<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'formateur_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'price_per_hour',
        'duration_month'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'float',
        'price_per_hour' => 'decimal:2'
    ];

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }
}
