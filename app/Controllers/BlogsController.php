public function blogsSave(): \CodeIgniter\HTTP\ResponseInterface
    {
        $model = new BlogModel();
        $id    = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');

        $data = [
            'judul'     => $judul,
            'slug'      => $id ? $model->find($id)['slug'] : $model->generateSlug($judul),
            'ringkasan' => $this->request->getPost('ringkasan'),
            'konten'    => $this->request->getPost('konten'),
            'kategori'  => $this->request->getPost('kategori'),
            'published' => $this->request->getPost('published') ? 1 : 0,
        ];

        // ── Handle upload gambar ke Cloudinary ───────────────
        $file = $this->request->getFile('gambar');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg','image/jpg','image/png','image/webp'];
            $maxSize      = 2048; // 2MB dalam KB

            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.');
            }

            if ($file->getSizeByUnit('kb') > $maxSize) {
                return redirect()->back()->withInput()
                    ->with('error', 'Ukuran gambar maksimal 2MB.');
            }

            // Upload ke Cloudinary
            $cloudinary = new \App\Libraries\CloudinaryHelper();
            $imageUrl   = $cloudinary->upload($file->getTempName(), 'mentality/blogs');

            if (!$imageUrl) {
                return redirect()->back()->withInput()
                    ->with('error', 'Gagal upload gambar ke Cloudinary. Coba lagi.');
            }

            // Hapus gambar lama di Cloudinary jika ada
            if ($id) {
                $old = $model->find($id);
                if ($old && $old['gambar'] && str_starts_with($old['gambar'], 'http')) {
                    $cloudinary->delete($old['gambar']);
                }
            }

            $data['gambar'] = $imageUrl;

        } elseif ($this->request->getPost('hapus_gambar') == '1' && $id) {
            $old = $model->find($id);
            if ($old && $old['gambar'] && str_starts_with($old['gambar'], 'http')) {
                $cloudinary = new \App\Libraries\CloudinaryHelper();
                $cloudinary->delete($old['gambar']);
            }
            $data['gambar'] = null;
        }

        if ($id) {
            $model->update($id, $data);
            $msg = 'Artikel berhasil diperbarui.';
        } else {
            $model->insert($data);
            $msg = 'Artikel berhasil ditambahkan.';
        }

        return redirect()->to('/admin/blogs')->with('success', $msg);
    }