<?php
// app/Libraries/CloudinaryHelper.php
namespace App\Libraries;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryHelper
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('cloudinary_cloudName', 'dftkqdftn'),
                'api_key'    => env('cloudinary_apiKey', '729417917272812'),
                'api_secret' => env('cloudinary_apiSecret', '6rNcUzDtm1rPuvF2rYPIfD1bAeU'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        $this->cloudinary = new Cloudinary();
    }

    /**
     * Upload gambar ke Cloudinary
     * @param string $filePath path file lokal
     * @param string $folder folder di Cloudinary
     * @return string|null URL gambar
     */
    public function upload(string $filePath, string $folder = 'mentality'): ?string
    {
        try {
            $result = (new UploadApi())->upload($filePath, [
                'folder'         => $folder,
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]);

            return $result['secure_url'] ?? null;
        } catch (\Throwable $e) {
            log_message('error', 'Cloudinary upload error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Hapus gambar dari Cloudinary berdasarkan URL
     */
    public function delete(string $imageUrl): bool
    {
        try {
            // Ambil public_id dari URL
            preg_match('/\/mentality\/([^\.]+)/', $imageUrl, $matches);
            if (empty($matches[1])) return false;

            $publicId = 'mentality/' . $matches[1];
            (new UploadApi())->destroy($publicId);
            return true;
        } catch (\Throwable $e) {
            log_message('error', 'Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }
}