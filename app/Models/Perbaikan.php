<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perbaikan extends Model
{
    use HasFactory;
    protected $table = 'perbaikan';
    protected $guarded = [];

    public  function fasilitas(): BelongsTo
    {
        return $this->BelongsTo(Fasilitas::class, 'id_fasilitas');
    }
    public  function kerusakan(): BelongsTo
    {
        return $this->BelongsTo(Kerusakan::class, 'id_kerusakan');
    }
    public  function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
}
