<?php

namespace App\Controllers;
use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use App\Models\AuthModel;

class AuthController extends ResourceController
{
    private $modelUser;
    private $modelAuth;

    public function __construct()
    {
        $this->modelUser = new UsersModel();
        $this->modelAuth = new AuthModel();
    }
    public function index() : string
    {
        return view('login');
    }

    public function init()
    {
        try
        {  
            $email = $this->request->getVar("email"); 
            $password = $this->request->getVar("password"); 
            $verify = $this->modelUser->where("email", $email)->first();

            if(!$verify)
            {
                return $this->respond([
                    'statusCode' => 400,
                    'message' => $email . " does not exist in the system",
                ]);
            }

            $verifyPassword = password_verify($password, $verify['password']);

            if(!$verifyPassword)
            {
                return $this->respond([
                    'statusCode' => 400,
                    'message' => $email . " does not exist in the system",
                ]);
            }

            $create_token = $this->modelAuth->createToken($verify);

           
                return $this->respond([
                    "statusCode" => 200,
                    "error" => false,
                    "message" => "authenticate successfull!",
                    "token" => $create_token
                ]);
            

            
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

    public function readToken()
    {
        try
        {
            $call = $this->modelAuth->readToken();
            if($call)
            {
                return $this->respond([
                    "statusCode" => 200,
                    "error" => false,
                    "message" => "descriptografado com sucesso",
                    "data" => $call
                ]);
            }
        }
        catch(Exception $err)
        {
            return $this->respond([
                "statusCode" => 500,
                "error" => $err,
                "message" => "descriptografado com sucesso"
            ]);
        }

       
    }
}