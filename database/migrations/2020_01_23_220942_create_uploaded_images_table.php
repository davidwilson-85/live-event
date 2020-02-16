<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // 'caption' is a short (256 chars?) text that can optionally uploaded with the image

        Schema::create('uploaded_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('file_name');
            $table->string('caption');
            $table->integer('nbr_views');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploaded_images');
    }
}
