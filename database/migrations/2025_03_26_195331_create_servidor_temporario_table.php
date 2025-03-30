<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servidor_temporario', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id');
            $table->date('st_data_admissao');
            $table->date('st_data_demissao')->nullable();
            $table->timestamps();
    
            $table->primary('pes_id');
            $table->foreign('pes_id')->references('pes_id')->on('pessoa')->onDelete('restrict');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('servidor_temporario');
    }
    
};
