<?php

namespace App\Http\Controllers;

use App\OAuth2 as OAuth;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Exception\GuzzleException;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DealController extends Controller
{


    /**
     * Show page with new deal form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        //Get users that can insert records
        $method = 'get';
        $uri = 'https://www.zohoapis.com/crm/v2/users?type=ActiveUsers';
        $headers = [
            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
            "Content-Type" => "application/json; charset=utf-8",
        ];
        $users = $crm->sendRequest($method, $uri, $headers);

        //To get the fields meta data for the Deal module
        $uri = 'https://www.zohoapis.com/crm/v2/settings/fields?module=Deals';
        $fields = $crm->sendRequest($method, $uri, $headers);


        return view('Deals.newdeal', $users, $fields);
    }


    /**
     * Save new deal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        //TODO: Проверить данные, которые приходят из формы

        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        $method = 'post';
        $uri = 'https://www.zohoapis.com/crm/v2/deals';
        $headers = [
            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
            "Content-Type" => "application/json; charset=utf-8"
        ];
        $body =
            [
                "data" => [
                    [
                        "Account_Name" => $request->accountName,
                        "Deal_Name" => $request->dealName,
                        "Stage" => $request->stage,
                        "Closing_Date" => $request->closingDate,
                        "Owner" => $request->dealOwner
                    ]
                ],
                'trigger' => [
                    "approval",
                    "workflow",
                    "blueprint"
                ]
            ];

        $crm->sendRequest($method, $uri, $headers, $body);

        //TODO: Сообщить об успешности или неудаче сохранения сделки

        return redirect()->route('home');
    }


    /**
     * Get all tasks for current deal
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTasks($id)
    {
        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        //Get a list of available records from a module Tasks
        $method = 'get';
        $uri = 'https://www.zohoapis.com/crm/v2/tasks';
        $headers = [
            "Authorization" => "Zoho-oauthtoken {$model->access_token}"
        ];
        $tasks = $crm->sendRequest($method, $uri, $headers);

        //Get a list of Deals
        $uri = 'https://www.zohoapis.com/crm/v2/deals';
        $deals = $crm->sendRequest($method, $uri, $headers);

        //Search current deal
        $deal = [];
        foreach ($deals['data'] as $currentDeal) {
            if ($currentDeal['id'] == $id) {
                $deal = $currentDeal;
                break;
            }
        }
        $currentDeal = ['deal' => $deal];

        //Search tasks for current deal
        $data = [];
        foreach ($tasks['data'] as $task) {
            if ($task['What_Id']['id'] == $id) {
                $data[] = $task;
            }
        }
        $listTasksDeal = ['tasks' => $data];

        return view('Tasks.tasks', $currentDeal, $listTasksDeal);
    }


    /**
     * Add task for current deal
     *
     * @param $idDeal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addTask($idDeal)
    {
        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        //Get the fields of Tasks
        $method = 'get';
        $uri = 'https://www.zohoapis.com/crm/v2/settings/fields?module=Tasks';
        $headers = [
            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
            "Content-Type" => "application/json; charset=utf-8"
        ];
        $fields = $crm->sendRequest($method, $uri, $headers);

        //Get Users
        $uri = 'https://www.zohoapis.com/crm/v2/users?type=ActiveUsers';
        $users = $crm->sendRequest($method, $uri, $headers);

        $data = ['currentIdDeal' => $idDeal, 'fields' => $fields['fields'], 'users' => $users['users']];


        return view('Deals.newtask', $data);
    }


    /**
     * Save task for current deal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveTask(Request $request)
    {
        $crm = App::make('ZohoCrm');
        $model = OAuth::first();

        //TODO: проверить, что пришло из формы
        $method = 'post';
        $uri = 'https://www.zohoapis.com/crm/v2/tasks';
        $headers = [
            "Authorization" => "Zoho-oauthtoken {$model->access_token}",
            "Content-Type" => "application/json; charset=utf-8",
        ];
        $body =
            [
                "data" => [
                    [
                        "Subject" => $request->subject,
                        "Due_Date" => $request->dueDate,
                        "Priority" => $request->priority,
                        "Owner" => [
                            "id" => $request->owner
                        ],
                        "\$se_module" => "Deals",
                        "What_Id" => [
                            "id" => $request->currentIdDeal
                        ],
                    ]
                ],
                "trigger" => [
                    "approval",
                    "workflow",
                    "blueprint"
                ]
            ];
        $crm->sendRequest($method, $uri, $headers, $body);


        return redirect()->route('tasks', $request->currentIdDeal);
    }

}


