<?php

namespace App\Http\Controllers\Admin;

use App\Model\Province as Model;
use App\Model\City;
use App\Model\District;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class ProvinceController extends ResourceController
{
    protected $sicepatUsername;
    protected $sicepatApikey;
    protected $originEndpoint;
    protected $destinationEndpoint;
    protected $tariffEndpoint;

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'name' => 'required|string',
        'published' => ''
    ];

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->sicepatUsername     = env('SICEPAT_API_USERNAME');
        $this->sicepatApikey       = env('SICEPAT_API_KEY');
        $this->originEndpoint      = env('SICEPAT_API_ORIGIN_ENDPOINT');
        $this->destinationEndpoint = env('SICEPAT_API_DESTINATION_ENDPOINT');
        $this->tariffEndpoint      = env('SICEPAT_API_TARIFF_ENDPOINT');
    }

    protected function beforeValidate()
    {
        parent::beforeValidate();
        // Put your form requirement here
        // e.g. $this->form->setModelId($this->model->getKey());
    }

    protected function formRules()
    {
        parent::formRules();
    }

    public function formData()
    {
        parent::formData();
    }

    protected function doSave() 
    {
        parent::doSave();
    }

    public function sync()
    {
        $destinationCode = \Cache::get('sicepat-destination');
        if (empty($destinationCode)) {
            $client       = new \GuzzleHttp\Client();
            $response     = $client->request(
                'GET', 
                $this->destinationEndpoint . '?api-key=' . $this->sicepatApikey
            );
            $destinations = json_decode($response->getBody(), true);
            if ($destinations['sicepat']['status']['code'] == 200) {
                $destinationCode = $destinations['sicepat']['results'];
                \Cache::put('sicepat-destination', $destinationCode, $this->cacheLong);
            }
        }
        ini_set('max_execution_time', 600);
        foreach ($destinationCode as $dest) {
            $province = Model::firstOrCreate([
                'name'         => $dest['province']
            ]);

            $city = City::firstOrCreate([
                'province_id' => $province->id,
                'name'        => $dest['city']
            ]);
            
            $district = District::firstOrCreate([
                'city_id' => $city->id,
                'name'    => $dest['subdistrict'],
                'code'    => $dest['destination_code']
            ]);
            
        }
        session()->flash(NOTIF_SUCCESS, 'Locations are synced with Sicepat!');
        return redirect()->route('backend.provinces.index');
    }
    
}
