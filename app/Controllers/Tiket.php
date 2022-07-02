<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TiketModel;
 
class Tiket extends ResourceController
{
    use ResponseTrait;
    // get all product
    public function index()
    {
        $model = new TiketModel();
        $data = $model->findAll();
        $res = [];
        foreach ($data as $key => $v) {
            
        // print_r($v['name']);exit;
            $data[$key]['score'] = (int) $v['score'];
        }
        // print_r($res);exit;
        return $this->respond(['data' => $data], 200);
    }
 
    // get single product
    public function show($id = null)
    {
        $model = new TiketModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
 
    // create a product
    public function create()
    {
        $model = new TiketModel();
        $data = [
            'imageUrl' => $this->request->getPost('imageUrl'),
            'wisata' => $this->request->getPost('wisata'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'score' => $this->request->getPost('score')

        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
         
        return $this->respondCreated($data, 201);
    }
 
    // update product
    public function update($id = null)
    {
        $model = new TiketModel();
        $json = $this->request->getJSON();
        if($json){
            $data = [
                'imageUrl' => $json->imageUrl,
                'wisata' => $json->wisata,
                'name' => $json->name,
                'description' => $json->description,
                'price' => $json->price,
                'score' => $json->score

            ];
        }else{
            $input = $this->request->getRawInput();
            $data = [
                'imageUrl' => $input['imageUrl'],
                'wisata' => $input['wisata'],
                'name' => $input['name'],
                'description' => $input['description'],
                'price' => $input['price'],
                'score' => $input['score']

            ];
        }
        // Insert to Database
        $model->where('name', $id)->set($data)->update();
        // $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }
 
    // delete product
    public function delete($id = null)
    {
        $model = new TiketModel();
        $data = $model->where('name', $id)->first();
        if($data){
            $model->where('name', $id)->delete();
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];
             
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
         
    }
 
}