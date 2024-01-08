<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class SalesModel extends Model 
    {
        protected $table = "sales";
        protected $generate;
        protected $allowedFields = ["payment", "delivery_zipcode", "delivery_neighborhood", "delivery_state", "delivery_streetname", "delivery_city", "client_id"];
    
        public function __construct() 
        {
            parent::__construct();
            $database = \Config\Database::connect();
            $this->generate = $database->table("sales");
        }

        /**
         *  @param $data = {
         *                     payment,
         *                     delivery_zipcode,
         *                     delivery_neighborhood,
         *                     delivery_state,
         *                     delivery_streetname,
         *                     delivery_city,
         *                     client_ad   
         *                 }
         */

         public function insertSale(array $data)
         {
             
             $add_sale = $this->db->table($this->table)->insert($data);
             if($add_sale)
             {
                 return $this->db->insertID();
             }
             else
             {
                 return false;
             }
         }


         public function updateSale(int $id,array $data)
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


         public function deleteSale(int $id)
         {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $param = [
                $id
            ];
            $delete = $this->db->query($sql, $param);
            return $delete;
         }
    }
?>