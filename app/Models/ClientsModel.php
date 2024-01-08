<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class ClientsModel extends Model
{
    protected $table = "clients";
    protected $generate;
    protected $allowedFields = ['name', 'email', 'phone', 'address'];

    public function __construct()
    {
        parent::__construct();
        $database = \Config\Database::connect();
        $this->generate = $database->table("clients");
    }

    /**
     * @param $data = {
     *      name,
     *      email,
     *      phone,
     *      address
     * }
     */
    public function insertClient($data)
    {
        $add = $this->db->table($this->table)->insert($data);
        if($add)
        {
            return $this->db->insertID();
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $field = table value column
     */

    public function getField(string $field)
    {
        return $this->select($field)->findAll();
    }

}