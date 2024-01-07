<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "name" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 200
            ],
            "value" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 15
            ],
            "description" => [
                "type" => "DOUBLE",
                "default" => 0.0
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

        $this->forge->addPrimaryKey("id");
        $this->forge->addUniqueKey("id");
        $this->forge->createTable("products");
    }

    public function down()
    {
        $this->forge->dropTable("products");
    }
}
