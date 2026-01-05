<?php

require_once '../core/Controller.php';
require_once '../app/Models/Message.php';

class AdminMessageController extends Controller
{
    /**
     * Require manager role for all actions
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
     * List all messages (Admin inbox)
     */
    public function index()
    {
        $this->requireManager();

        $messageModel = new Message();

        $data = [
            'title' => 'Contact Messages',
            'messages' => $messageModel->getAll(),
            'unreadCount' => $messageModel->countUnread(),
            'totalCount' => $messageModel->count()
        ];

        $this->view('admin/messages/index', $data);
    }

    /**
     * View a single message and mark as read
     */
    public function show()
    {
        $this->requireManager();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Invalid message ID.';
            header("Location: " . base_url('/admin/messages'));
            exit;
        }

        $messageModel = new Message();
        $message = $messageModel->findById($id);

        if (!$message) {
            $_SESSION['error'] = 'Message not found.';
            header("Location: " . base_url('/admin/messages'));
            exit;
        }

        // Mark as read when viewing
        $messageModel->markAsRead($id);

        $data = [
            'title' => 'View Message',
            'message' => $message
        ];

        $this->view('admin/messages/show', $data);
    }

    /**
     * Toggle message read status
     */
    public function toggleRead()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Invalid message ID.';
            header("Location: " . base_url('/admin/messages'));
            exit;
        }

        $messageModel = new Message();
        $message = $messageModel->findById($id);

        if (!$message) {
            $_SESSION['error'] = 'Message not found.';
            header("Location: " . base_url('/admin/messages'));
            exit;
        }

        // Toggle read status
        if ($message['is_read']) {
            $messageModel->markAsUnread($id);
            $_SESSION['success'] = 'Message marked as unread.';
        } else {
            $messageModel->markAsRead($id);
            $_SESSION['success'] = 'Message marked as read.';
        }

        header("Location: " . base_url('/admin/messages'));
        exit;
    }

    /**
     * Delete a message
     */
    public function delete()
    {
        $this->requireManager();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Invalid message ID.';
            header("Location: " . base_url('/admin/messages'));
            exit;
        }

        $messageModel = new Message();
        $result = $messageModel->delete($id);

        if ($result) {
            $_SESSION['success'] = 'Message deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete message.';
        }

        header("Location: " . base_url('/admin/messages'));
        exit;
    }
}
