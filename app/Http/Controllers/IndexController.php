<?php

namespace App\Http\Controllers;

use App\OAuth2 as OAuth;
use Illuminate\Support\Facades\App;


class IndexController extends Controller
{
    /**
     * Show main page with all Deals
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        //Set request parameters
        $method = 'get';
        $uri = 'https://www.zohoapis.com/crm/v2/deals';
        $headers = ['Authorization' => "Zoho-oauthtoken {$model->access_token}"];
        $deals = $crm->sendRequest($method, $uri, $headers);

        return view('Deals.deals', $deals);
    }
}
