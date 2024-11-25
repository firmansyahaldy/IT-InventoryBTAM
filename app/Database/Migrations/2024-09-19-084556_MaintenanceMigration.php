<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class MaintenanceMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_maintenance' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 64,
                'unsigned' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'maintenance_selanjutnya' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'id_status_maintenance' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'updated_at' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'maintened_by' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_maintenance', true);
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_status_maintenance', 'status_maintenance', 'id_status_maintenance', 'CASCADE', 'CASCADE');
        $this->forge->createTable('maintenance');
    }

    public function down()
    {
        $this->forge->dropTable('maintenance');
    }
}
