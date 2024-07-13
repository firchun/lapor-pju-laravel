<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakan';
    protected $guarded = [];

    public  function fasilitas(): BelongsTo
    {
        return $this->BelongsTo(Fasilitas::class, 'id_fasilitas');
    }
}
