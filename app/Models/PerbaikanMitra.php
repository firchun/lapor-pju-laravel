<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerbaikanMitra extends Model
{
    use HasFactory;
    protected $table = 'perbaikan_mitra';
    protected $guarded = [];

    public  function mitra(): BelongsTo
    {
        return $this->BelongsTo(Mitra::class, 'id_mitra');
    }
}
