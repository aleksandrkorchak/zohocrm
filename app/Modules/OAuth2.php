<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 19.02.2019
 * Time: 21:34
 */

namespace App\Modules;

use DateTime;
use DateInterval;
use GuzzleHttp\Client;
use Exception;
use App\OAuth2 as OAuth;

/**
 * Class OAuth2
 * @package App\Modules
 */
final class OAuth2
{

    private $client_id;
    private $client_secret;

    private $redirect_uri = 'http://zohocrm.test/login';

    private $scope = 'ZohoCRM.modules.all,ZohoCRM.settings.ALL,ZohoCRM.users.ALL';
    private $response_type = 'code';
    private $access_type = 'online';

    private $code;                              //grant_token
    private $code_updated_at;
    private $code_expires_in_sec = 60;

    private $grant_type = 'authorization_code';

    private $access_token;
    private $access_token_updated_at;
    private $access_token_expires_in_sec = 3600;

    private $refresh_token;

    private $model;

    /**
     * OAuth2 constructor.
     */
    public function __construct()
    {

        $this->model = OAuth::first();
        $this->client_id = $this->client_id ?? $this->model->client_id;
        $this->client_secret = $this->client_secret ?? $this->model->client_secret;

        $this->redirect_uri = $this->redirect_uri ?? $this->model->redirect_uri;

        $this->scope = $this->scope ?? $this->model->scope;
        $this->response_type = $this->response_type ?? $this->model->response_type;
        $this->access_type = $this->access_type ?? $this->model->access_type;

        $this->code = $this->code ?? $this->model->code;
        $this->code_updated_at = $this->code_updated_at ?? $this->model->code_updated_at;
        $this->code_expires_in_sec = $this->code_expires_in_sec ?? $this->model->code_expires_in_sec;

        $this->grant_type = $this->grant_type ?? $this->model->grant_type;

        $this->access_token = $this->access_token ?? $this->model->access_token;
        $this->access_token_updated_at = $this->access_token_updated_at ?? $this->model->access_token_updated_at;
        $this->access_token_expires_in_sec = $this->access_token_expires_in_sec ?? $this->model->access_token_expires_in_sec;

        //TODO: Задействовать в механизме аутентификации refresh_token
        $this->refresh_token = $this->refresh_token ?? $this->model->refresh_token;

    }


    /**
     * Check whether a grant_token exists
     *
     * @return bool
     */
    public function hasGrantToken()
    {
        if (isset($this->code)) {
            return true;
        }

        return false;
    }


    /**
     * Check grant_token timelife
     *
     * @return bool
     * @throws Exception
     */
    public function isValidGrantToken()
    {
        //TODO: Проверить code_updated_at
        $tokenLifeTime = new DateTime($this->code_updated_at);
        $tokenLifeTime->add(new DateInterval('PT' . $this->code_expires_in_sec . 'S'));

        $timeNow = new DateTime("now");

        if ($tokenLifeTime < $timeNow) {
            return false;
        }

        return true;
    }


    /**
     * Check whether a grant_token exists and valid
     *
     * @return bool
     */
    public function hasValidGrantToken()
    {
        if ($this->hasGrantToken() && $this->isValidGrantToken()) {
            return true;
        }

        return false;
    }


    /**
     * Send request for grant_token
     *
     * @param array $data Request parameters
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestGrantToken(Array $data)
    {
        $query = http_build_query($data);

        return redirect()->away("https://accounts.zoho.com/oauth/v2/auth?" . $query);
    }


    /**
     * Check whether an access_token exists
     *
     * @return bool
     */
    public function hasAccessToken()
    {
        if (isset($this->access_token)) {
            return true;
        }

        return false;
    }


    /**
     * Check access_token lifetime
     *
     * @return bool
     * @throws Exception
     */
    public function isValidAccessToken()
    {
        $tokenLifeTime = new DateTime($this->access_token_updated_at);
        $tokenLifeTime->add(new DateInterval('PT' . $this->access_token_expires_in_sec . 'S'));

        $timeNow = new DateTime("now");

        if ($tokenLifeTime < $timeNow) {
            return false;
        }

        return true;
    }


    /**
     * Check access_token
     *
     * @return bool
     */
    public function hasValidAccessToken()
    {
        if ($this->hasAccessToken() && $this->isValidAccessToken()) {
            return true;
        }

        return false;
    }


    /**
     * Return access_token
     *
     * @return bool|string
     */
    public function getAccessToken()
    {
        if ($this->hasValidAccessToken()) {
            return $this->access_token;
        }

        return false;
    }


    /**
     * Request for access_token
     *
     * @param array $data
     * @return bool|\Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function requestAccessToken(Array $data = [])
    {

        //Return access_token if exists
        if ($this->hasValidAccessToken()) {
            return $this->access_token;
        } else {
            $this->access_token = null;
            $this->access_token_updated_at = null;
        }

        //Check and save parameters
        if (!empty($data)) {
            $this->setParams($data);
        }

        //Trying to get access_token and refresh_token
        if ($this->hasValidGrantToken()) {
            $data = array(
                'code' => $this->code,
                'redirect_uri' => $this->redirect_uri,
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => $this->grant_type
            );
            $query = http_build_query($data);

            $guzzleClient = new Client();
            try {
                $response = $guzzleClient->post("https://accounts.zoho.com/oauth/v2/token?" . $query);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            $jsonString = $response->getBody()->getContents();
            //TODO: проверить что пришло в ответе, обработать ошибки
            $timeNow = new DateTime('now');
            $data = json_decode($jsonString);

            //TODO: Сохранить все параметры из ответа
            //Get access_token
            $this->access_token = $data->access_token;
            $this->access_token_expires_in_sec = $data->expires_in_sec;
            $this->access_token_updated_at = $timeNow->format('Y-m-d H:i:s');

            $this->saveModel();

            return true;

        } else {
            $this->code = null;
            $this->code_updated_at = null;
        }

        $this->saveModel();

        //If the 'code' has not been get, then request the 'code' (grant_token)
        $data = array(
            'scope' => $this->scope,
            'client_id' => $this->client_id,
            'response_type' => $this->response_type,
            'access_type' => $this->access_type,
            'redirect_uri' => $this->redirect_uri
        );
        return $this->requestGrantToken($data);

    }

    /**
     * Check params and save properties
     *
     * @param array $params
     * @return void
     */
    public function setParams(Array $params)
    {
        //TODO: Бросить исключение если параметр не существует
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }


    /**
     * Save model
     *
     * @return void
     */
    public function saveModel()
    {
        $this->model->client_id = $this->client_id;
        $this->model->client_secret = $this->client_secret;

        $this->model->redirect_uri = $this->redirect_uri;

        $this->model->scope = $this->scope;
        $this->model->response_type = $this->response_type;
        $this->model->access_type = $this->access_type;

        $this->model->code = $this->code;
        $this->model->code_updated_at = $this->code_updated_at;
        $this->model->code_expires_in_sec = $this->code_expires_in_sec;

        $this->model->grant_type = $this->grant_type;

        $this->model->access_token = $this->access_token;
        $this->model->access_token_updated_at = $this->access_token_updated_at;
        $this->model->access_token_expires_in_sec = $this->access_token_expires_in_sec;

        //TODO: Задействовать в механизме аутентификации refresh_token
        $this->model->refresh_token = $this->refresh_token;
        $this->model->save();
    }


}