<?php
/**
 * Database Seeder - Libyan Test Data
 * 
 * IDEMPOTENT: Safe to run multiple times - checks for existing data first.
 * Populates the database with realistic Libyan names, cities, and projects.
 * 
 * Usage: php database/database_seed.php
 */

require_once __DIR__ . '/../config/database.php';

$isCLI = php_sapi_name() === 'cli';

function output($message, $isCLI)
{
    if ($isCLI) {
        echo $message . "\n";
    } else {
        echo "<p>$message</p>";
    }
}

if (!$isCLI) {
    echo "<!DOCTYPE html><html><head><title>Database Seeder</title></head><body>";
    echo "<h1>🇱🇾 Database Seeder</h1>";
}

output("🇱🇾 Libyan Database Seeder", $isCLI);
output("==========================", $isCLI);
output("", $isCLI);

try {
    // =========================================
    // IDEMPOTENT CHECK: Skip if data exists
    // =========================================
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = (int) $stmt->fetchColumn();

    if ($userCount > 0) {
        output("✅ Database already seeded! Found $userCount users.", $isCLI);
        output("ℹ️  Skipping seeding to prevent duplicates.", $isCLI);
        output("", $isCLI);
        output("To re-seed, manually clear the database first.", $isCLI);

        if (!$isCLI) {
            echo "</body></html>";
        }
        exit(0);
    }

    output("🌱 No existing data found. Starting fresh seed...", $isCLI);
    output("", $isCLI);

    // =========================================
    // Step 1: Insert Users (1 Manager, 3 Employees)
    // =========================================
    output("👥 Creating users...", $isCLI);

    $password = password_hash('password123', PASSWORD_DEFAULT);

    $users = [
        ['Mohammed Al-Faitouri', 'mohammed@tripoli.ly', 'manager'],
        ['Salim Benali', 'salim@benghazi.ly', 'employee'],
        ['Fatima Al-Sharif', 'fatima@misrata.ly', 'employee'],
        ['Ahmed Al-Mahdi', 'ahmed@tripoli.ly', 'employee'],
    ];

    $userIds = [];
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");

    foreach ($users as $user) {
        $stmt->execute([$user[0], $user[1], $password, $user[2]]);
        $userIds[] = $pdo->lastInsertId();
        output("   ✓ Created: {$user[0]} ({$user[2]})", $isCLI);
    }

    $managerId = $userIds[0];
    $employeeIds = array_slice($userIds, 1);

    output("", $isCLI);

    // =========================================
    // Step 2: Insert Projects (2 Projects)
    // =========================================
    output("📁 Creating projects...", $isCLI);

    $projects = [
        [
            'title' => 'Tripoli Port Expansion',
            'description' => 'Modernization and expansion of the Tripoli seaport to increase cargo capacity and improve logistics infrastructure for international trade.',
            'deadline' => date('Y-m-d', strtotime('+3 months')),
            'status' => 'active'
        ],
        [
            'title' => 'Benghazi Tech Hub',
            'description' => 'Development of a technology innovation center in Benghazi to support startups, provide training programs, and attract tech investments to Eastern Libya.',
            'deadline' => date('Y-m-d', strtotime('+6 months')),
            'status' => 'pending'
        ],
    ];

    $projectIds = [];
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, deadline, status, manager_id) VALUES (?, ?, ?, ?, ?)");

    foreach ($projects as $project) {
        $stmt->execute([
            $project['title'],
            $project['description'],
            $project['deadline'],
            $project['status'],
            $managerId
        ]);
        $projectIds[] = $pdo->lastInsertId();
        output("   ✓ Created: {$project['title']}", $isCLI);
    }

    output("", $isCLI);

    // =========================================
    // Step 3: Add Project Members
    // =========================================
    output("🤝 Adding project members...", $isCLI);

    $stmt = $pdo->prepare("INSERT INTO project_members (project_id, user_id) VALUES (?, ?)");

    // Add all employees to first project
    foreach ($employeeIds as $empId) {
        $stmt->execute([$projectIds[0], $empId]);
    }
    output("   ✓ Added 3 members to Tripoli Port Expansion", $isCLI);

    // Add 2 employees to second project
    $stmt->execute([$projectIds[1], $employeeIds[0]]);
    $stmt->execute([$projectIds[1], $employeeIds[1]]);
    output("   ✓ Added 2 members to Benghazi Tech Hub", $isCLI);

    output("", $isCLI);

    // =========================================
    // Step 4: Insert Tasks (5 Tasks)
    // =========================================
    output("📋 Creating tasks...", $isCLI);

    $tasks = [
        // Tripoli Port Expansion Tasks
        [
            'title' => 'Site Survey and Assessment',
            'description' => 'Conduct comprehensive survey of current port facilities and identify areas for expansion.',
            'due_date' => date('Y-m-d', strtotime('+2 weeks')),
            'status' => 'in_progress',
            'priority' => 'high',
            'project_id' => $projectIds[0],
            'assigned_to' => $employeeIds[0]
        ],
        [
            'title' => 'Environmental Impact Study',
            'description' => 'Prepare environmental impact assessment report for regulatory approval.',
            'due_date' => date('Y-m-d', strtotime('+1 month')),
            'status' => 'pending',
            'priority' => 'high',
            'project_id' => $projectIds[0],
            'assigned_to' => $employeeIds[1]
        ],
        [
            'title' => 'Contractor Bidding Process',
            'description' => 'Prepare RFP documents and manage contractor selection process.',
            'due_date' => date('Y-m-d', strtotime('+6 weeks')),
            'status' => 'pending',
            'priority' => 'medium',
            'project_id' => $projectIds[0],
            'assigned_to' => $employeeIds[2]
        ],

        // Benghazi Tech Hub Tasks
        [
            'title' => 'Market Research - Tech Sector',
            'description' => 'Analyze the technology sector in Eastern Libya and identify key opportunities.',
            'due_date' => date('Y-m-d', strtotime('+3 weeks')),
            'status' => 'in_progress',
            'priority' => 'medium',
            'project_id' => $projectIds[1],
            'assigned_to' => $employeeIds[0]
        ],
        [
            'title' => 'Location Scouting',
            'description' => 'Identify and evaluate potential locations for the tech hub in Benghazi.',
            'due_date' => date('Y-m-d', strtotime('+1 month')),
            'status' => 'pending',
            'priority' => 'low',
            'project_id' => $projectIds[1],
            'assigned_to' => $employeeIds[1]
        ],
    ];

    $taskIds = [];
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, due_date, status, priority, project_id, assigned_to, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($tasks as $task) {
        $stmt->execute([
            $task['title'],
            $task['description'],
            $task['due_date'],
            $task['status'],
            $task['priority'],
            $task['project_id'],
            $task['assigned_to'],
            $managerId
        ]);
        $taskIds[] = $pdo->lastInsertId();
        output("   ✓ Created: {$task['title']}", $isCLI);
    }

    output("", $isCLI);

    // =========================================
    // Step 5: Insert Sample Comments
    // =========================================
    output("💬 Adding sample comments...", $isCLI);

    $comments = [
        ['task_id' => $taskIds[0], 'user_id' => $employeeIds[0], 'body' => 'Survey equipment has been procured. Starting fieldwork tomorrow.'],
        ['task_id' => $taskIds[0], 'user_id' => $managerId, 'body' => 'Excellent progress! Please share preliminary findings by end of week.'],
        ['task_id' => $taskIds[3], 'user_id' => $employeeIds[0], 'body' => 'Initial research indicates strong demand for software development training.'],
    ];

    $stmt = $pdo->prepare("INSERT INTO comments (body, user_id, task_id) VALUES (?, ?, ?)");

    foreach ($comments as $comment) {
        $stmt->execute([$comment['body'], $comment['user_id'], $comment['task_id']]);
    }
    output("   ✓ Added 3 sample comments", $isCLI);

    // =========================================
    // Summary
    // =========================================
    output("", $isCLI);
    output("🎉 Seeding Complete!", $isCLI);
    output("====================", $isCLI);
    output("✓ Users:    4 (1 Manager, 3 Employees)", $isCLI);
    output("✓ Projects: 2", $isCLI);
    output("✓ Tasks:    5", $isCLI);
    output("✓ Comments: 3", $isCLI);
    output("", $isCLI);
    output("📧 Login Credentials:", $isCLI);
    output("   Manager:  mohammed@tripoli.ly / password123", $isCLI);
    output("   Employee: salim@benghazi.ly / password123", $isCLI);
    output("", $isCLI);

} catch (PDOException $e) {
    output("❌ Error: " . $e->getMessage(), $isCLI);
    exit(1);
}

if (!$isCLI) {
    echo "</body></html>";
}
