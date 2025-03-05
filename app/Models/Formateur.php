<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bank_account',
        'subjects',
        'bank_name'
    ];

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class, 'formateur_id');
    }

    public function salary()
    {
        return $this->hasOne(Salary::class, 'formateur_id');
    }
}
