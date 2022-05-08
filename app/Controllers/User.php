<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class User extends ResourceController
{
    use ResponseTrait;
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        return $this->respond($this->user->findAll());
    }

    public function create()
    {
        if ($this->user->save($this->request->getVar())) {
            return $this->respond(['message' => "Saved successfully"]);
        }
        return $this->fail($this->user->errors());
    }
    // Simple Update 
    public function update($id = null)
    {
        if ($this->user->find($id)) {
            if ($this->user->update($id, $this->request->getRawInput())) {
                return $this->respond(['message' => "Updated successfully"]);
            } else {
                return $this->fail($this->user->errors());
            }
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }

    // Flexible Where any update
    // public function update($id = null)
    // {
    //     $valid = [
    //         'username' => 'required|is_unique[user.username,user.id{id}]',
    //         'nama' => 'required|min_lengt[5]|',
    //         'alamat' => 'required|min_lengt[5]|',
    //         'password' => 'required|min_lengt[5]|',
    //     ];
    //     if ($this->user->find($id)) {
    //         if (!$this->validate($valid)) {
    //             return $this->fail($this->validator->getErrors());
    //         } else {
    //             $data = [
    //                 'username' => $this->request->getRawInput('username'),
    //                 'nama' => $this->request->getRawInput('nama'),
    //                 'alamat' => $this->request->getRawInput('alamat'),
    //                 'password' => $this->request->getRawInput('password'),
    //             ];
    //             $this->user->update($id, $data);
    //             return $this->respond(['message' => "Updated Successfully"]);
    //         }
    //     } else {
    //         return $this->failNotFound('No Data Found With Id' . $id);
    //     }
    // }

    public function delete($id = null)
    {
        if ($this->user->find($id)) {
            if ($this->user->delete($id)) {
                return $this->respond(['message' => "Deleted successfully"]);
            } else {
                return $this->fail('Failed to deleted', 422);
            }
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }

    public function show($id = null)
    {
        if ($this->user->find($id)) {
            return $this->respond($this->user->find($id));
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }
}
