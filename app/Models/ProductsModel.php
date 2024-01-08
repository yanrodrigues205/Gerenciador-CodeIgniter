<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ProductsModel extends Model
    {
        protected $table = "products";
        protected $generate;
        protected $allowedFields = [""];

        public function __construct()
        {
            parent::__construct();
            $database = \Config\Database::connect();
            $this->generate = $database->table("products");
        }


        /**
         * @param  $data = {
         *                      name,
         *                      value,
         *                      description
         *                 } 
         */


         public function insertProduct(array $data)
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


         public function deleteProduct(int $id)
         {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $param = [
                $id
            ];
            $delete = $this->db->query($sql, $param);
            return $delete;
         }


         public function updateProduct(int $id, array $data)
         {
            $sql = "UPDATE $this->table SET ";
            $setValues = []; 

            foreach($data as $key => $value)
            {
                $setValues[] = "$key = ?";
            }

            $sql .= implode(", ", $setValues);
            $sql .= " WHERE id = ?";
            $args = array_merge(array_values($data), [$id]);

            $update = $this->db->query($sql, $args);

            return $update;
         }
    }