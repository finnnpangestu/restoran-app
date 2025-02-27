<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama_menu', 'harga', 'kategori'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
