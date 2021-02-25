<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListsTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key_column');
            $table->string('label_column');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('connection_id');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('property_id', 'lists_property_id_fkey')
                ->references('id')->on('properties');
            $table->foreign('connection_id', 'lists_connection_id_fkey')
                ->references('id')->on('connections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lists');
    }
}
