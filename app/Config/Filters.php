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
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    // CSRF hanya untuk form HTML biasa
    // Chatbot pakai AJAX JSON jadi tidak butuh CSRF di sini
    public array $filters = [
        'csrf' => [
            'before' => [
                'form/*',
                'tes/*',
                'admin/*',
            ]
        ],
    ];
}