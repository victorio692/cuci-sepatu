<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'booking_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'pesan' => [
                'type' => 'TEXT',
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'info',
                'comment'    => 'new_booking, status_update, info',
            ],
            'dibaca' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_user');
        $this->forge->addKey('booking_id');
        $this->forge->addKey('created_at');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
