<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerbaikanSelesai extends Model
{
    use HasFactory;
    protected $table = 'perbaikan_selesai';
    protected $guarded = [];

    public  function kerusakan(): BelongsTo
    {
        return $this->BelongsTo(Kerusakan::class, 'id_kerusakan');
    }
    public  function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
}
