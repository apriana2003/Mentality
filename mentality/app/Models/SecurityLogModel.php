<?php
// app/Models/SecurityLogModel.php
namespace App\Models;

use CodeIgniter\Model;

class SecurityLogModel extends Model
{
    protected $table      = 'security_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ip_address', 'user_agent', 'method', 'uri',
        'threat_type', 'payload', 'severity', 'notified',
    ];
    protected $useTimestamps  = false; // created_at diset manual di DB
    protected $returnType     = 'array';

    public function logThreat(array $data): bool
    {
        return (bool) $this->insert($data);
    }

    public function getRecentThreats(int $limit = 50): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll($limit);
    }

    public function getThreatSummary(): array
    {
        return $this->select('threat_type, severity, COUNT(*) as total')
                    ->groupBy('threat_type, severity')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }
}
