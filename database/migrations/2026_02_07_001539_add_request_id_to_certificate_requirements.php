<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestIdToCertificateRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('certificate_requirements', function (Blueprint $table) {
        $table->unsignedBigInteger('request_id')->after('id');

        $table->foreign('request_id')
              ->references('request_id')
              ->on('certificate_requests')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('certificate_requirements', function (Blueprint $table) {
        $table->dropForeign(['request_id']);
        $table->dropColumn('request_id');
    });
    }
}
