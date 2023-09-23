<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setoran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nasabah_id', 'number', 'total_weight', 'total_income', 'notes'
    ];

    public function nasabah(): BelongsTo{
        return $this->belongsTo(Nasabah::class);
    }

    public function items(): HasMany {
        return $this->hasMany(SetoranItem::class);
    }
}
