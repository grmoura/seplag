<?php

namespace App\Models;

use FFI;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorEfetivo extends Model
{
    use HasFactory;

    protected $table = 'servidor_efetivo';
    protected $primaryKey = 'pes_id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'pes_id',
        'se_matricula',
    ];
    protected $hidden = ['updated_at', 'created_at'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id');
    }

}
