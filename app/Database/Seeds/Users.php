<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use \CodeIgniter\I18n\Time; //tambahkan ini jika menggunakan format time

class Users extends Seeder
{
    public function run()
    {
        //lakukan perulangan data
        for ($i = 0; $i < 10; $i++) {
            $data = [
                [
                    'username' => 'nandang',
                    'password' => 'rahasia',
                    'firstname' => 'Nandang',
                    'lastname' => 'Hermanto',
                    'address' => 'Ciberem, Sumbang',
                    'age' => '17'
                ],
                [
                    'username' => 'carlos',
                    'password' => 'abcdefgh',
                    'firstname' => 'Roberto',
                    'lastname' => 'Carlos',
                    'address' => 'Brazil',
                    'age' => '17'
                ]
                ];
                // insert semua data ke tabel
                $this->db->table('users')->insertBatch($data);
                //singgle insert
                //->insert($data);
                //multiple insert
                //->insertBatch($data);
        }
    }
}
