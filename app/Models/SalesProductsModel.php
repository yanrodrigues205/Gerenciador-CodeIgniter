<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class SalesProductsModel extends Model
    {
        protected $table = "sales_products";
        protected $generate;
        protected $allowedFields = ["sales_id", "products_id"];

        public function __construct()
        {
            parent::__construct();
            $database = \Config\Database::connect();
            $this->generate = $database->table("sales_products");
        }

        /**
         * @param  $data = {
         *                     sales_id,
         *                     products_id
         *                 } 
         */


         public function insertSalesProducts(array $data)
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

         public function deleteSalesProducts(int $id)
         {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $param = [
                $id
            ];
            $delete = $this->db->query($sql, $param);
            return $delete;
         }


         public function updateSalesProducts(int $id, array $data)
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
?>