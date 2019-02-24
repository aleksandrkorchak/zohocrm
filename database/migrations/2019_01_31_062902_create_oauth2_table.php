<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOAuth2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('oauth2', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 100)->nullable();
            $table->string('client_secret', 100)->nullable();
            $table->string('redirect_uri', 100)->nullable();
            $table->string('scope', 100)->nullable();
            $table->string('response_type', 10)->nullable();
            $table->string('access_type', 10)->nullable();
            $table->string('code', 100)->nullable();
            $table->timestamp('code_updated_at')->nullable();
            $table->integer('code_expires_in_sec')->nullable();
            $table->string('grant_type', 20)->nullable();
            $table->string('access_token', 100)->nullable();
            $table->timestamp('access_token_updated_at')->nullable();
            $table->integer('access_token_expires_in_sec')->nullable();
            $table->string('refresh_token', 100)->nullable();
            $table->string('back_route', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth2');
    }
}
