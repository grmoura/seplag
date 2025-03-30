<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaEndereco extends Model
{
    use HasFactory;

    protected $table = 'pessoa_endereco';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'pes_id',
        'end_id',
    ];
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id');
    }
}
