<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unidade_endereco', function (Blueprint $table) {
            $table->unsignedBigInteger('unid_id');
            $table->unsignedBigInteger('end_id');
            $table->primary(['unid_id', 'end_id']);
            $table->timestamps();
    
            $table->foreign('unid_id')->references('unid_id')->on('unidade')->onDelete('restrict');
            $table->foreign('end_id')->references('end_id')->on('endereco')->onDelete('restrict');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('unidade_endereco');
    }
    
};
