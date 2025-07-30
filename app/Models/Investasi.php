<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investasi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis',
        'keterangan',
        'jumlah'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
