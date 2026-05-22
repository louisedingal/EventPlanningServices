<?php

declare(strict_types=1);

/**
 * Reads local MySQL data and writes Doctrine fixture classes under src/DataFixtures/.
 * Run: php scripts/generate-fixtures-from-db.php
 */

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

$url = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
if (!$url) {
    fwrite(STDERR, "DATABASE_URL not set\n");
    exit(1);
}

$params = parse_url($url);
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $params['host'] ?? '127.0.0.1',
    $params['port'] ?? 3306,
    ltrim($params['path'] ?? '', '/'),
);
$user = $params['user'] ?? '';
$pass = $params['pass'] ?? '';

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$pdo->exec("SET NAMES utf8mb4");

$fixturesDir = dirname(__DIR__) . '/src/DataFixtures';

$tables = [
    'user' => ['class' => 'UserFixtures', 'entity' => 'User', 'rows' => fetchAll($pdo, 'user')],
    'venue' => ['class' => 'VenueFixtures', 'entity' => 'Venue', 'rows' => fetchAll($pdo, 'venue')],
    'service_package' => ['class' => 'ServicePackageFixtures', 'entity' => 'ServicePackage', 'rows' => fetchAll($pdo, 'service_package')],
    'theme' => ['class' => 'ThemeFixtures', 'entity' => 'Theme', 'rows' => fetchAll($pdo, 'theme')],
    'event' => ['class' => 'EventFixtures', 'entity' => 'Event', 'rows' => fetchAll($pdo, 'event')],
    'event_request' => ['class' => 'EventRequestFixtures', 'entity' => 'EventRequest', 'rows' => fetchAll($pdo, 'event_request')],
    'activity_log' => ['class' => 'ActivityLogFixtures', 'entity' => 'ActivityLog', 'rows' => fetchAll($pdo, 'activity_log')],
];

foreach ($tables as $table => $meta) {
    $path = $fixturesDir . '/' . $meta['class'] . '.php';
    $content = buildFixtureFile($meta['class'], $meta['entity'], $table, $meta['rows']);
    file_put_contents($path, $content);
    echo sprintf("Wrote %s (%d rows)\n", $meta['class'], count($meta['rows']));
}

$appPath = $fixturesDir . '/AppFixtures.php';
file_put_contents($appPath, buildAppFixtures());
echo "Wrote AppFixtures.php\n";

function fetchAll(PDO $pdo, string $table): array
{
    $stmt = $pdo->query("SELECT * FROM `{$table}` ORDER BY id ASC");

    return $stmt->fetchAll();
}

function buildAppFixtures(): string
{
    return <<<'PHP'
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Optional entry point. Entity data lives in per-table fixture classes:
 * UserFixtures, VenueFixtures, ServicePackageFixtures, ThemeFixtures,
 * EventFixtures, EventRequestFixtures, ActivityLogFixtures.
 *
 * Load everything: php bin/console doctrine:fixtures:load
 * Regenerate from DB: php scripts/generate-fixtures-from-db.php
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Intentionally empty — see entity-specific fixture classes.
    }
}

PHP;
}

function buildFixtureFile(string $class, string $entity, string $table, array $rows): string
{
    $deps = dependenciesFor($table);
    $implements = $deps !== [] ? ' implements DependentFixtureInterface' : '';
    $useDeps = $deps !== [] ? "\nuse Doctrine\Common\DataFixtures\DependentFixtureInterface;" : '';
    $useAbstract = usesAbstractFixture($table)
        ? "\nuse Doctrine\Common\DataFixtures\AbstractFixture;"
        : "\nuse Doctrine\Bundle\FixturesBundle\Fixture;";
    $extends = usesAbstractFixture($table) ? 'AbstractFixture' : 'Fixture';

    $loadBody = generateLoadBody($table, $rows);
    $depsMethod = $deps !== []
        ? "\n\n    public function getDependencies(): array\n    {\n        return [\n            "
            . implode(",\n            ", array_map(static fn (string $d) => $d . '::class', $deps))
            . ",\n        ];\n    }"
        : '';

    $extraUses = extraEntityUses($table);
    $generatedAt = (new DateTimeImmutable())->format('Y-m-d H:i:s');

    return <<<PHP
<?php

namespace App\DataFixtures;

use App\Entity\\{$entity};{$extraUses}{$useAbstract}{$useDeps}
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture data exported from local `{$table}` table on {$generatedAt}.
 * Regenerate: php scripts/generate-fixtures-from-db.php
 */
class {$class} extends {$extends}{$implements}
{
    public function load(ObjectManager \$manager): void
    {
{$loadBody}
        \$manager->flush();
    }{$depsMethod}
}

PHP;
}

function extraEntityUses(string $table): string
{
    $uses = match ($table) {
        'venue', 'service_package', 'theme' => "\nuse App\Entity\User;",
        'event' => "\nuse App\Entity\User;\nuse App\Entity\Venue;\nuse App\Entity\ServicePackage;",
        'event_request' => "\nuse App\Entity\User;\nuse App\Entity\ServicePackage;",
        default => '',
    };

    return $uses;
}

function dependenciesFor(string $table): array
{
    return match ($table) {
        'venue', 'service_package', 'theme' => ['UserFixtures'],
        'event' => ['UserFixtures', 'VenueFixtures', 'ServicePackageFixtures'],
        'event_request' => ['UserFixtures', 'ServicePackageFixtures'],
        default => [],
    };
}

function needsReference(string $table): bool
{
    return in_array($table, ['user', 'venue', 'service_package', 'theme'], true);
}

function usesAbstractFixture(string $table): bool
{
    return in_array($table, ['user', 'venue', 'service_package', 'theme', 'event', 'event_request'], true);
}

function generateLoadBody(string $table, array $rows): string
{
    if ($rows === []) {
        return '        // No rows in local database.';
    }

    $lines = [];
    foreach ($rows as $row) {
        $varName = singularVar($table) . '_' . $row['id'];
        $var = '$' . $varName;
        $lines[] = '        ' . $var . ' = new ' . entityClass($table) . '();';
        $lines = array_merge($lines, setterLines($table, $row, $varName));
        $lines[] = '        $manager->persist(' . $var . ');';
        if (needsReference($table)) {
            $lines[] = "        \$this->addReference('" . refKey($table, (int) $row['id']) . "', " . $var . ');';
        }
        $lines[] = '';
    }

    return implode("\n", $lines);
}

function singularVar(string $table): string
{
    return match ($table) {
        'user' => 'user',
        'venue' => 'venue',
        'service_package' => 'servicePackage',
        'theme' => 'theme',
        'event' => 'event',
        'event_request' => 'eventRequest',
        'activity_log' => 'activityLog',
        default => 'entity',
    };
}

function entityClass(string $table): string
{
    return match ($table) {
        'user' => 'User',
        'venue' => 'Venue',
        'service_package' => 'ServicePackage',
        'theme' => 'Theme',
        'event' => 'Event',
        'event_request' => 'EventRequest',
        'activity_log' => 'ActivityLog',
        default => 'Entity',
    };
}

function refKey(string $table, int $id): string
{
    return match ($table) {
        'user' => 'user_' . $id,
        'venue' => 'venue_' . $id,
        'service_package' => 'service_package_' . $id,
        'theme' => 'theme_' . $id,
        default => $table . '_' . $id,
    };
}

function setterLines(string $table, array $row, string $varName): array
{
    $lines = [];
    $var = '$' . $varName;

    foreach ($row as $column => $value) {
        if ($column === 'id') {
            continue;
        }

        $setter = setterFor($table, $column);
        if ($setter === null) {
            continue;
        }

        if (isFkColumn($column)) {
            if ($value === null || $value === '') {
                continue;
            }
            $refTable = fkTable($column);
            $lines[] = '        ' . $var . '->' . $setter . '($this->getReference(\'' . refKey($refTable, (int) $value) . '\', ' . fkEntity($refTable) . '::class));';
            continue;
        }

        $expr = exportValue($table, $column, $value);
        $lines[] = '        ' . $var . '->' . $setter . '(' . $expr . ');';
    }

    return $lines;
}

function setterFor(string $table, string $column): ?string
{
    static $map = [
        'user' => [
            'email' => 'setEmail',
            'roles' => 'setRoles',
            'password' => 'setPassword',
            'name' => 'setName',
            'status' => 'setStatus',
            'created_at' => 'setCreatedAt',
            'last_name' => 'setLastName',
            'username' => 'setUsername',
            'is_verified' => 'setIsVerified',
            'verification_token' => 'setVerificationToken',
        ],
        'venue' => [
            'name' => 'setName',
            'address' => 'setAddress',
            'capacity' => 'setCapacity',
            'contact_info' => 'setContactInfo',
            'created_by_id' => 'setCreatedBy',
        ],
        'service_package' => [
            'name' => 'setName',
            'description' => 'setDescription',
            'price' => 'setPrice',
            'image_path' => 'setImagePath',
            'created_by_id' => 'setCreatedBy',
        ],
        'theme' => [
            'name' => 'setName',
            'description' => 'setDescription',
            'event_type' => 'setEventType',
            'created_by_id' => 'setCreatedBy',
            'sample_image_paths' => 'setSampleImagePaths',
        ],
        'event' => [
            'customer_name' => 'setCustomerName',
            'event_type' => 'setEventType',
            'event_date' => 'setEventDate',
            'venue' => 'setVenue',
            'theme' => 'setTheme',
            'guest_count' => 'setGuestCount',
            'price' => 'setPrice',
            'venue_ref_id' => 'setVenueRef',
            'package_id' => 'setPackage',
            'created_by_id' => 'setCreatedBy',
        ],
        'event_request' => [
            'requested_by_id' => 'setRequestedBy',
            'event_type' => 'setEventType',
            'preferred_date' => 'setPreferredDate',
            'estimated_guest_count' => 'setEstimatedGuestCount',
            'preferred_venue' => 'setPreferredVenue',
            'theme' => 'setTheme',
            'special_requests' => 'setSpecialRequests',
            'budget' => 'setBudget',
            'created_at' => 'setCreatedAt',
            'status' => 'setStatus',
            'admin_notes' => 'setAdminNotes',
            'source' => 'setSource',
            'service_package_id' => 'setServicePackage',
            'preferred_time' => 'setPreferredTime',
            'preferred_style_label' => 'setPreferredStyleLabel',
            'preferred_style_image_path' => 'setPreferredStyleImagePath',
        ],
        'activity_log' => [
            'user_email' => 'setUserEmail',
            'user_role' => 'setUserRole',
            'action' => 'setAction',
            'entity_type' => 'setEntityType',
            'entity_id' => 'setEntityId',
            'affected_data' => 'setAffectedData',
            'description' => 'setDescription',
            'created_at' => 'setCreatedAt',
        ],
    ];

    return $map[$table][$column] ?? null;
}

function isFkColumn(string $column): bool
{
    return str_ends_with($column, '_id');
}

function fkTable(string $column): string
{
    return match ($column) {
        'created_by_id' => 'user',
        'venue_ref_id' => 'venue',
        'package_id' => 'service_package',
        'requested_by_id' => 'user',
        'service_package_id' => 'service_package',
        default => 'user',
    };
}

function fkEntity(string $table): string
{
    return entityClass($table);
}

function exportValue(string $table, string $column, mixed $value): string
{
    if ($value === null) {
        return 'null';
    }

    if ($column === 'roles') {
        $decoded = json_decode((string) $value, true);
        if (!is_array($decoded)) {
            $decoded = [];
        }

        return exportArrayOfStrings($decoded);
    }

    if ($column === 'sample_image_paths') {
        $decoded = json_decode((string) $value, true);
        if (!is_array($decoded)) {
            return 'null';
        }

        return exportArrayOfStrings(array_values($decoded));
    }

    if ($column === 'is_verified') {
        return ((int) $value) === 1 ? 'true' : 'false';
    }

    if ($column === 'event_date' || ($column === 'created_at' && $table === 'user')) {
        return exportDateTimeImmutable((string) $value);
    }

    if ($column === 'created_at' && $table === 'activity_log') {
        return exportDateTimeImmutable((string) $value);
    }

    if ($column === 'created_at' && $table === 'event_request') {
        return exportDateTime((string) $value);
    }

    if ($column === 'preferred_date') {
        return exportDateTime((string) $value);
    }

    if ($column === 'price' || ($table === 'service_package' && $column === 'price')) {
        return (string) (float) $value;
    }

    if (in_array($column, ['guest_count', 'estimated_guest_count', 'capacity', 'entity_id'], true)) {
        return (string) (int) $value;
    }

    return exportString((string) $value);
}

function exportString(string $value): string
{
    $clean = sanitizeUtf8($value);

    return var_export($clean, true);
}

function exportArrayOfStrings(array $items): string
{
    $parts = array_map(static fn ($s) => exportString((string) $s), $items);

    return '[' . implode(', ', $parts) . ']';
}

function exportDateTimeImmutable(string $value): string
{
    $dt = new DateTimeImmutable($value);

    return 'new \\DateTimeImmutable(' . exportString($dt->format('Y-m-d H:i:s')) . ')';
}

function exportDateTime(string $value): string
{
    $dt = new DateTime($value);

    return 'new \\DateTime(' . exportString($dt->format('Y-m-d H:i:s')) . ')';
}

function sanitizeUtf8(string $value): string
{
    if (mb_check_encoding($value, 'UTF-8')) {
        return $value;
    }

    return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
}
