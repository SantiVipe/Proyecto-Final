<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['consecutivo','cliente_id','productos','cantidad','fecha_venta','total','fecha_fin_garantia'];
    protected $casts = ['productos'=>'array','fecha_venta'=>'date'];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }


}
