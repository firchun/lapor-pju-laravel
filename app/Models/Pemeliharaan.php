<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeliharaan extends Model
{
    use HasFactory;
    protected $table = 'pemeliharaan';
    protected $guarded = [];

    public  function box_control(): BelongsTo
    {
        return $this->BelongsTo(BoxControl::class, 'id_box_control');
    }
    public  function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'id_user');
    }
}