<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->unsignedBigInteger('owned_by');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('section_id');
            $table->string('page_type');
            $table->string('title')->unique();
            $table->string('slug');
            $table->text('content');
            $table->tinyInteger('restricted')->default(0);
            $table->integer('current_revision')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
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
        Schema::dropIfExists('pages');
    }
}
