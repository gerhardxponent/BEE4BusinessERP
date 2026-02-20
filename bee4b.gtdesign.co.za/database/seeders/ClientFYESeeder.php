<?php

namespace Database\Seeders;

use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClientFYESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Clients::all() as $client) {
            if($client->fye !== null) {
                $client->fye_id = Carbon::parse($client->fye)->month;
                $client->save();
            }
        }
    }
}
