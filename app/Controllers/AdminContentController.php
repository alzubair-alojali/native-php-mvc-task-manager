<?php

require_once '../core/Controller.php';
require_once '../app/Models/Service.php';
require_once '../app/Models/Setting.php';

class AdminContentController extends Controller
{
    /**
     * Constructor - ensure user is authenticated and is a manager
     */
    private function requireManager()
    {
        $this->requireAuth();

        // Check if user has manager role
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'manager') {
            $_SESSION['error'] = 'Access denied. Manager privileges required.';
            header("Location: " . base_url('/dashboard'));
            exit;
        }
    }

    /**
     * Admin Content Management Dashboard
     * Shows services and settings management interface
     */
    public function index()
    {
        $this->requireManager();

        $serviceModel = new Service();
        $settingModel = new Setting();

        $data = [
            'title' => 'Content Management',
            'services' => $serviceModel->getAll(),
            'settings' => $settingModel->getAllAsAssociativeArray(),
            'settingsRaw' => $settingModel->getAll()
        ];

        $this->view('admin/content/index', $data);
    }

    // =========================================================================
    // SERVICES CRUD
    // =========================================================================

    /**
     * Store a new service
     */
    public function storeService()
    {
        $this->requireManager();

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-star');

        // Validation
        if (empty($title)) {
            $_SESSION['error'] = 'Service title is required.';
            header("Location: " . base_url('/admin/content'));
            exit;
        }

        $serviceModel = new Service();
        $result = $serviceModel->create([
            'title' => $title,
            'description' => $description,
            'icon' => $icon
        ]);

        if ($result) {
            $_SESSION['success'] = 'Service created successfully!';
        } else {
            $_SESSION['error'] = 'Failed to create service.';
        }

        header("Location: " . base_url('/admin/content'));
        exit;
    }

    /**
     * Update an existing service
     */
    public function updateService()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-star');

        if (!$id || empty($title)) {
            $_SESSION['error'] = 'Invalid service data.';
            header("Location: " . base_url('/admin/content'));
            exit;
        }

        $serviceModel = new Service();

        // Verify service exists
        if (!$serviceModel->findById($id)) {
            $_SESSION['error'] = 'Service not found.';
            header("Location: " . base_url('/admin/content'));
            exit;
        }

        $result = $serviceModel->update($id, [
            'title' => $title,
            'description' => $description,
            'icon' => $icon
        ]);

        if ($result) {
            $_SESSION['success'] = 'Service updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update service.';
        }

        header("Location: " . base_url('/admin/content'));
        exit;
    }

    /**
     * Delete a service
     */
    public function deleteService()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Invalid service ID.';
            header("Location: " . base_url('/admin/content'));
            exit;
        }

        $serviceModel = new Service();
        $result = $serviceModel->delete($id);

        if ($result) {
            $_SESSION['success'] = 'Service deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete service.';
        }

        header("Location: " . base_url('/admin/content'));
        exit;
    }

    // =========================================================================
    // SITE SETTINGS
    // =========================================================================

    /**
     * Update site settings (batch update)
     */
    public function updateSettings()
    {
        $this->requireManager();

        // Get settings from POST
        $settingsToUpdate = [];

        // Hero section
        if (isset($_POST['hero_heading'])) {
            $settingsToUpdate['hero_heading'] = trim($_POST['hero_heading']);
        }

        // About section
        if (isset($_POST['about_us_title'])) {
            $settingsToUpdate['about_us_title'] = trim($_POST['about_us_title']);
        }
        if (isset($_POST['about_us_content'])) {
            $settingsToUpdate['about_us_content'] = trim($_POST['about_us_content']);
        }

        // Any additional dynamic settings
        if (isset($_POST['settings']) && is_array($_POST['settings'])) {
            foreach ($_POST['settings'] as $key => $value) {
                $settingsToUpdate[$key] = trim($value);
            }
        }

        if (empty($settingsToUpdate)) {
            $_SESSION['error'] = 'No settings to update.';
            header("Location: " . base_url('/admin/content'));
            exit;
        }

        $settingModel = new Setting();
        $result = $settingModel->updateBatch($settingsToUpdate);

        if ($result) {
            $_SESSION['success'] = 'Settings updated successfully!';
        } else {
            $_SESSION['error'] = 'Some settings failed to update.';
        }

        header("Location: " . base_url('/admin/content'));
        exit;
    }
}
