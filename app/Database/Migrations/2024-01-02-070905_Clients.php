<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Clients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
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
            "phone" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 15
            ],
            "email" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 250
            ],
            "address" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 500
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
        $this->forge->addUniqueKey("email");
        $this->forge->createTable("clients");
    }

    public function down()
    {
        $this->forge->dropTable("clients");
    }
}
