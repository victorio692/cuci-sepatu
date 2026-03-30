<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAktifToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'aktif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'User status: 1 = active, 0 = inactive'
            ]
        ]);
    }

    public function down()
    {
        if ($this->forge->fieldExists('aktif', 'users')) {
            $this->forge->dropColumn('users', 'aktif');
        }
    }
}
