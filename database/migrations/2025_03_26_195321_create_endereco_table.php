<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->id('end_id');
            $table->string('end_tipo_logradouro', 50);
            $table->string('end_logradouro', 200);
            $table->integer('end_numero')->nullable();
            $table->string('end_bairro', 100)->nullable();
            $table->unsignedBigInteger('cid_id');
            $table->timestamps();

            $table->foreign('cid_id')->references('cid_id')->on('cidade')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('endereco');
    }
};
