<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formations extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'duree',
        'prix',
    ];
    public function contenusFormation()
    {
        return $this->hasMany(ContenusFormation::class, 'formation_id');
    }
    
}

