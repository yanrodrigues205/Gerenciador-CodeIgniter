<?php
namespace App\Controllers;
use App\Models\SalesModel;
use App\Models\SalesProductsModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class SalesController extends ResourceController
{
    protected $salesModel;
    protected $salesProductsModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
        $this->salesProductsModel = new SalesProductsModel();
    }


    public function addProductForSale()
    {
        try
        {
            $sales_id = $this->request->getVar("sales_id");
            $products_id = $this->request->getVar("products_id");
            $amount = $this->request->getVar("amount");

            if(!isset($products_id) || !isset($sales_id) || !isset($amount))
            {
                return $this->respond([
                    "statusCode" => 400,
                    "message" => "fill in all fields, sales_id and products_id!",
                    "error" => true                       
                ]);
            } 

            $data_sp = [
                "sales_id" => $sales_id,
                "products_id" => $products_id,
                "amount" => $amount
            ];

            $insert = $this->salesProductsModel->insertSalesProducts($data_sp);
            $salesProduct = $this->salesProductsModel->where("id", $insert)->first();

            if(!$salesProduct)
            {
                return $this->respond([
                    "statusCode" => 400,
                    "message" => "error when creating new product for sale!",
                    "error" => true,
                ]);
            }

            return $this->respond([
                "statusCode"=> 200,
                "message" => "successfully created product!",
                "error" => false,
                "salesProduct" => $salesProduct
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

    public function createSale()
    {
        try
        {
            $payment = $this->request->getVar("payment");
            $delivery_zipcode = $this->request->getVar("delivery_zipcode");
            $delivery_neighborhood = $this->request->getVar("delivery_neighborhood");
            $delivery_state = $this->request->getVar("delivery_state");
            $delivery_streetname = $this->request->getVar("delivery_streetname");
            $delivery_city = $this->request->getVar("delivery_city");
            $client_id = $this->request->getVar("client_id");

            if(
                $payment == null ||
                $delivery_zipcode == null ||
                $delivery_neighborhood == null ||
                $delivery_state == null ||
                $delivery_streetname == null ||
                $delivery_city == null ||
                $client_id == null
            )
            {
                return $this->respond([
                    "statusCode" => 400,
                    "message" => "fill in all fields,payment, delivery_zipcode, delivery_neighborhood, delivery_state, delivery_streetname, delivery_city and client_id!",
                    "error" => true                       
                ]);
            }

            $data_sale = [
                "payment" => $payment,
                "delivery_zipcode" => $delivery_zipcode,
                "delivery_neighborhood" => $delivery_neighborhood,
                "delivery_state" => $delivery_state,
                "delivery_streetname" => $delivery_streetname,
                "delivery_city" => $delivery_city,
                "client_id" => $client_id
            ];

            $insert = $this->salesModel->insertSale($data_sale);
            $sale = $this->salesModel->where("id", $insert)->first();

            if(!$sale)
            {
                return $this->respond([
                    "statusCode" => 400,
                    "message" => "error when creating new sale!",
                    "error" => true,
                ]);
            }

            return $this->respond([
                "statusCode"=> 200,
                "message" => "successfully created sale!",
                "error" => false,
                "sale" => $sale
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

    public function dropSale()
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

            $delete = $this->salesModel->deleteSale($id);

            if(!$delete)
            {
                return $this->respond([
                    "statusCode" => 400,
                    "message" => "error when delete sale!",
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