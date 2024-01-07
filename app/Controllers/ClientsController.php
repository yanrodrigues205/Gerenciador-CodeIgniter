<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use App\Models\ClientsModel;
date_default_timezone_set('America/Sao_Paulo');

class ClientsController extends ResourceController
{
    protected $model;
  
    public function __construct()
    {
        $this->model = new ClientsModel();
    }

    /**
     * index function
     * @method : GET 
     */
    public function index()
    {
        return view("clients");
    }
    public function getAllClients()
    {
        $clients['data_clients'] = $this->model->orderBy('id', 'DESC')->findAll();
        return json_encode($clients);
    }

    /**
     * insert function
     * @method : POST
     */
    public function insert()
    {
        try{
            
            $data_client = [
                "name" => $this->request->getVar("name"),
                "email" => $this->request->getVar("email"),
                "phone" => $this->request->getVar("phone"),
                "address" => $this->request->getVar("address")
            ];

          
            $add = $this->model->insertClient($data_client);
            $client = $this->model->where("id", $add)->first();

            return $this->respond([
                "statusCode" => 200,
                "error" => false,
                "message" => "created user success!",
                "client" => $client
            ]);

            if(!$add)
            {
                return $this->respond([
                    "statusCode" => 400,
                    "error" => true,
                    "message" => "internal error in request insert client!",
                ]);
            }
        }
        catch(Exception $err)
        {
            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "internal error in request!"
            ]);
        }

    }

    public function getCLientByID($id = null)
    {
        $client = $this->model->where("id", $id)->first();

        if($client)
        {
            return $this->respond([
                "statusCode" => 200,
                "error" => false,
                "message" => "created user success!",
                "client" => $client
            ]);
        }

        return $this->respond([
            "statusCode" => 400,
            "error" => true,
            "message" => "internal error in request get client by id!",
        ]);
    }

    public function alter()
    {
        try
        {
            $id = $this->request->getVar("id");
            $dataRequest = [
                "name" => $this->request->getVar("name"),
                "email" => $this->request->getVar("email"),
                "phone" => $this->request->getVar("phone"),
                "address" => $this->request->getVar("address")
            ];
            $update = $this->model->update($id, $dataRequest);

            if($update != false)
            {
                $data = $this->model->where('id', $id)->first();
                return $this->respond([
                    "statusCode" => 200,
                    "error" => false,
                    "message" => "created user success!",
                    "client" => $data
                ]);
            }

            return $this->respond([
                "statusCode" => 400,
                "error" => true,
                "message" => "internal error in request edit client!",
            ]);
        }
        catch(Exception $err)
        {

            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "internal error in request edit client!",
            ]);
        }
        
    }
    
    public function drop()
    {
        try
        {
            $id = $this->request->getVar("id");
            $delete = $this->model->where('id', $id)->delete();

            if(!$delete)
            {
                return $this->respond([
                    "statusCode" => 400,
                    "error" => false,
                    "message" => "error in drop user!"
                ]);
            }

            return $this->respond([
                "statusCode" => 200,
                "error" => false,
                "message" => "successfull!",
                "id" => $id

            ]);

        }
        catch(Exception $err)
        {
            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "internal error in request drop client!",
            ]);
        }
    }


    public function getNewsClients()
    {
        try
        {
            
            $clients = $this->model->getField("created_at");
           
            $time = [
                "one_hr" => 0,
                "two_hrs" => 0,
                "min45" => 0,
                "min30" => 0,
                "min15" => 0
            ];

            for($i = 0; $i < count($clients); $i++)
            {
                $now = new \DateTime();
                $currentDate = $clients[$i]["created_at"];
                $created_at = new \DateTime($currentDate);
                $dif = $now->diff($created_at);


                

                if($dif->format("%y") == 0 && $dif->format("%m") == 0 && $dif->format("%d") == 0)
                {
                    //added on the same day
                 
                        if($dif->format("%h") == 2 && $dif->format("%i") <= 59){
                            $time["two_hrs"] = $time["two_hrs"] + 1;
                        }
                        else if(($dif->format("%h") == 1 && $dif->format("%i") <= 59))
                        {
                            $time["one_hr"] = $time["one_hr"] + 1;
                        }
                        else if($dif->format("%i") <= 45 &&  $dif->format("%i") > 30 && $dif->format("%h") == 0)
                        {
                            $time["min45"] = $time["min45"] + 1;
                        }
                        else if($dif->format("%i") <= 30 &&  $dif->format("%i") > 15 && $dif->format("%h") == 0)
                        {
                            $time["min30"] = $time["min30"] + 1;
                        }
                        else if($dif->format("%i") <= 15 &&  $dif->format("%i") >= 0 && $dif->format("%h") == 0)
                        {
                            $time["min15"] = $time["min15"] + 1;
                        }
                }    
            }       
                 
        
            
            return json_encode($time);
        }
        catch(Exception $err)
        {
            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "internal error in request get all phones!",
            ]);     
        }
    }


    public function getAllPhones()
    {
        try
        {
            $phones = $this->model->getField("phone");
            if($phones)
            {
                $countStates = [
                    "sudeste" => 0,
                    "sul" => 0,
                    "centro_oeste" => 0,
                    "norte" => 0,
                    "nordeste" => 0
                ];

                $sudesteDDD = [ 27, 28, 31, 32, 33, 34, 35, 37, 38, 21, 22, 24, 11, 12, 13, 14, 15, 16, 17, 18, 19 ];
                $sulDDD = [41, 42, 43, 44, 45, 46, 51, 53, 54, 55, 47, 48, 49];
                $norteDDD = [68, 96, 92, 97, 91, 93, 94, 69, 95, 63];
                $nordesteDDD = [82, 71, 73, 74, 75, 77, 85, 88, 98, 99, 83, 81, 87, 86, 89, 84, 79];
                $centro_oesteDDD = [62, 64, 65, 66, 67, 61, 61];

                $passou =0;
                for($i = 0; $i < count($phones); $i++)
                {
                    $ddd = $phones[$i]["phone"][1] . $phones[$i]["phone"][2];
                    if(array_search($ddd, $sudesteDDD))
                    {
                        $countStates["sudeste"] = $countStates["sudeste"] + 1;
                    }
                    else if(array_search($ddd, $nordesteDDD))
                    {
                        $countStates["nordeste"] = $countStates["nordeste"] + 1;
                    }
                    else if(array_search($ddd, $centro_oesteDDD))
                    {
                        $countStates["centro_oeste"] = $countStates["centro_oeste"] + 1;
                        $passou = $passou + 1;
                    }
                    else if(array_search($ddd, $sulDDD))
                    {
                        $countStates["sul"] = $countStates["sul"] + 1;
                    }
                    else if(array_search($ddd, $norteDDD))
                    {
                        $countStates["norte"] = $countStates["norte"] + 1;
                    }
                }

                $sum = $countStates["sudeste"] + $countStates["nordeste"] + $countStates["norte"] + $countStates["sul"] + $countStates["centro_oeste"];
                
                $percentage = [
                    "sudeste" => 0,
                    "sul" => 0,
                    "norte" => 0,
                    "nordeste" => 0,
                    "centro_oeste" => 0,
                ];

                $percentage["sudeste"] = ($countStates["sudeste"] / $sum ) * 100;
                $percentage["sul"] = ($countStates["sul"] / $sum) * 100;
                $percentage["centro_oeste"] = ($countStates["centro_oeste"] / $sum) * 100;
                $percentage["nordeste"] = ($countStates["nordeste"] / $sum) * 100;
                $percentage["norte"] = ( $countStates["norte"] / $sum) * 100;
                
                return json_encode($percentage);

            }
            else
            {
                return $this->respond([
                    "statusCode" => 200,
                    "error" => true,
                    "message" => "is not call method getField!",
                ]);
            }
        }
        catch(Exception $err)
        {   
            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "internal error in request get all phones!",
            ]);
        }
    }

}