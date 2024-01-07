<?php

namespace App\Models;
use CodeIgniter\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthModel extends Model
{
    /**
     * @var $key = secret key from system
     */
    private $key = "6R22lQVJVuWJxorJfeQww5NwsraIkpXVCJ9.eyJzdWIi0PjaOYhAMj9jNMO5YLm"; 
    private $alg = "HS384";
    public function __construct()
    {
        parent::__construct();
    }

    public function createToken(array $data)
    {
        $payload = [
            "iss" => "http://localhost:8080",
            "aud" => "http://localhost:8080",
            "data" => [
                "id_user" => $data["id"],
                "name_user" => $data["name"],
                "email_user" => $data["email"]
            ]
        ];
            
        $jwt = JWT::encode($payload, $this->key, $this->alg);

        if($jwt)
            return $jwt;
        else 
            return false;
    }

    public function readToken()
    {
        $request = service("request");
        $headers = $request->getHeader("authorization");
        $token = $headers->getValue();

        $data_token = JWT::decode($token, new Key($this->key, $this->alg));
        return $data_token;
    }
}