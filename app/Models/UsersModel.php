<?php

namespace App\Models;
use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "users";
    protected $generate;
    public $allowedFields = ["name", "email", "password"];

   
    public function __construct(){
        parent::__construct();
        $database = \Config\Database::connect();
        $this->generate = $database->table("users");
    }

    /**
     * @param $data = {
     *      name,
     *      email,
     *      password 
     * }
     */

    public function insertUser($data)
    {
        
        $add_user = $this->db->table($this->table)->insert($data);
        if($add_user)
        {
            return $this->db->insertID();
        }
        else
        {
            return false;
        }
    }
}