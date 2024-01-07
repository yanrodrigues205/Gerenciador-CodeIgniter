<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Sales extends Migration
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
            "payment" => [
                "type" => "VARCHAR",
                "constraint" => 100,
                "null" => false
            ],
            "delivery_zipcode" => [
                "type" => "VARCHAR",
                "constraint" => 12,
                "null" => false
            ],
            "delivery_neighborhood" => [
                "type" => "VARCHAR",
                "constraint" => 250,
                "null" => false
            ],
            "delivery_state" => [
                "type" => "VARCHAR",
                "constraint" => 250,
                "null" => false
            ],
            "delivery_streetname" => [
                "type" => "VARCHAR",
                "constraint" => 250,
                "null" => false
            ],
            "delivery_city" => [
                "type" => "VARCHAR",
                "constraint" => 250,
                "null" => false     
            ],
            "client_id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned"=> true
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
            $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable("sales");
    }

    public function down()
    {
        $this->forge->dropTable("sales");
    }
}
