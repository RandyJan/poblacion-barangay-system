<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('certificate_requirements', function (Blueprint $table) {
        $table->id();

        // FK to certificate_requests.request_id
        $table->unsignedBigInteger('request_id');

        $table->unsignedBigInteger('certificate_id');
        $table->string('image_path');
        $table->timestamps();

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
        Schema::dropIfExists('certificate_requirements');
    }
}
