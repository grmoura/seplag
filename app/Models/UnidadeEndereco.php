<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeEndereco extends Model
{
    use HasFactory;

    protected $table = 'unidade_endereco';
    public $timestamps = false;

    protected $fillable = [
        'unid_id',
        'end_id',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id');
    }
}
