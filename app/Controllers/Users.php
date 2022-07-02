<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsersModel;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    public function _construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data,'register');
        $errors = $this->validation->getErrors();

        if ($errors){
        return $this->fail($errors);
        }

        $user = new \App\Entities\Users();
        $user->fill($data);
        $user->created_by = 0;
        $user->created_date = date("Y-m-d H:i:s");

        if($this->model->save($user)) {
            return $this->respondCreated($user, 'user created');
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $validate = $this->validation->run($data, 'update_user');
        $errors = $this->validation->getErrors();

        if($errors) {
            return $this->fail($errors);
        }

        if(!$this->model->findByld($id)) {
            return $this->fail('id tidak ditemukan');
        }

        $user = new \App\Entities\Users();
        $user->fill($data);
        $user->updated_by = 0;
        $user->updated_date = date("Y-m-d H:i:s");

        if($this->model->save($user)) {
            return $this->respondUpdated($user, 'user updated');
        }
    }

    public function delete($id = null)
    {
        if(!$this->model->findByld($id)) {
            return $this->fail('id tidak ditemukan');
        }

        if(!$this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id . 'Deleted']);
        }
    }

    public function show($id = null){
        $data = $this->model->findByld($id);

        if($data) {
            return $this->respond($data);
        }

        return $this->fail('id tidak ditemukan');
    }

    public function register(){
        $model = new UsersModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'address' => $this->request->getPost('address'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role')
        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $model->insert($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ],
            'data'     => $data
        ];
         
        return $this->respondCreated($response, 201);
    }

    public function login(){
        $model = new UsersModel();
        $data = [
            'usernames' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];
        $data = json_decode(file_get_contents("php://input"));

        $data_response = $model->getWhere(['username' => $data->username, 'password' => $data->password])->getRow();
        if ($data_response) {
            $response = [
                'status'   => 200,
                'error'    => null,
                'data'     => $data_response
            ];
        } else {
            $response = [
                'status'   => 200,
                'error'    => 'data not found',
                'data'     => null
            ];
        }
        
         
        return $this->respondCreated($response, 200);
    }
    
}
