<?php
// app/Config/Exceptions.php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Exceptions extends BaseConfig
{
    public bool $log = true;
    public int  $logDepth = 25;

    // Sembunyikan info sensitif dari log
    public array $sensitiveDataInTrace = [
        'password', 'passwd', 'secret', 'api_key', 'token',
    ];

    // Tampilkan error detail hanya di development
    public string $errorViewPath = APPPATH . 'Views/errors/';

    // Custom handler untuk 404
    public ?\Closure $handler404 = null;

    public function __construct()
    {
        parent::__construct();

        // Override tampilan 404
        $this->handler404 = function(\CodeIgniter\Exceptions\PageNotFoundException $e) {
            $response = service('response');
            $response->setStatusCode(404);

            $errorPage = APPPATH . 'Views/errors/error_404.php';
            if (file_exists($errorPage)) {
                ob_start();
                include $errorPage;
                $html = ob_get_clean();
                $response->setBody($html);
            }

            return $response;
        };
    }
}