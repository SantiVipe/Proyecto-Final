<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['codigo','nombre','descripcion','stock','precio_venta'];

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }
        
    
}
