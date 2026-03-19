<?php
// app/Models/FormFieldModel.php
namespace App\Models;

use CodeIgniter\Model;

class FormFieldModel extends Model
{
    protected $table         = 'form_fields';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'label','name','type','placeholder','options','required','aktif','urutan'
    ];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $validationRules = [
        'label'  => 'required|max_length[150]',
        'name'   => 'required|max_length[80]|alpha_dash',
        'type'   => 'required|in_list[text,email,number,select,radio,textarea]',
        'urutan' => 'required|integer',
    ];

    protected $validationMessages = [
        'name' => [
            'alpha_dash' => 'Nama field hanya boleh huruf, angka, dan underscore.',
        ],
    ];

    // Ambil semua field aktif urut berdasarkan urutan
    public function getAktif(): array
    {
        return $this->where('aktif', 1)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    // Ambil semua field (untuk admin)
    public function getAll(): array
    {
        return $this->orderBy('urutan', 'ASC')->findAll();
    }

    // Field default yang tidak boleh dihapus
    public function isDefault(string $name): bool
    {
        return in_array($name, ['nama', 'email', 'jenis_kelamin', 'usia']);
    }
}
