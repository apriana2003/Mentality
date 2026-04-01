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
        $config = new Configuration();
        $config->cloud->cloudName = 'dftkqdftn';
        $config->cloud->apiKey    = '729417917272812';
        $config->cloud->apiSecret = '6rNcUzDtm1rPuvF2rYPIfD1bAeU';
        $config->url->secure      = true;

        $this->cloudinary = new Cloudinary($config);
    }

    public function upload(string $filePath, string $folder = 'mentality'): ?string
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($filePath, [
                'folder' => $folder,
            ]);

            return $result['secure_url'] ?? null;
        } catch (\Throwable $e) {
            log_message('error', 'Cloudinary upload error: ' . $e->getMessage());
            return null;
        }
    }

    public function delete(string $imageUrl): bool
    {
        try {
            preg_match('/mentality\/blogs\/([^\.]+)/', $imageUrl, $matches);
            if (empty($matches[1])) return false;

            $publicId = 'mentality/blogs/' . $matches[1];
            $this->cloudinary->uploadApi()->destroy($publicId);
            return true;
        } catch (\Throwable $e) {
            log_message('error', 'Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }
}