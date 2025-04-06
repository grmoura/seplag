<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidade';
    protected $primaryKey = 'unid_id';
    public $timestamps = true;

    protected $fillable = [
        'unid_nome',
        'unid_sigla',
    ];
    protected $hidden = ['updated_at', 'created_at'];

    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'unidade_endereco', 'unid_id', 'end_id');
    }

    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'unid_id');
    }
}
