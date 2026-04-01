<?php
// app/Controllers/BlogsController.php
namespace App\Controllers;

use App\Models\BlogModel;

class BlogsController extends BaseController
{
    public function index(): string
    {
        $model = new BlogModel();
        $page  = (int) ($this->request->getGet('page') ?? 1);
        $limit = 6;

        return view('layouts/main', [
            'content' => view('blogs/index', [
                'blogs' => $model->getPublished($limit, ($page - 1) * $limit),
                'page'  => $page,
                'total' => $model->where('published', 1)->countAllResults(),
                'limit' => $limit,
            ]),
            'title' => 'Blog Kesehatan Mental - Mentality',
        ]);
    }

    public function detail(string $slug): string
    {
        $model = new BlogModel();
        $blog  = $model->getBySlug($slug);

        if (!$blog) {
            return redirect()->to('/blogs')->with('error', 'Artikel tidak ditemukan.');
        }

        return view('layouts/main', [
            'content' => view('blogs/detail', ['blog' => $blog]),
            'title'   => $blog['judul'] . ' - Mentality',
        ]);
    }
}