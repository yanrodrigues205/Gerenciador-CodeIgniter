<?php
    namespace App\Controllers;
    
    use CodeIgniter\RESTful\ResourceController;
    use App\Models\ProductsModel;
    use Exception;
    class ProductsController extends ResourceController
    {
        protected $model;

        public function __construct()
        {
            $this->model = new ProductsModel();
        }
        public function createProduct()
        {
            
            try
            {
                $name = $this->request->getVar("name");
                $description = $this->request->getVar("description");
                $value = $this->request->getVar("value");


                if($name == null || $description == null || $value == null)
                {
                    return $this->respond([
                        "statusCode" => 400,
                        "message" => "fill in all fields, name, description and value!",
                        "error" => true                       
                    ]);
                }
            
                $data_product = [
                    "name" => $name,
                    "value" => $value,
                    "description" => $description
                ];

                $insert = $this->model->insertProduct($data_product);
                $product = $this->model->where("id", $insert)->first();


                if(!$product)
                {
                    return $this->respond([
                        "statusCode" => 400,
                        "message" => "error when creating new product!",
                        "error" => true,
                    ]);
                }

                return $this->respond([
                    "statusCode"=> 200,
                    "message" => "successfully created product!",
                    "error" => false,
                    "product" => $product
                ]);     
            }
            catch(Exception $err)
            {
                return $this->respond([
                    "statusCode" => 500,
                    "error" => $err,
                    "message" => "internal server error!"
                ]);
            }
        }

        public function dropProduct()
        {
            try
            {
                $id = $this->request->getVar("id");

                if($id == null)
                {
                    return $this->respond([
                        "statusCode" => 400,
                        "message" => "fill in field id!",
                        "error" => true                       
                    ]);
                }

                $delete = $this->model->deleteProduct($id);

                if(!$delete)
                {
                    return $this->respond([
                        "statusCode" => 400,
                        "message" => "error when delete product!",
                        "error" => true,
                    ]);
                }

                return $this->respond([
                    "statusCode"=> 200,
                    "message" => "product deleted successfully!",
                    "error" => false
                ]);  
            }
            catch(Exception $err)
            {
                return $this->respond([
                    "statusCode" => 500,
                    "error" => $err,
                    "message" => "internal server error!"
                ]);
            }
        }
    }
?>