<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbUsuario extends Migration
{
    public function up()
    {
        Schema::table('tb_usuario', function (Blueprint $table) {

            $table->integer(
                'co_usuario',
                true,
                true
            );
            #@todo está como text
            $table->string('no_cpf', 11)->unique();
            $table->string('no_email', 255)->unique();
            $table->string('ds_senha', 255);
            $table->date('dt_nascimento');
            $table->string('ds_codigo_ativacao', 255);
            $carbon = Carbon\Carbon::now();
            $dataEhorarioAtual = $carbon->toDateTimeString();
            #@todo está como date deve ser datetime
            $table->datetime('dt_cadastro')->default($dataEhorarioAtual);
            $table->datetime('dt_ultima_atualizacao')->default($dataEhorarioAtual);
            $table->boolean('st_ativo')->default(false);

        });
    }

    public function down()
    {
        Schema::drop('tb_usuario');
    }
}
