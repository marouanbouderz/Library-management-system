<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinePaidToRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->string('Fine_Paid')->default('No')->after('Read');
        });
    }

    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('Fine_Paid');
        });
    }
}
