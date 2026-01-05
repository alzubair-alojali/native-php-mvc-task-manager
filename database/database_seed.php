<?php

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

    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = (int) $stmt->fetchColumn();

    // Flag to track if we need to seed task manager data
    $seedTaskManager = ($userCount === 0);

    if (!$seedTaskManager) {
        output("ℹ️  Found $userCount existing users. Skipping Task Manager data.", $isCLI);
        output("   Will still check Landing Page data (services, settings, messages)...", $isCLI);
        output("", $isCLI);
    } else {
        output("🌱 No existing data found. Starting fresh seed...", $isCLI);
        output("", $isCLI);
    }

    // =========================================================================
    // TASK MANAGER DATA (only if no users exist)
    // =========================================================================

    if ($seedTaskManager) {
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

        output("🤝 Adding project members...", $isCLI);

        $stmt = $pdo->prepare("INSERT INTO project_members (project_id, user_id) VALUES (?, ?)");

        foreach ($employeeIds as $empId) {
            $stmt->execute([$projectIds[0], $empId]);
        }
        output("   ✓ Added 3 members to Tripoli Port Expansion", $isCLI);

        $stmt->execute([$projectIds[1], $employeeIds[0]]);
        $stmt->execute([$projectIds[1], $employeeIds[1]]);
        output("   ✓ Added 2 members to Benghazi Tech Hub", $isCLI);

        output("", $isCLI);

        output("📋 Creating tasks...", $isCLI);

        $tasks = [
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

        output("", $isCLI);

    } // End of $seedTaskManager block

    // =========================================================================
    // LANDING PAGE DATA (always check, independent of task manager data)
    // =========================================================================

    output("🌐 Checking landing page content...", $isCLI);

    // --- Services (check if already seeded) ---
    $stmt = $pdo->query("SELECT COUNT(*) FROM services");
    $serviceCount = (int) $stmt->fetchColumn();

    if ($serviceCount === 0) {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Custom websites and web applications built with modern technologies. From responsive landing pages to complex enterprise solutions.',
                'icon' => 'fa-code'
            ],
            [
                'title' => 'Mobile Applications',
                'description' => 'Native and cross-platform mobile apps for iOS and Android. Intuitive user experiences that engage your customers.',
                'icon' => 'fa-mobile-alt'
            ],
            [
                'title' => 'SEO & Digital Marketing',
                'description' => 'Boost your online presence with our SEO strategies and digital marketing campaigns. Drive traffic and increase conversions.',
                'icon' => 'fa-search'
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO services (title, description, icon) VALUES (?, ?, ?)");

        foreach ($services as $service) {
            $stmt->execute([$service['title'], $service['description'], $service['icon']]);
        }
        output("   ✓ Created 3 services", $isCLI);
    } else {
        output("   ℹ️  Services already exist, skipping...", $isCLI);
    }

    // --- Site Settings (check if already seeded) ---
    $stmt = $pdo->query("SELECT COUNT(*) FROM site_settings");
    $settingsCount = (int) $stmt->fetchColumn();

    if ($settingsCount === 0) {
        $settings = [
            [
                'setting_key' => 'hero_heading',
                'setting_value' => 'Manage Your Projects with Ease'
            ],
            [
                'setting_key' => 'about_us_title',
                'setting_value' => 'About Artisans Task Manager'
            ],
            [
                'setting_key' => 'about_us_content',
                'setting_value' => 'Artisans Task Manager is a powerful project management solution built in Libya for teams worldwide. We help organizations streamline their workflows, collaborate effectively, and deliver projects on time. Our platform combines simplicity with powerful features to boost your team productivity.'
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");

        foreach ($settings as $setting) {
            $stmt->execute([$setting['setting_key'], $setting['setting_value']]);
        }
        output("   ✓ Created 3 site settings", $isCLI);
    } else {
        output("   ℹ️  Site settings already exist, skipping...", $isCLI);
    }

    // --- Messages (check if already seeded) ---
    $stmt = $pdo->query("SELECT COUNT(*) FROM messages");
    $messageCount = (int) $stmt->fetchColumn();

    if ($messageCount === 0) {
        $messages = [
            [
                'name' => 'Omar Al-Zawawi',
                'email' => 'omar.zawawi@example.com',
                'message' => 'I am interested in learning more about your project management services. Can we schedule a demo?',
                'is_read' => false
            ],
            [
                'name' => 'Layla Hassan',
                'email' => 'layla.h@example.com',
                'message' => 'Great platform! I have been using it for my team and we love the task tracking features. Keep up the good work!',
                'is_read' => true
            ],
        ];

        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message, is_read) VALUES (?, ?, ?, ?)");

        foreach ($messages as $msg) {
            $stmt->execute([$msg['name'], $msg['email'], $msg['message'], $msg['is_read'] ? 'true' : 'false']);
        }
        output("   ✓ Created 2 sample messages", $isCLI);
    } else {
        output("   ℹ️  Messages already exist, skipping...", $isCLI);
    }

    output("", $isCLI);
    output("🎉 Seeding Complete!", $isCLI);
    output("====================", $isCLI);
    output("✓ Users:         4 (1 Manager, 3 Employees)", $isCLI);
    output("✓ Projects:      2", $isCLI);
    output("✓ Tasks:         5", $isCLI);
    output("✓ Comments:      3", $isCLI);
    output("✓ Services:      3", $isCLI);
    output("✓ Site Settings: 3", $isCLI);
    output("✓ Messages:      2", $isCLI);
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

