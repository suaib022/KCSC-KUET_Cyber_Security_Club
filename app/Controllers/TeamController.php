<?php
class TeamController
{
    /**
     * Display the team page.
     */
    public function index(): void
    {
        // Fetch team members from database
        require_once APP_ROOT . '/config/database.php';
        require_once APP_ROOT . '/app/Models/Member.php';
        
        $db = getDBConnection();
        $memberModel = new Member($db);
        $teamMembers = $memberModel->getAllOrderedByHierarchy();
        $pageTitle   = 'Team - KCSC';
        $pageDesc    = 'Meet the executive panel and members of the KUET Cyber Security Club.';
        $currentPage = 'team';
        $contentView = APP_ROOT . '/app/Views/pages/team.php';
        require APP_ROOT . '/app/Views/layouts/main.php';
    }
}
