<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_class');
            $table->integer('model_id')->index();
            $table->string('key',255);
            $table->string('locale', 2);
            $table->text('value');
            $table->timestamps();
            $table->unique(['model_class', 'model_id','locale','key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
