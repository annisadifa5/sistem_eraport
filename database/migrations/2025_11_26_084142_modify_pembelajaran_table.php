<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pembelajaran', function (Blueprint $table) {

        // $table->integer('id_mapel')->unsigned()->change();
        // $table->integer('id_kelas')->unsigned()->change();
        // $table->integer('id_guru')->unsigned()->change();
    });
}

public function down()
{
    Schema::table('pembelajaran', function (Blueprint $table) {
        // rollback optional (biarkan kosong juga bila tidak ada perubahan)
    });
}

};
