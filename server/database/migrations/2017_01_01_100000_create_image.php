<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain',32)->default('global');
            $table->string('slug',32);
            $table->integer('index')->default(0);
            $table->string('profile',32)->default('org');
            $table->string('density',32)->default('org');
            $table->string('ext',8);
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->enum('attached',['TRUE','FALSE'])->default('TRUE');
            $table->integer('parent_id')->nullable()->index();
            $table->timestamps();
            $table->unique(['domain','slug','index','profile','density']);
        });
        DB::statement("ALTER TABLE images ADD bytes LONGBLOB NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
