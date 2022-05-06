<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{

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

    public function update($id = null)
    {
        if ($this->user->find($id)) {
            if ($this->user->update($id, $this->request->getRawInput())) {
                return $this->respond(['message' => "Updated successfully"]);
            } else {
                return $this->fail($this->user->errors());
            }
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    public function delete($id = null)
    {
        if ($this->user->find($id)) {
            if ($this->user->delete($id)) {
                return $this->respond(['message' => "Deleted successfully"]);
            } else {
                return $this->fail('Failed to deleted', 422);
            }
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    public function show($id = null)
    {
        if ($this->user->find($id)) {
            return $this->respond($this->user->find($id));
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
