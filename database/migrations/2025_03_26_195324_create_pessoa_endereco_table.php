<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pessoa_endereco', function (Blueprint $table) {
            $table->unsignedBigInteger('pes_id');
            $table->unsignedBigInteger('end_id');
            $table->primary(['pes_id', 'end_id']);
            $table->timestamps();
    
            $table->foreign('pes_id')->references('pes_id')->on('pessoa')->onDelete('restrict');
            $table->foreign('end_id')->references('end_id')->on('endereco')->onDelete('restrict');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pessoa_endereco');
    }
};
