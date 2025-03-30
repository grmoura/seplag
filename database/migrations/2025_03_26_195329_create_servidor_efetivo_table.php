<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servidor_efetivo', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id');
            $table->string('se_matricula', 20)->unique();
            $table->timestamps();
    
            $table->foreign('pes_id')->references('pes_id')->on('pessoa')->onDelete('restrict');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('servidor_efetivo');
    }
    
};
