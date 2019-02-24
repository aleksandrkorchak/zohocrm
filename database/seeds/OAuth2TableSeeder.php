<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuth2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth2')->insert([
            'client_id' => null,
            'client_secret' => null,
            'redirect_uri' => null,
            'scope' => null,
            'response_type' => null,
            'access_type' => null,
            'code' => null,
            'code_updated_at' => null,
            'code_expires_in_sec' => null,
            'grant_type' => null,
            'access_token' => null,
            'access_token_updated_at' => null,
            'access_token_expires_in_sec' => null,
            'refresh_token' => null,
            'back_route' => null,
            'created_at' => '2019-02-02 00:00:00',
            'updated_at' => '2019-02-03 00:00:00'
        ]);
    }
}
