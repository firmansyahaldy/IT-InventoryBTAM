<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JabatanMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jabatan' => [
                'type'           => 'INT',  
                'unsigned'       => true,   
                'auto_increment' => true,   
            ],
            'nama_jabatan' => [
                'type'       => 'VARCHAR',  
                'constraint' => '50',       
            ],
        ]);
        $this->forge->addKey('id_jabatan', true);
        $this->forge->createTable('jabatan');
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
