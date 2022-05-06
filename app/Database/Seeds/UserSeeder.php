<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'Budi',
            'nama' => 'Budi Andi',
            'alamat' => 'Di Jalan Budi Andi',
            'password' => password_hash('Budi123', PASSWORD_BCRYPT),
        ];

        $this->db->table('user')->insert($data);
    }
}
