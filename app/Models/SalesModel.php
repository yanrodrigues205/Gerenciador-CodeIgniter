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

         public function getAllSales()
         {
            $sql = 'SELECT 
            sales.id,
            sales.client_id,
            c.name AS client_name,
            sales.payment,
            sales.delivery_zipcode,
            sales.delivery_neighborhood,
            sales.delivery_state,
            sales.delivery_streetname,
            sales.delivery_city,
            GROUP_CONCAT(sp.products_id) AS sales_products_id,
            GROUP_CONCAT(sp.amount) AS amount
            FROM sales
            INNER JOIN sales_products AS sp
            ON sp.sales_id = sales.id
            INNER JOIN clients AS c
            ON c.id = sales.client_id
            GROUP BY sales.id
            ORDER BY sales.id DESC';
           
            $query = $this->query($sql);
            $resp = $query->getResult();
            $sales = [];

            for($i =0; $i < count($resp); $i++)
            {
                $products = explode(",", $resp[$i]->sales_products_id);
                $amount = explode(",", $resp[$i]->amount);
                $subtotal = 0.0;
                $cart = [];
                for($y =0; $y < count($products); $y++)
                {
                    $sql02 = "SELECT
                            id,
                            name,
                            description,
                            value
                        FROM
                            products
                        WHERE
                            id = ? ";
                    $query02 = $this->query($sql02, [$products[$y]]);
                    $resp02 = $query02->getResult();

                    for($j =0; $j < count($resp02); $j++)
                    {
                        $cart[$y] = [
                            "id" => $resp02[$j]->id,
                            "name" => $resp02[$j]->name,
                            "description" => $resp02[$j]->description,
                            "amount" => $amount[$y],
                            "value" => $resp02[$j]->value,
                        ];
                        $subtotal += ( $resp02[$j]->value * $amount[$y] );
                    }
                }

                $sales[$i] = [
                    "id" => $resp[$i]->id,
                    "client_id" => $resp[$i]->client_id . " - ". $resp[$i]->client_name,
                    "payment" => $resp[$i]->payment,
                    "delivery_zipcode" => $resp[$i]->delivery_zipcode,
                    "delivery_neighborhood" => $resp[$i]->delivery_neighborhood,
                    "delivery_state" => $resp[$i]->delivery_state,
                    "delivery_streetname" => $resp[$i]->delivery_streetname,
                    "delivery_city" => $resp[$i]->delivery_city,
                    "products" => $cart,
                    "total" => $subtotal
                ];
            }
            return $sales;
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