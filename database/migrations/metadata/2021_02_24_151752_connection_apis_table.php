<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectionApisTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_apis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connection_id');
            $table->string('endpoint_read')->nullable();
            $table->string('endpoint_write')->nullable();
            $table->string('endpoint_delete')->nullable();
            $table->string('data_processor')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('connection_id', 'connection_apis_connection_id_fkey')
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
        Schema::dropIfExists('connection_apis');
    }
}
