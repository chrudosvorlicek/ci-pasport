<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PropertiesTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('object_type_id');
            $table->string('label');
            $table->string('column_name');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('position')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_required')->default(false);
            $table->string('default_value')->nullable();
            $table->string('mask')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('type_id','properties_type_id_fkey')
                ->references('id')->on('property_types');
            $table->foreign('object_type_id','properties_object_type_id_fkey')
                ->references('id')->on('object_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
