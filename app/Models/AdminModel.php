<?php
// app/Models/AdminModel.php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table         = 'admin';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama', 'email', 'password'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';
}
