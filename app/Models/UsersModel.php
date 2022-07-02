<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'username','firstname','lastname','address','password','role'
    ];
    protected $returnType = 'App\Entities\Users';
    protected $useTimetamps    = false;
    
    public function findByld($id)
    {
        $data = $this->find($id);
        if($data) {
            return $data;
        }
        return false;
    }

    
}

class AdminModel extends Model
{
    protected $table            = 'admin';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'username','firstname','lastname','address','password','role'
    ];
    protected $returnType = 'App\Entities\admin';
    protected $useTimetamps    = false;
    
    public function findByld($id)
    {
        $data = $this->find($id);
        if($data) {
            return $data;
        }
        return false;
    }

    
}
