<?php
/**
 * ==========================================================
 * File: admin_announcements.php
 * 
 * Description:
 *   - Admin Announcements management page for SkillForge platform
 *   - Features:
 *       • Add, edit, filter, and search announcements
 *       • Category and status filters (system, event, update; published, draft)
 *       • Announcement cards list and pagination
 *       • Sidebar with recent, stats, and pinned/featured announcements
 *       • Modal for add/edit, pin limit, and back-to-top button
 *       • Responsive, modern UI with Bootstrap and custom styles
 * 
 * Usage:
 *   - Accessible only to logged-in admins
 *   - Used to manage platform announcements and featured posts
 * 
 * Files Included:
 *   - assets/css/admin_dashboard.css
 *   - assets/css/admin_announcements.css
 *   - assets/js/admin_global.js
 *   - assets/js/admin_announcements.js
 *   - includes/admin_header.php, includes/admin_footer.php
 * ==========================================================
 */
require_once 'includes/Auth.php';
$auth = Auth::getInstance();
if (!$auth->isAdmin()) {
    header('Location: home_page.php');
    exit;
}
$currentUser = $auth->getCurrentUser();
$pageTitle = 'Admin Announcements';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="assets/css/admin_announcements.css">
</head>
<body class="admin-theme">
<?php include 'includes/admin_header.php'; ?>
<main class="admin-announcements-main container-fluid py-4">
    <div class="row g-4">
        <!-- Main Content -->
         <link rel="stylesheet" href="assets/css/AnnounceMantContent.css">
        <div class="col-lg-8 gaming-hub-container">
  
  <!-- HUB HEADER SECTION -->
  <div class="d-flex justify-content-between align-items-center mb-4 panel-header-block">
    <h1 class="terminal-hub-title-forced">
    <span class="pulse-node-forced"></span> 
    <span class="title-text-forced">BROADCAST LOGS</span>
  </h1>
    <button class="btn btn-gaming-lg" id="addAnnouncementBtn">
      <i class="fas fa-tower-broadcast"></i> INJECT NEW LOG
    </button>
  </div>
  
  <!-- TELEMETRY FILTERS / SEARCH TOOLBAR -->
  <div class="d-flex flex-wrap gap-2 mb-4 align-items-center terminal-filter-bar">
    
    <!-- Retro Styled Search Field -->
    <div class="search-input-wrapper">
      <i class="fas fa-magnifying-glass search-icon-accent"></i>
      <input type="text" class="form-control gaming-input" id="announcementSearch" placeholder="Query transmission keyword...">
    </div>
    
    <!-- State Dropdown Filter -->
    <div class="select-input-wrapper">
      <select class="form-select gaming-select" id="announcementStatusFilter">
        <option value="">[ ALL EMISSION STATES ]</option>
        <option value="published">LIVE SIGNAL (PUBLISHED)</option>
        <option value="draft">STAGED ENCRYPT (DRAFT)</option>
      </select>
    </div>
    
    <!-- Category Dropdown Filter -->
    <div class="select-input-wrapper">
      <select class="form-select gaming-select" id="announcementCategoryFilter">
        <option value="">[ ALL CATEGORIES ]</option>
        <option value="system">CORE SYSTEM</option>
        <option value="event">GLOBAL RAID / EVENT</option>
        <option value="update">PATCH INJECTION</option>
      </select>
    </div>
    
  </div>
  
  <!-- DYNAMIC RENDER TARGETS -->
  <!-- Announcement Cards List Target -->
  <div id="announcementCardsList" class="gaming-card-deck"></div>
  
  <!-- Pagination Target Container -->
  <nav id="announcementPagination" class="mt-4 gaming-nav-pagination"></nav>
  
</div>
        <!-- Sidebar -->
        <div class="col-lg-4">
  <div class="magazine-sidebar gaming-sidebar-console">
    
    <div class="sidebar-section mb-4 terminal-section border-sub-purple">
      <h5 class="sidebar-title gaming-sidebar-header">
        <i class="fas fa-rss icon-purple"></i> SUB-SIGNALS
      </h5>
      <ul class="list-group gaming-terminal-list" id="recentAnnouncementsList"></ul>
    </div>
    
    <div class="sidebar-section mb-4 terminal-section border-sub-matrix">
      <h5 class="sidebar-title gaming-sidebar-header">
        <i class="fas fa-chart-simple icon-matrix"></i> MATRIX TELEMETRY
      </h5>
      <div id="announcementStats" class="dynamic-visibility-wrapper"></div>
    </div>
    
    <div class="sidebar-section mb-4 terminal-section border-sub-amber">
      <h5 class="sidebar-title gaming-sidebar-header">
        <i class="fas fa-thumbtack icon-amber"></i> PRIORITY NODE
      </h5>
      <div id="featuredAnnouncement" class="dynamic-visibility-wrapper"></div>
    </div>
    
    <div class="sidebar-section">
      <button class="btn btn-gaming-share w-100" id="shareOnTwitterBtn">
        <i class="fab fa-x-twitter"></i> RELAY TO NET (X)
      </button>
    </div>
    
  </div>
</div>
    </div>
    <!-- Add/Edit Announcement Modal (hidden by default) -->
    <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="announcementModalLabel">Add/Edit Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="announcementForm">
                        <input type="hidden" id="announcementId">
                        <div class="mb-3">
                            <label for="announcementTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="announcementTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="announcementContent" class="form-label">Content</label>
                            <textarea class="form-control" id="announcementContent" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="announcementCategory" class="form-label">Category</label>
                            <select class="form-select" id="announcementCategory">
                                <option value="system">System</option>
                                <option value="event">Event</option>
                                <option value="update">Update</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="announcementStatus" class="form-label">Status</label>
                            <select class="form-select" id="announcementStatus">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Max Pins Modal -->
    <div class="modal fade" id="maxPinsModal" tabindex="-1" aria-labelledby="maxPinsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maxPinsModalLabel"><i class="fas fa-thumbtack text-warning me-2"></i>Pin Limit Reached</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You can only have <b>3 pinned announcements</b> at a time.<br>Unpin another announcement before pinning a new one.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Back to Top Button -->
    <button id="backToTopBtn" class="btn btn-dark rounded-circle" style="position:fixed;bottom:32px;right:32px;display:none;z-index:9999;"><i class="fas fa-arrow-up"></i></button>
</main>
<?php include 'includes/admin_footer.php'; ?>
<script src="assets/js/admin_global.js"></script>
<script src="assets/js/admin_announcements.js"></script>
</body>
</html> 
