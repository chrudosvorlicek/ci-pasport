<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationsTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('relation_type');
            $table->unsignedBigInteger('pkey_object_id');
            $table->unsignedBigInteger('pkey_property_id');
            $table->unsignedBigInteger('pkey_connection_id');
            $table->unsignedBigInteger('fkey_object_id');
            $table->unsignedBigInteger('fkey_property_id');
            $table->unsignedBigInteger('fkey_connection_id');
            $table->unsignedBigInteger('pivot_connection_id');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('pkey_object_id', 'relations_pkey_object_id_fkey')
                ->references('id')->on('object_types');
            $table->foreign('pkey_property_id', 'relations_pkey_property_id_fkey')
                ->references('id')->on('properties');
            $table->foreign('pkey_connection_id', 'relations_pkey_connection_id_fkey')
                ->references('id')->on('connections');

            $table->foreign('fkey_object_id', 'relations_fkey_object_id_fkey')
                ->references('id')->on('object_types');
            $table->foreign('fkey_property_id', 'relations_fkey_property_id_fkey')
                ->references('id')->on('properties');
            $table->foreign('fkey_connection_id', 'relations_fkey_connection_id_fkey')
                ->references('id')->on('connections');

            $table->foreign('pivot_connection_id', 'relations_pivot_connection_id_fkey')
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
        Schema::dropIfExists('relations');
    }
}
