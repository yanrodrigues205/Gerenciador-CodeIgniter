<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Users extends Migration
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
            "email" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 200
            ],
            "password" => [
                "type" => "VARCHAR",
                "null" => false,
                "constraint" => 255
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
        $this->forge->createTable("users");

        $data = [
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => password_hash("admin",PASSWORD_DEFAULT)
        ];
        $this->db->table("users")->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable("users");
    }
}
