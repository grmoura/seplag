<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorTemporario extends Model
{
    use HasFactory;

    protected $table = 'servidor_temporario';
    protected $primaryKey = 'pes_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'pes_id',
        'st_data_admissao',
        'st_data_demissao',
    ];
    protected $hidden = ['updated_at', 'created_at'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }
}
