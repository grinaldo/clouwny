<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Province;
use App\Model\City;
use App\Model\District;

class SicepatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sicepat:getmeta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Sicepat address data from API';

    /**
     * Sicepat destination Endpoint
     */
    protected $destEndpoint;

    /**
     * Sicepat API username
     */
    protected $apiUsername;

    /**
     * Sicepat API Key
     */
    protected $apiKey;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->destEndpoint = env('SICEPAT_API_DESTINATION_ENDPOINT');
        $this->apiUsername  = env('Clouwny');
        $this->apiKey       = env('SICEPAT_API_KEY');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $this->destEndpoint.'?api-key='.$this->apiKey);
        if ($res->getStatusCode() == 200) {
            $response = json_decode((string)$res->getBody(), true);
            foreach ($response['sicepat']['results'] as $value) {
                $province = Province::firstOrCreate(['name' => $value['province']]);
                $city     = City::firstOrCreate([
                    'province_id' => $province->id,
                    'name'        => $value['city']
                ]);
                $district = District::firstOrCreate([
                    'city_id' => $city->id,
                    'name'    => $value['subdistrict'],
                    'code'    => $value['destination_code']
                ]);
            }
        }
    }
}
