<?php
/**
 * ==========================================================
 * File: announcements.php
 * 
 * Description:
 *   - Announcements page for SkillForge platform
 *   - Features:
 *       • Displays all active announcements (latest and pinned first)
 *       • Shows author, date, and announcement details
 *       • Pagination for large announcement lists
 *       • Responsive, themed UI
 * 
 * Usage:
 *   - Public page for all users and visitors
 *   - Keeps users updated on news, features, and events
 * 
 * Files Included:
 *   - assets/css/announcements.css
 *   - assets/js/announcements.js
 *   - includes/header.php, includes/footer.php
 * -
 * ==========================================================
 */

require_once 'includes/Database.php';
require_once 'includes/Auth.php';

$db = Database::getInstance();
$auth = Auth::getInstance();

// Fetch all active announcements, most recent first
$conn = $db->getConnection();
$stmt = $conn->prepare('SELECT a.*, au.username as author FROM announcements a LEFT JOIN admin_users au ON a.created_by = au.admin_id WHERE a.is_active = 1 ORDER BY a.created_at DESC');
$stmt->execute();
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set page title for the header
$pageTitle = "Announcements";
?>

<?php include 'includes/header.php'; ?>

<body class="announcements-theme">
  <main class="hud-game-matrix-container py-5">
    <div class="container">
      <div class="hud-analytics-terminal-bg announcements-window-wrapper">
        
        <div class="hud-main-terminal-window announcements-primary-window">
          
          <div class="hud-terminal-title-bar d-flex justify-content-between align-items-center">
            <div class="hud-terminal-glitch-text" id="announcements-heading">
              <span class="hud-terminal-prefix">📡</span> LIVE_FEED: SYSTEM_BROADCAST_PROTOCOLS
            </div>
            <div class="hud-terminal-deco-lines" aria-hidden="true">
              <span></span><span></span><span></span>
            </div>
          </div>
          
          <div class="hud-terminal-content">
            <h1 class="hud-terminal-main-title text-center text-uppercase mb-4">
              Latest System Announcements
            </h1>
            
            <ul class="announcement-list hud-terminal-feed-list p-0" id="announcementList" role="log" aria-live="polite">
              </ul>
            
            <div class="announcements-pagination hud-terminal-pagination-matrix d-flex justify-content-center gap-2 pt-3" id="announcementsPagination">
              </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </main>

  <?php include 'includes/footer.php'; ?>
  <link rel="stylesheet" href="assets/css/announcements.css">
  <link rel="stylesheet" href="assets/css/AnnouncementV2.css">
  <script src="assets/js/announcements.js"></script>
</body>