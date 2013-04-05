<?php

class CreateSeonnet extends Migration
{
  public function up()
  {
    Schema::create('seonnet', function($table) {
      $table->increments('id');
        $table->string('route');
        $table->string('slug');
        $table->string('title');
        $table->text('meta');
        $table->string('lang');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('seonnet');
  }
}
