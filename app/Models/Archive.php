<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion','nombre_origen','extension','ruta','document_id'];

    public function document(){
        return $this->belongsTo(Document::class);
    }
}
