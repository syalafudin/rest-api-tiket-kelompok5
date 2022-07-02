<?php

namespace App\Models;

use CodeIgniter\Model;

class TiketModel extends Model
{
    protected $table            = 'tiket';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'imageUrl','wisata','name','description','price','score'
    ];
    

    
}
