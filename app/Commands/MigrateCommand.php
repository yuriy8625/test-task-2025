<?php

declare(strict_types=1);

namespace App\Commands;

use Core\Console\Command;
use Core\Database\DB;
use Core\Support\Config;
use PDO;

class MigrateCommand extends Command
{
    protected string $migrationTable = 'migrations';
    protected string $migrationPath;

    protected PDO $pdo;

    public function __construct()
    {
        $this->migrationPath = Config::getInstance()->get('app.migration_path', 'migrations');
        $this->pdo = DB::getInstance()->getConnection();
    }

    public function handle(): int
    {
        try {
            $this->createMigrationTable();

            $executed = $this->getExecutedMigrations();
            $pending  = $this->getPendingMigrations($executed);

            if (empty($pending)) {
                $this->info('No new migrations to run.');
                return self::SUCCESS;
            }

            foreach ($pending as $migrationFile => $name) {
                if (!$this->runMigration($migrationFile, $name)) {
                    return self::FAILURE;
                }
            }

            $this->success('All migrations have been run successfully.');
            return self::SUCCESS;

        } catch (\Throwable $e) {
            $this->error("Migration failed: " . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Create migrations table.
     */
    protected function createMigrationTable(): void
    {
        $stmt = $this->pdo->query("SHOW TABLES LIKE '{$this->migrationTable}'");

        if ($stmt->rowCount() === 0) {
            $this->pdo->exec("
                CREATE TABLE `{$this->migrationTable}` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(255) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");

            $this->info("Created '{$this->migrationTable}' table.");
        }
    }

    /**
     * Get names of already executed migrations.
     */
    protected function getExecutedMigrations(): array
    {
        $stmt = $this->pdo->query("SELECT `name` FROM {$this->migrationTable}");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_column($res, 'name');
    }

    /**
     * Get pending migration files.
     */
    protected function getPendingMigrations(array $executed): array
    {
        $files = glob($this->migrationPath . '/*.php') ?: [];
        $pending = [];

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            if (!in_array($name, $executed, true)) {
                $pending[$file] = $name;
            }
        }
        return $pending;
    }

    /**
     * Run a single migration.
     */
    protected function runMigration(string $file, string $name): bool
    {
        try {
            $migration = include $file;

            if (!is_object($migration) || !method_exists($migration, 'run')) {
                throw new \RuntimeException("Migration {$name} is invalid.");
            }

            $migration->run();

            $stmt = $this->pdo->prepare("INSERT INTO {$this->migrationTable} (name) VALUES (:name)");
            $stmt->execute(['name' => $name]);

            $this->success("Migration {$name} has been run successfully.");
            return true;

        } catch (\Throwable $e) {
            $this->error("Failed migration {$name}: " . $e->getMessage());
            return false;
        }
    }
}
