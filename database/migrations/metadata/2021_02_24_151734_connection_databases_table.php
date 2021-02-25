<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectionDatabasesTable extends Migration
{

    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_databases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connection_id');
            $table->string('host');
            $table->integer('port');
            $table->string('db_type');
            $table->string('db_name');
            $table->string('db_schema');
            $table->string('db_user');
            $table->string('db_password');
            $table->string('db_table');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('connection_id', 'connection_databases_connection_id_fkey')
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
        Schema::dropIfExists('connection_databases');
    }
}
