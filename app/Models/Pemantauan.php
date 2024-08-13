<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemantauan extends Model
{
    use HasFactory;
    protected $table = 'pemantauan';
    protected $guarded = [];
    public  function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
    public  function fasilitas(): BelongsTo
    {
        return $this->BelongsTo(Fasilitas::class, 'id_fasilitas');
    }
}
