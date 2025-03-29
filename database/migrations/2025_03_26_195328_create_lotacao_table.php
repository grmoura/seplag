<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lotacao', function (Blueprint $table) {
            $table->id('lot_id');
            $table->unsignedBigInteger('pes_id');
            $table->unsignedBigInteger('unid_id');
            $table->date('lot_data_lotacao');
            $table->date('lot_data_remocao')->nullable();
            $table->string('lot_portaria', 200);
            $table->timestamps();
    
            $table->foreign('pes_id')->references('pes_id')->on('pessoa')->onDelete('cascade');
            $table->foreign('unid_id')->references('unid_id')->on('unidade')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lotacao');
    }
};
