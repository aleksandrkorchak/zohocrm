<?php

namespace App\Http\Controllers;

use App\Auth;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

//use GuzzleHttp;

class TestController extends Controller
{
    public function insertDeal(Request $request)
    {

        $model = Auth::first();

        $input =
            [
                "data" => [
                    [
                        "Account_Name" => "fdhhdfhfdhfdh",
                        "Deal_Name" => "fifth",
                        "Stage" => "Требуется анализ",
                        "Closing_Date" => "2017-08-16",
                        "Owner" => "3787497000000192015"
                    ]
                ],
                'trigger' => []
            ];

        $input = json_encode($input);


//        echo '<pre>';
//        print_r($input);
//        echo '</pre>';


        //https://www.zohoapis.com/crm/v2/deals
        //Method: POST
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->request('post',
                'https://www.zohoapis.com/crm/v2/deals',
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
                        ],
                    'body' => $input
                ]);
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        $responseBody = $response->getBody()->getContents();
        $deals = json_decode($responseBody, true);

        echo '<pre>';
        print_r($deals);
        echo '</pre>';


    }

    public function insertLead(Request $request)
    {
        $model = Auth::first();

        $input =
            [
                "data" => [
                    [
                        "Company" => "Zylker",
                        "Last_Name" => "Daly",
                        "First_Name" => "Paul",
                        "Email" => "p.daly@zylker.com",
                        "State" => "Texas",
                    ],
                    [
                        "Company" => "Villa Margarita",
                        "Last_Name" => "Dolan",
                        "First_Name" => "Brian",
                        "Email" => "brian@villa.com",
                        "State" => "Texas",
                    ]
                ],
                "trigger" => [
                    "approval",
                    "workflow",
                    "blueprint"
                ]
            ];

        $input = json_encode($input);

//        echo '<pre>';
//        print_r($input);
//        echo '</pre>';


        //https://www.zohoapis.com/crm/v2/lead
        //Method: POST
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->request('post',
                'https://www.zohoapis.com/crm/v2/leads',
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
                        ],
                    'body' => $input
                ]);
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        $responseBody = $response->getBody()->getContents();
        $res = json_decode($responseBody, true);

        echo '<pre>';
        print_r($res);
        echo '</pre>';


    }

    public function getUsers()
    {
        $model = Auth::first();

        //Get users that can insert records
        //https://www.zohoapis.com/crm/v2/users?type=AllUsers
        //Method: GET
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->get("https://www.zohoapis.com/crm/v2/users?type=AllUsers",
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
                        ]
                ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $jsonString = $response->getBody()->getContents();

        $data = json_decode($jsonString, true);

        echo '<pre>';
        print_r($data);
        echo '</pre>';


    }

    public function getModules()
    {
        $model = Auth::first();

        //Get users that can insert records
        //https://www.zohoapis.com/crm/v2/users?type=AllUsers
        //Method: GET
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->get("https://www.zohoapis.com/crm/v2/settings/modules",
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
                        ]
                ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $jsonString = $response->getBody()->getContents();

        $modules = json_decode($jsonString, true);

        echo '<pre>';
        print_r($modules);
        echo '</pre>';
    }

    public function getFieldsDeals()
    {
        $model = Auth::first();

        //To get the field meta data for the specified module
        //https://www.zohoapis.com/crm/v2/settings/fields?module=Deals
        //Method: GET
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->get("https://www.zohoapis.com/crm/v2/settings/fields?module=Deals",
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
//                        "Content-Length" => strlen($input)
                        ]
                ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $jsonString = $response->getBody()->getContents();

        $fields = json_decode($jsonString, true);

        echo '<pre>';
        print_r($fields);
        echo '</pre>';
    }


    // /test/deals
    public function getDeals()
    {
        $model = Auth::first();

        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->request('get',
                'https://www.zohoapis.com/crm/v2/deals',
                [
                    'headers' =>
                        ['Authorization' => "Zoho-oauthtoken {$model->access_token}"]
                ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $responseBody = $response->getBody()->getContents();
        $deals = json_decode($responseBody, true);


        echo '<pre>';
        print_r($deals);
        echo '</pre>';
    }

    public function getTasks()
    {
        $model = Auth::first();


        //To get the list of available records from a module Tasks
        //https://www.zohoapis.com/crm/v2/tasks
        //Method: GET
        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->request('get',
                'https://www.zohoapis.com/crm/v2/tasks',
                [
                    'headers' =>
                        ['Authorization' => "Zoho-oauthtoken {$model->access_token}"]
                ]);
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        $responseBody = $response->getBody()->getContents();
        $tasks = json_decode($responseBody, true);


        echo '<pre>';
        print_r($tasks);
        echo '</pre>';
    }


    public function saveTask()
    {
        $model = Auth::first();

        $input =
            [
                "data" => [
                    [
                        "Subject" => "New TEST Subject for ten",
                        "Due_Date" => "2017-08-16",
                        "Priority" => "Высокая",
                        "Owner" => [
                            "id" => "3787497000000192015"
                        ],
                        "\$se_module" => "Deals",
                        "What_Id" => [
                            "id" => "3787497000000229045"
                        ],
                    ]
                ],
                "trigger" => [
                    "approval",
                    "workflow",
                    "blueprint"
                ]
            ];
        $input = json_encode($input);


        $guzzleClient = new Client();
        try {
            $response = $guzzleClient->request('post',
                'https://www.zohoapis.com/crm/v2/tasks',
                [
                    'headers' =>
                        [
                            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
                            "Content-Type" => "application/json; charset=utf-8",
                        ],
                    'body' => $input
                ]);
        } catch (GuzzleException $ex) {
            echo $ex->getMessage();
        }
        $responseBody = $response->getBody()->getContents();
        $res = json_decode($responseBody, true);

        echo '<pre>';
        print_r($res);
        echo '</pre>';

    }


}




