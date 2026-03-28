<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';

class AdminAuthService
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT id, full_name, email, password_hash, role, status
            FROM jobs_admin_users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    public static function login(string $email, string $password): bool
    {
        $admin = self::findByEmail($email);

        if (!$admin) {
            return false;
        }

        if ($admin['status'] !== 'active') {
            return false;
        }

        if (!password_verify($password, $admin['password_hash'])) {
            return false;
        }

        $_SESSION['admin_user'] = [
            'id' => $admin['id'],
            'full_name' => $admin['full_name'],
            'email' => $admin['email'],
            'role' => $admin['role'],
        ];

        $pdo = db();
        $stmt = $pdo->prepare("UPDATE jobs_admin_users SET last_login_at = NOW() WHERE id = :id");
        $stmt->execute([':id' => $admin['id']]);

        return true;
    }

    public static function logout(): void
    {
        unset($_SESSION['admin_user']);
    }
}