<?php
// app/Models/BlogModel.php
namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table         = 'blogs';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['judul','slug','ringkasan','konten','gambar','kategori','published'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function getPublished(int $limit = 10, int $offset = 0): array
    {
        return $this->where('published', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    public function getBySlug(string $slug): array|null
    {
        return $this->where('slug', $slug)->where('published', 1)->first();
    }

    public function generateSlug(string $judul): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul), '-'));
        $base = $slug;
        $i    = 1;
        while ($this->where('slug', $slug)->countAllResults() > 0) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
