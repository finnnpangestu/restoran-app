<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = ['pelanggan_id', 'menu_id', 'jumlah_pesanan', 'total_harga'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pesanan) {
            $menu = Menu::find($pesanan->menu_id);
            $pesanan->total_harga = $menu ? $menu->harga * $pesanan->jumlah_pesanan : 0;
        });
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
