<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_pessoa', function (Blueprint $table) {
            $table->id('fp_id');
            $table->unsignedBigInteger('pes_id');
            $table->date('fp_data')->useCurrent();
            $table->string('fp_bucket', 50);
            $table->string('fp_hash', 64);
            $table->timestamps();
    
            $table->foreign('pes_id')->references('pes_id')->on('pessoa')->onDelete('restrict');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('foto_pessoa');
    }
    
};
