<?php
// app/Config/Filters.php
namespace Config;

use CodeIgniter\Config\BaseConfig;
use App\Filters\SecurityFilter;
use App\Filters\AdminAuthFilter;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'      => \CodeIgniter\Filters\CSRF::class,
        'toolbar'   => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'  => \CodeIgniter\Filters\Honeypot::class,
        'security'  => SecurityFilter::class,
        'adminAuth' => AdminAuthFilter::class,
    ];

    public array $globals = [
        'before' => [
            'honeypot',
            'security',
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    /**
     * CSRF hanya untuk form HTML biasa.
     * Route AJAX (chatbot, toggle) dikecualikan karena
     * tidak menggunakan form HTML — mereka pakai fetch() JSON.
     *
     * Validasi keamanan AJAX dilakukan via header
     * X-Requested-With: XMLHttpRequest di controller.
     */
    public array $filters = [
        'csrf' => [
            'before' => [
                'form/*',
                'tes/submit',
                'admin/login',
                'admin/blogs/save',
                'admin/pertanyaan-dass/save',
                'admin/form-fields/save',
            ]
        ],
    ];
}