<?php

require_once '../core/Controller.php';

class HomeController extends Controller
{
    /**
     * Show landing page (for guests only)
     * Logged-in users are redirected to dashboard
     */
    public function index()
    {
        // Guest guard: redirect logged-in users to dashboard
        $this->requireGuest();
        $this->view('landing');
    }
}
