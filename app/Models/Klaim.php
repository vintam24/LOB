<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    use HasFactory;
    protected $table = 'klaim';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sub_cob',
        'penyebab_klaim',
        'periode',
        'nilai_beban_klaim',
    ];

    protected $casts = [
        'periode' => 'date',
        'nilai_beban_klaim' => 'decimal:2',
    ];
}
