<?php
// app/Models/MahasiswaModel.php
namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama','email','nim','universitas','jenis_kelamin','usia'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';

    protected $validationRules = [
        'nama'          => 'required|min_length[2]|max_length[100]|alpha_space',
        'email'         => 'required|valid_email|max_length[150]',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'usia'          => 'required|integer|greater_than[14]|less_than[100]',
        'nim'           => 'permit_empty|max_length[30]',
        'universitas'   => 'permit_empty|max_length[150]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'    => 'Nama wajib diisi.',
            'alpha_space' => 'Nama hanya boleh huruf dan spasi.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
    ];
}
