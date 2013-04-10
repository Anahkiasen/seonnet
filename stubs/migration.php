<?php

class CreateSeonnet extends Migration
{
  public function up()
  {
    Schema::create('seonnet', function($table) {
      $table->increments('id');
        $table->string('name');
        $table->string('pattern');
        $table->string('title');
        $table->text('meta');
        $table->string('url');
        $table->string('lang');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('seonnet');
  }
}
