<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'nama', 'alamat', 'password'
    ];

    protected $validationRules = [
        'username'         => ['label' => 'Username', 'rules' => 'required|min_length[3]|max_length[255]|is_unique[user.username,user.id,{user.id}]'],
        'nama'         => ['label' => 'Nama', 'rules' => 'required|min_length[3]|max_length[255]'],
        'alamat'         => ['label' => 'Alamat', 'rules' => 'required|min_length[3]|max_length[255]'],
        'password'          => ['label' => 'Password', 'rules' => 'required|min_length[5]|max_length[25]'],
    ];

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        if (isset($data['data']) && (!empty($data['data']))) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data']) && (!empty($data['data']))) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    public function get_data()
    {
        $builder = $this->db->table('user');
        $builder->limit(3);
        $query = $builder->get();
        return $query->getResultArray();
    }
}
