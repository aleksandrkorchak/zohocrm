<?php

namespace App\Http\Controllers;

use DateTime;
use App\OAuth2 as OAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AuthorizeController extends Controller
{

    public function getToken(Request $request)
    {

        $auth = App::make('OAuth');
        $model = OAuth::first();

        //Get data from the form and request access_token
        if ($request->isMethod('post')) {

            //TODO: Проверить данные, которые пришли из формы
            $data = array(
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
            );

            return $auth->requestAccessToken($data);
        }


        //Get grant_token and request access_token
        if (isset($request->code)) {

            //re-request access_token
            //TODO: Проверить входящий параметр 'code'
            //TODO: Сохранить другие входящие параметры
            $timeNow = new DateTime("now");
            $data = array(
                'code' => $request->code,                                    //grant_token
                'code_updated_at' => $timeNow->format('Y-m-d H:i:s')   //Date and time of grant_token creation.
            );
            $auth->requestAccessToken($data);

        }


        if ($auth->hasValidAccessToken()) {
            $back_route = $model->back_route;
            $model->back_route = null;
            $model->save();
            return redirect()->route($back_route);
        }

        return view('OAuth2.login');


    }


}