<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetoranItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'setoran_id', 'jenis_sampah_id', 'quantity', 'unit_price'
    ];
}
