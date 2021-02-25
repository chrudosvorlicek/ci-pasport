<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectionsTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('connection_type_id');
            $table->string('comment')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('connection_type_id', 'connections_connection_type_id_fkey')
                ->references('id')->on('connection_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connections');
    }
}
