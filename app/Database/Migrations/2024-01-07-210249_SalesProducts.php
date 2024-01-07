<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SalesProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "unsigned" => true,
                "auto_increment" => true,
                "constraint" => 11
            ],
            "product_id" => [
                "type" => "INT",
                "unsigned" => true,
                "constraint" => 11
            ],
            "sales_id" => [
                "type" => "INT",
                "unsigned" => true,
                "constraint" => 11
            ],
            "created_at" => [
                "type" => "TIMESTAMP",
                "default" => new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at" => [
                "type" => "TIMESTAMP",
                "default" => new RawSql("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
            ]
        ]);

        $this->forge->addForeignKey("product_id", "products", "id", "CASCADE", "CASCADE");
        $this->forge->addForeignKey("sales_id", "sales", "id", "CASCADE", "CASCADE");
        $this->forge->addPrimaryKey("id");
        $this->forge->createTable("sales_products");


    }

    public function down()
    {
        $this->forge->dropTable("sales_products");
    }
}
