<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyText('description')->nullable();
            $table->string('slug');
            $table->timestamps();

        });

        DB::table('roles')->insert([
            ['name' => 'admin', 'slug' => 'admin', 'description' => 'Administrator of the whole application.'],
            ['name' => 'editor', 'slug' => 'editor', 'description' => 'User can edit projects, sections and pages.'],
            ['name' => 'guest', 'slug' => 'guest', 'description' => 'User can view projects & their content behind authentication.']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
