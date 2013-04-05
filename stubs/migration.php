<?php

class CreateSeonset extends Migration
{
  public function up()
  {
    Schema::create('seonset', function($table) {
      $table->increments('id');
        $table->string('route');
        $table->string('title');
        $table->text('meta');
        $table->string('lang');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('seonset');
  }
}
