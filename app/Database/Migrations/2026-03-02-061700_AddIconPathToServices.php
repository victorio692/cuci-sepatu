<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIconPathToServices extends Migration
{
    public function up()
    {
        $this->forge->addColumn('services', [
            'icon_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path to service icon image file',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('services', 'icon_path');
    }
}
