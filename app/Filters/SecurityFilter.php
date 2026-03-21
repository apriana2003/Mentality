<?php
// app/Filters/SecurityFilter.php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SecurityLogModel;

class SecurityFilter implements FilterInterface
{
    private array $sqliPatterns = [
        '/(\bUNION\b.*\bSELECT\b|\bSELECT\b.*\bFROM\b|\bDROP\b.*\bTABLE\b)/i',
        '/(\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bTRUNCATE\b).*\bINTO\b/i',
        "/(--|\/\*|\*\/|xp_|0x[0-9a-f]+)/i",
        '/\b(OR|AND)\b\s+[\d\'"]=[\d\'"]/i',
        '/sleep\s*\(\s*\d+\s*\)/i',
        '/benchmark\s*\(/i',
    ];

    private array $xssPatterns = [
        '/<script[\s\S]*?>[\s\S]*?<\/script>/i',
        '/javascript\s*:/i',
        '/<iframe|<object|<embed|<applet/i',
        '/eval\s*\(/i',
        '/document\.(cookie|write|location)/i',
    ];

    private array $pathTraversalPatterns = [
        '/\.\.[\/\\\\]/',
        '/\.(php|phtml|php3|php4|php5)\s*$/i',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $uri     = (string) $request->getUri();
        $method  = $request->getMethod();
        $ip      = $request->getIPAddress();
        $ua      = $request->getUserAgent()->getAgentString();

        // Skip filter untuk halaman admin
        if (strpos($uri, '/admin') !== false) {
            return null;
        }

        $allInput = array_merge($request->getGet() ?? [], $request->getPost() ?? []);
        $rawInput = json_encode($allInput);

        $threat   = null;
        $severity = 'Medium';
        $payload  = $rawInput;

        // Cek SQL Injection
        foreach ($this->sqliPatterns as $pattern) {
            if (preg_match($pattern, $rawInput) || preg_match($pattern, $uri)) {
                $threat = 'SQL Injection'; $severity = 'Critical'; break;
            }
        }

        // Cek XSS
        if (!$threat) {
            foreach ($this->xssPatterns as $pattern) {
                if (preg_match($pattern, $rawInput)) {
                    $threat = 'XSS Attack'; $severity = 'High'; break;
                }
            }
        }

        // Cek Path Traversal
        if (!$threat) {
            foreach ($this->pathTraversalPatterns as $pattern) {
                if (preg_match($pattern, $uri)) {
                    $threat = 'Path Traversal'; $severity = 'High'; break;
                }
            }
        }

        // Cek Scanner Tools
        if (!$threat) {
            $scanners = ['sqlmap','nikto','nmap','masscan','dirbuster','burpsuite','acunetix','nessus'];
            foreach ($scanners as $s) {
                if (stripos($ua, $s) !== false) {
                    $threat = 'Scanning Tool Detected'; $severity = 'High';
                    $payload = $ua; break;
                }
            }
        }

        if ($threat) {
            // Log ke database
            try {
                $logModel = new SecurityLogModel();
                $logModel->logThreat([
                    'ip_address'  => $ip,
                    'user_agent'  => substr($ua, 0, 500),
                    'method'      => strtoupper($method),
                    'uri'         => substr($uri, 0, 500),
                    'threat_type' => $threat,
                    'payload'     => substr($payload, 0, 1000),
                    'severity'    => $severity,
                ]);
            } catch (\Throwable $e) {
                log_message('error', 'SecurityFilter log error: ' . $e->getMessage());
            }

            // Notif email untuk High/Critical
            if (in_array($severity, ['High', 'Critical'])) {
                $this->notifyAdmin($threat, $severity, $ip, $uri);
            }

            // Kembalikan halaman 403
            $response = service('response');
            $response->setStatusCode(403);

            $errorPage = APPPATH . 'Views/errors/html/error_403.php';
            if (file_exists($errorPage)) {
                ob_start();
                include $errorPage;
                $html = ob_get_clean();
                $response->setBody($html);
                $response->setHeader('Content-Type', 'text/html; charset=UTF-8');
            } else {
                $response->setJSON([
                    'status'  => 'error',
                    'message' => 'Permintaan diblokir karena terdeteksi aktivitas mencurigakan.',
                    'code'    => 403,
                ]);
            }

            return $response;
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        $response->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        return $response;
    }

    private function notifyAdmin(string $threat, string $severity, string $ip, string $uri): void
    {
        try {
            $email = \Config\Services::email();
            $email->setFrom('noreply@mentality.id', 'Mentality Security');
            $email->setTo(env('security.alertEmail', 'admin@mentality.id'));
            $email->setSubject("[{$severity}] Security Alert: {$threat}");
            $email->setMessage("
                <h3>⚠️ Ancaman Terdeteksi</h3>
                <table border='1' cellpadding='8'>
                    <tr><td><b>Jenis</b></td><td>{$threat}</td></tr>
                    <tr><td><b>Severity</b></td><td>{$severity}</td></tr>
                    <tr><td><b>IP</b></td><td>{$ip}</td></tr>
                    <tr><td><b>URI</b></td><td>{$uri}</td></tr>
                    <tr><td><b>Waktu</b></td><td>" . date('Y-m-d H:i:s') . "</td></tr>
                </table>
                <p>Segera periksa <a href='" . base_url('admin/security-logs') . "'>Security Logs</a>.</p>
            ");
            $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'SecurityFilter email: ' . $e->getMessage());
        }
    }
}           