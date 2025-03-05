<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'formateur_id',
        'price_per_hour',
        'total_hours',
        'total_amount'
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'total_hours' => 'float',
        'total_amount' => 'decimal:2'
    ];

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class, 'formateur_id');
    }
}
