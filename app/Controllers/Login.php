<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class Login extends ResourceController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if ($header) {
            $token = explode(' ', $header)[1];
            try {
                $payload =  JWT::decode($token, new Key($key, 'HS256'));
                $data['payload'] = $payload;
                // the payload is std class
                $data['user'] = $this->userModel->find($payload->uid);
                return $this->respond($data);
            } catch (\Throwable $th) {
                return $this->failUnauthorized($th->getMessage());
            }
        }
        return $this->failUnauthorized('Token Required');
    }

    public function login()
    {
        $user = $this->userModel->where('username', $this->request->getVar('username'))->first();
        if ($user) {
            if (password_verify($this->request->getVar('password'), $user['password'])) {
                $key = getenv('TOKEN_SECRET');
                $payload = array(
                    "iat" => strtotime('now'),
                    "nbf" => strtotime('now'),
                    "exp" => strtotime(date("Y-m-d") . ' 24:00:00'),
                    "jti" => 'login',
                    // If u can't use a array use a std class
                    "uid" => $user['id'],
                );
                $data['message'] = 'Login successfully';
                $data['token'] = JWT::encode($payload, $key, 'HS256');
                $data['user'] = $user;
                return $this->respond($data);
            }
            return $this->fail('Wrong Password');
        }
        return $this->failNotFound('Username Not Found');
    }
}
