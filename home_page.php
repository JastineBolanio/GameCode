<?php
// Include visitor tracking
require_once 'includes/track_visitor.php';

/**
 * ==========================================================
 * File: home_page.php
 * 
 * Description:
 *   - Main landing page for SkillForge platform
 *   - Features:
 *       • Animated hero section with parallax and floating code icons
 *       • Latest announcements carousel
 *       • Quick access cards for profile, tutorials, games, and more
 *       • Quiz, mini-game, and challenge analytics & leaderboards
 *       • Progress dashboard and recent achievements feed
 *       • Responsive, modern UI with interactive backgrounds
 * 
 * Usage:
 *   - Public page for all users and visitors
 *   - Entry point to all major features and game modes
 * 
 * Files Included:
 *   - assets/css/stylehome.css
 *   - assets/js/functionhome.js
 *   - assets/js/chart.js
 *   - images/background-1.jpg, images/icon-tutorial.png, etc.
 *   - External: Bootstrap, Font Awesome, Anime.js, Typed.js, Rellax, ScrollReveal, Chart.js
 * 
 * ==========================================================
 */

// Include required files
require_once 'includes/Database.php';
require_once 'includes/Auth.php';
require_once 'includes/ErrorHandler.php';
require_once 'includes/CSRFProtection.php';
require_once 'includes/XSSProtection.php';

// Initialize core components
$db = Database::getInstance();
$auth = Auth::getInstance();
$errorHandler = ErrorHandler::getInstance();
$csrf = CSRFProtection::getInstance();
$xss = XSSProtection::getInstance();

// Note: Do NOT redirect admins immediately. We show a welcome modal first
// and redirect to the dashboard after the modal is closed via JS.

// Get database connection
$conn = $db->getConnection();

// Get current user data if logged in
$currentUser = null;
$currentRole = null;

if ($auth->isLoggedIn()) {
    $currentUser = $auth->getCurrentUser();
    $currentRole = $auth->getCurrentRole();
    
    // Debugging: Check if user data was retrieved
    if (!$currentUser) {
        error_log('User is logged in but user data could not be retrieved. User ID: ' . $_SESSION['user_id']);
    } else {
        error_log('User data retrieved successfully. User ID: ' . $currentUser['id']);
    }
}

// Track visitor for analytics (only for non-logged-in users)
if (!$currentUser) {
    try {
        $visitorIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        // Insert visitor log
        $stmt = $conn->prepare('
            INSERT INTO visitor_logs (ip_address, user_agent, visit_time) 
            VALUES (?, ?, NOW())
        ');
        $stmt->execute([$visitorIP, $userAgent]);
    } catch (Exception $e) {
        // Silently fail visitor tracking to not break the page
        error_log('Visitor tracking failed: ' . $e->getMessage());
    }
}

// Set additional styles for header.php
$additionalStyles = '
    <link rel="stylesheet" href="assets/css/stylehome.css">
    <link rel="stylesheet" href="assets/css/home-profile.css">
    <script src="https://cdn.jsdelivr.net/npm/animejs@4.0.0/lib/anime.iife.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/rellax@1.12.1/rellax.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
';

// Set page title for header
$pageTitle = 'Home Page';
// Include header which contains the full HTML structure
include 'includes/header.php';

// Check for the login success flag to show a notification
$showLoginNotification = isset($_GET['login']) && $_GET['login'] === 'success';
if ($showLoginNotification && $currentUser):
?>
     <div class="login-notification-home" id="loginNotificationHome">
        <span>Welcome back, <strong><?php echo htmlspecialchars($currentUser['username']); ?></strong>!</span>
        <button type="button" class="btn-close" id="closeLoginNotificationHome" aria-label="Close"></button>
    <?php endif; ?>
    <!-- ===== Welcome Modal ===== -->
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="<?php echo $csrf->getToken(); ?>">
                <div class="modal-header welcome-modal-header">
                    <div class="welcome-icon-container">
                        <i class="bx bx-magic-wand welcome-icon"></i>
                    </div>
                    <div class="welcome-title-container">
                        <h4 class="modal-title welcome-title" id="welcomeModalLabel">
                            Welcome to Code Game, 
                            <?php 
                            if ($auth->isAdmin()) {
                                echo htmlspecialchars($currentUser['username']) . '!';
                            } elseif ($currentUser) {
                                echo htmlspecialchars($currentUser['username']) . '!';
                            } else {
                                echo 'Guest!';
                            }
                            ?>
                        </h4>
                        <p class="welcome-subtitle">Let's explore your coding adventure!</p>
                    </div>
                    <button type="button" class="btn-close welcome-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body welcome-modal-body">
                    <div class="wizard-container">
                        <div class="wizard-character">
                            <i class="bx bx-code-alt wizard-avatar"></i>
                        </div>
                        <div class="welcome-content">
                            <?php if (!$auth->isAdmin()): ?>
                                <!-- User/Guest Welcome Content -->
                                <p class="welcome-intro">Ready to level up your coding skills? Here's what awaits you:</p>
                                <div class="accordion welcome-accordion" id="userWelcomeAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#homeDesc" aria-expanded="true" data-section="home">
                                                <i class="bx bx-home me-2"></i>Home
                                            </button>
                                        </h2>
                                        <div id="homeDesc" class="accordion-collapse collapse show" data-bs-parent="#userWelcomeAccordion">
                                            <div class="accordion-body">
                                                Your central hub for tracking progress with interactive pie charts, quick access to all game modes, and your personal achievement dashboard.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tutorialDesc" data-section="tutorials">
                                                <i class="bx bx-book-open me-2"></i>Tutorial/Lessons
                                            </button>
                                        </h2>
                                        <div id="tutorialDesc" class="accordion-collapse collapse" data-bs-parent="#userWelcomeAccordion">
                                            <div class="accordion-body">
                                                Step-by-step guides through programming languages like Python, JavaScript, and more. Track your completion progress in your profile.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gameModesDesc" data-section="games">
                                                <i class="bx bx-joystick me-2"></i>Game Modes
                                            </button>
                                        </h2>
                                        <div id="gameModesDesc" class="accordion-collapse collapse" data-bs-parent="#userWelcomeAccordion">
                                            <div class="accordion-body">
                                                <strong>Mini-Game:</strong> Fun coding activities like speed typing and guess-the-output challenges.<br>
                                                <strong>Quiz:</strong> Test your knowledge with multiple-choice questions and earn points.<br>
                                                <strong>Challenge:</strong> Expert-level problems for serious coders seeking high scores and glory!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#announcementsDesc" data-section="announcements">
                                                <i class="bx bx-megaphone me-2"></i>Announcements
                                            </button>
                                        </h2>
                                        <div id="announcementsDesc" class="accordion-collapse collapse" data-bs-parent="#userWelcomeAccordion">
                                            <div class="accordion-body">
                                                Stay updated with the latest platform news, feature releases, and community events. Click on any announcement to read the full details.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profileDesc" data-section="profile">
                                                <i class="bx bx-user me-2"></i>Profile
                                            </button>
                                        </h2>
                                        <div id="profileDesc" class="accordion-collapse collapse" data-bs-parent="#userWelcomeAccordion">
                                            <div class="accordion-body">
                                                <?php if ($currentUser): ?>
                                                    Customize your username, upload a profile picture, write your bio, and view your achievements, scores, and detailed progress tables.
                                                <?php else: ?>
                                                    Sign up to save your progress, unlock achievements, compete on leaderboards, and customize your coding journey!
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer welcome-modal-footer">
                    <div class="footer-left">
                        <div class="wizard-tip">
                            <i class="bx bx-bulb me-2"></i>
                            <span>Tip: You can always access help from the navigation menu!</span>
                        </div>
                        <div class="dont-show-again-container">
                            <label class="form-check-label dont-show-again-label">
                                <input type="checkbox" class="form-check-input me-2" id="dontShowAgainCheck">
                                <i class="bx bx-hide me-1"></i>Don't show this welcome tour again
                            </label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary welcome-btn" data-bs-dismiss="modal">
                        <i class="bx bx-rocket me-2"></i>Let's Start Coding!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Slideshow -->
    <div id="bgSlideshow" class="bg-slideshow">
        <div class="slideshow-overlay"></div>
    </div>

    <!-- ===== Main Content ===== -->
    <main class="pt-5 mt-4">
        <!-- Dynamic Background (particles, etc.) -->
        <div id="dynamicBackground" class="dynamic-bg">
            <canvas id="bgCanvas"></canvas>
            <div class="particles-container"></div>
        </div>

        <!-- Quote Spotlight Section -->
        <section class="quote-spotlight-section position-relative py-5 text-white" role="banner" aria-labelledby="quote-spotlight">
            <div class="container position-relative text-center">
                    <!-- Welcome Message with Typed.js Effect -->
                    <?php if ($auth->isLoggedIn() && isset($currentUser['username'])): ?>
                        <div class="welcome-message mb-4">
                            <h2 class="display-5 fw-bold mb-3">
                                <span id="welcomeTyped" class="glitch-text"></span>
                            </h2>
                            <p class="lead">Continue your coding journey today!</p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="quote-content">
                        <div id="quoteSpotlight" class="quote-spotlight mb-4">
                            <blockquote class="quote-text">
                                <i class="bx bx-code-alt quote-icon"></i>
                                <span id="currentQuote">Loading inspirational quote...</span>
                                <i class="bx bx-code-alt quote-icon"></i>
                            </blockquote>
                            <cite id="quoteAuthor" class="quote-author">— Loading...</cite>
                        </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- User Progress Dashboard (Dynamic for logged-in users) -->
        <?php if ($auth->isLoggedIn()): ?>
            <link rel="stylesheet" href="assets/css/Home_pageV2.css">
        <section class="progress-dashboard gaming-dashboard-container container py-5" role="region" aria-labelledby="progress-heading">
    
    <div class="user-journey-header mb-5 terminal-banner-wrapper">
        <div class="user-banner gaming-cyber-banner" id="userBanner" style="background-image: url('assets/images/default-banner.jpg');">
            <div class="banner-grid-overlay"></div>
        </div>
        
        <div class="user-info terminal-identity-block mt-4">
            <h3 class="username dynamic-username-text" id="userDisplayName">
                WELCOME_BACK_ // <?php echo htmlspecialchars($currentUser['username'] ?? 'OPERATIVE'); ?>
            </h3>
            
            <p class="dynamic-rank-badge" id="userLevel">
                STATUS: <span class="rank-highlight-tint"><?php 
                $level = $currentUser['level'] ?? 1;
                $title = match(true) {
                    $level >= 50 => 'CODING MASTER [MAX_LEVEL]',
                    $level >= 30 => 'SENIOR DEVELOPER',
                    $level >= 20 => 'MID-LEVEL DEVELOPER',
                    $level >= 10 => 'JUNIOR DEVELOPER',
                    default => 'CODING ENTHUSIAST [RANK_01]'
                };
                echo htmlspecialchars($title);
                ?></span>
            </p>
        </div>
    </div>
    
    <div class="journey-title-container mb-4">
        <h4 id="progress-heading" class="gaming-journey-heading">[ MATRIX_OBJECTIVES_MANIFEST ]</h4>
        <div class="heading-laser-line"></div>
    </div>
    
    <div class="row g-4" id="progressContainer">
        <div class="col-12 text-center streaming-loader-slot">
            <div class="spinner-border terminal-spinner-cyan" role="status">
                <span class="visually-hidden">Syncing telemetry data...</span>
            </div>
            <div class="loader-terminal-text mt-2">INITIALIZING DATAFEED SYNC...</div>
        </div>
        
        <noscript>
            <div class="col-12">
                <div class="alert terminal-noscript-alert">
                    <i class="fas fa-triangle-exclamation me-2 text-danger-neon"></i>
                    CRITICAL EXCEPTION: JAVASCRIPT SUBSYSTEM OFFLINE. ENABLE ENGINE TO DECRYPT MANIFEST.
                </div>
            </div>
        </noscript>
    </div>
</section>
        <?php else: ?>
        <!-- Guest Progress Placeholders -->
         <link href="assets/css/GuestV2.css" rel="stylesheet">
        <section class="progress-dashboard container py-5" role="region" aria-labelledby="guest-progress-heading">
    <div class="game-header-wrapper mb-5 text-center">
        <h4 id="guest-progress-heading" class="fw-bold game-title-text text-uppercase">
            <i class="fas fa-terminal me-2 neon-cyan"></i>Initialize Coding Journey
        </h4>
        <div class="hud-divider mx-auto"></div>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-5">
            <div class="gamer-card" id="tutorial-progress-card">
                <div class="hud-corner top-left"></div>
                <div class="hud-corner bottom-right"></div>
                
                <div class="d-flex align-items-start">
                    <div class="gamer-icon-container cyan-glow">
                        <i class="fas fa-book-intellect fa-2x"></i>
                    </div>
                    <div class="progress-details w-100 ms-3">
                        <span class="hud-badge-label">Main Campaign</span>
                        <h5 class="mb-3 text-uppercase font-heading text-white">Quest Progression</h5>
                        
                        <div class="game-progress-wrapper mb-2">
                            <div class="progress custom-hud-bar" style="height: 12px;">
                                <div class="progress-bar bg-cyan progress-bar-striped progress-bar-animated" 
                                     id="tutorial-progress-bar" 
                                     role="progressbar" 
                                     style="width: 45%" aria-valuenow="45" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="progress-percentage fw-bold text-cyan" id="tutorial-progress-percentage">45%</span>
                            <span class="progress-text small text-muted text-uppercase tracking-status" id="tutorial-progress-text">
                                <i class="fas fa-sync-alt fa-spin me-1 text-cyan"></i>
                                <?php echo ($currentUser ? 'Syncing Quest Data...' : 'AUTHENTICATION REQUIRED'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="gamer-card" id="profile-progress-card">
                <div class="hud-corner top-left"></div>
                <div class="hud-corner bottom-right"></div>
                
                <div class="d-flex align-items-start">
                    <div class="gamer-icon-container purple-glow">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                    <div class="progress-details w-100 ms-3">
                        <span class="hud-badge-label purple-badge">User Registry</span>
                        <h5 class="mb-3 text-uppercase font-heading text-white">Player Profile</h5>
                        
                        <div class="game-progress-wrapper mb-2">
                            <div class="progress custom-hud-bar" style="height: 12px;">
                                <div class="progress-bar bg-purple progress-bar-striped progress-bar-animated" 
                                     id="profile-progress-bar" 
                                     role="progressbar" 
                                     style="width: 70%" aria-valuenow="70" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="progress-percentage fw-bold text-purple" id="profile-progress-percentage">70%</span>
                            <span class="progress-text small text-muted text-uppercase tracking-status" id="profile-progress-text">
                                <i class="fas fa-check-circle me-1 text-purple"></i>
                                <?php echo ($currentUser ? 'Profile Optimized' : 'LINK ACCOUNT'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        <?php endif; ?>

        <!-- ===== Dynamic Announcements Section ===== -->
        <section id="announcements" class="container py-5" role="region" aria-labelledby="announcements-heading">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 id="announcements-heading" class="fw-bold mb-0">Latest Updates</h4>
                <a href="announcements.php" class="btn btn-outline-primary btn-sm">
                    <i class="bx bx-list-ul me-2"></i>View All
                </a>
            </div>
            <div id="announcementsContainer">
                <!-- Announcements will be loaded via AJAX for real-time updates -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading announcements...</span>
                    </div>
                </div>
            </div>
        </section>


        <!-- ===== Quick Access Cards ===== -->
         <link href="assets/css/QuickCardV2.css" rel="stylesheet">
        <section class="quick-cards container py-5" aria-label="Quick Access Navigation">
    <div class="row g-4 justify-content-center">
        <?php
        // Initialize structural fallbacks
        $userProgress = [
            'tutorial' => ['total_topics' => 0, 'completed_topics' => 0],
            'quiz' => ['total_attempts' => 0, 'correct_answers' => 0],
            'challenge' => ['total_attempts' => 0, 'correct_answers' => 0],
            'minigame' => ['total_games' => 0, 'best_score' => 0]
        ];
        
        if ($currentUser) {
            try {
                // Get tutorial progress
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total_topics, 
                        SUM(CASE WHEN status = 'done_reading' THEN 1 ELSE 0 END) as completed_topics
                    FROM user_progress 
                    WHERE user_id = ?
                ");
                $stmt->execute([$currentUser['id']]);
                $tutorialProgress = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Get quiz stats
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total_attempts,
                        SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_answers
                    FROM user_quiz_attempts 
                    WHERE user_id = ?
                ");
                $stmt->execute([$currentUser['id']]);
                $quizProgress = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Get challenge stats
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total_attempts,
                        SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_answers
                    FROM user_challenge_attempts 
                    WHERE user_id = ?
                ");
                $stmt->execute([$currentUser['id']]);
                $challengeProgress = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Get mini-game stats
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total_games,
                        MAX(score) as best_score
                    FROM mini_game_results 
                    WHERE user_id = ?
                ");
                $stmt->execute([$currentUser['id']]);
                $minigameProgress = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $userProgress = [
                    'tutorial' => $tutorialProgress ?: ['total_topics' => 0, 'completed_topics' => 0],
                    'quiz' => $quizProgress ?: ['total_attempts' => 0, 'correct_answers' => 0],
                    'challenge' => $challengeProgress ?: ['total_attempts' => 0, 'correct_answers' => 0],
                    'minigame' => $minigameProgress ?: ['total_games' => 0, 'best_score' => 0]
                ];
            } catch (Exception $e) {
                // Graceful fallback string map parameters
            }
        }
        
        // Gamified Array Engine Mapping
        $quickCards = [
            [
                'title' => 'Profile',
                'icon' => 'fa-user-shield',
                'image' => 'assets/images/Profile.png',
                'theme' => 'theme-cyan',
                'progress' => $currentUser ? 'LVL ' . min(floor((($userProgress['challenge']['correct_answers'] ?? 0) * 30) / 100) + 1, 50) : 'GUEST_ID',
                'text' => $currentUser ? 'Manage your operative account' : 'Sync data matrix to save progress',
                'link' => $currentUser ? 'profile.php' : 'sign_in.php'
            ],
            [
                'title' => 'Tutorials',
                'icon' => 'fa-terminal',
                'image' => 'assets/images/Tutorial.png',
                'theme' => 'theme-cyan',
                'progress' => 'ARCHIVE: ' . ($userProgress['tutorial']['completed_topics'] ?? 0) . ' / ' . max($userProgress['tutorial']['total_topics'] ?? 1, 1),
                'text' => ($userProgress['tutorial']['completed_topics'] ?? 0) > 0 ? 'Load next data sector' : 'Initialize system core training',
                'link' => 'tutorial.php'
            ],
            [
                'title' => 'Mini-Game',
                'icon' => 'fa-gamepad',
                'image' => 'assets/images/icon-mini-game.png',
                'theme' => 'theme-purple',
                'progress' => ($userProgress['minigame']['total_games'] ?? 0) . ' Runs Logged',
                'text' => ($userProgress['minigame']['best_score'] ?? 0) > 0 ? 'RECORD: ' . ($userProgress['minigame']['best_score'] ?? 0) : 'Sector arcade challenge waiting',
                'link' => 'mini-game.php'
            ],
            [
                'title' => 'Quiz',
                'icon' => 'fa-crosshairs',
                'image' => 'assets/images/icon-quiz.png',
                'theme' => 'theme-purple',
                'progress' => 'NODES: ' . ($userProgress['quiz']['correct_answers'] ?? 0) . ' / 40 COMPILED',
                'text' => ($userProgress['quiz']['correct_answers'] ?? 0) > 0 ? 'Optimize node runtime output' : 'Scan live terminal knowledge',
                'link' => 'quiz.php'
            ],
            [
                'title' => 'Challenge',
                'icon' => 'fa-trophy',
                'image' => 'assets/images/icon-challenge.png',
                'theme' => 'theme-amber',
                'progress' => ($userProgress['challenge']['correct_answers'] ?? 0) . ' Cleared',
                'text' => ($userProgress['challenge']['correct_answers'] ?? 0) > 0 ? 'EXPERT COMPILER UNLOCKED' : 'Overclock scripts on elite tasks',
                'link' => 'challenges.php'
            ],
            [
                'title' => 'About',
                'icon' => 'fa-info-circle',
                'image' => 'assets/images/about-us.png',
                'theme' => 'theme-cyan',
                'progress' => 'SYS_VER_3.2.6',
                'text' => 'Access system architecture logs',
                'link' => 'about.php'
            ]
        ];

        foreach ($quickCards as $card): 
            $title = htmlspecialchars($card['title']);
            $image = file_exists($card['image']) ? $card['image'] : 'images/default-card.png';
            $progress = isset($card['progress']) ? htmlspecialchars($card['progress']) : '';
            $text = isset($card['text']) ? htmlspecialchars($card['text']) : '';
            $link = htmlspecialchars($card['link']);
            $icon = htmlspecialchars($card['icon']);
            $themeClass = $card['theme'];
        ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                <a href="<?php echo $link; ?>" class="game-card-anchor text-decoration-none d-block h-100" aria-label="Launch <?php echo $title; ?>">
                    <div class="card game-style-card <?php echo $themeClass; ?>" role="article">
                        
                        <div class="hud-corner corner-tl"></div>
                        <div class="hud-corner corner-br"></div>
                        
                        <div class="game-card-img-wrapper">
                            <img src="<?php echo $image; ?>" 
                                class="card-img-top" 
                                alt="<?php echo $title; ?>"
                                onerror="this.src='images/default-card.png'">
                            <div class="hud-laser-scanline"></div>
                        </div>

                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="card-title text-uppercase">
                                    <i class="fas <?php echo $icon; ?> me-2 game-icon-pulse" aria-hidden="true"></i>
                                    <?php echo $title; ?>
                                </h6>
                                
                                <?php if ($progress): ?>
                                    <div class="game-stat-strip text-uppercase">
                                        <?php echo $progress; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($text): ?>
                                    <p class="game-meta-text"><?php echo $text; ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="btn btn-game-action text-uppercase btn-sm w-100 mt-2">
                                Launch
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

        <!-- ===== Quiz Analytics & Leaderboard Section ===== -->
         <link href="assets/css/QuizAnalyticsV2.css" rel="stylesheet">
        <section class="container py-5" id="home-quiz-analytics" role="region" aria-labelledby="quiz-analytics-heading">
    <div class="hud-analytics-terminal-bg">
        
        <div class="hud-stat-panel diagnostic-best" role="img" aria-label="Best quiz score">
            <div class="hud-panel-edge-line"></div>
            <div class="hud-panel-header">BEST_SCORE <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
            <div class="hud-panel-value" id="quiz-best-score" aria-live="polite">--</div>
            <div class="hud-panel-desc">All-time maximum threshold</div>
        </div>
        
        <div class="hud-stat-panel diagnostic-recent" role="img" aria-label="Recent quiz game">
            <div class="hud-panel-edge-line"></div>
            <div class="hud-panel-header">RECENT_LOG <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
            <div class="hud-panel-value" id="quiz-recent-score" aria-live="polite">--</div>
            <div class="hud-panel-desc" id="quiz-recent-time">No active session data</div>
        </div>
        
        <div class="hud-stat-panel diagnostic-top" role="img" aria-label="Top quiz player">
            <div class="hud-panel-edge-line"></div>
            <div class="hud-panel-header">TOP_OPERATIVE <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
            <div class="hud-panel-value" id="quiz-top-player" aria-live="polite">--</div>
            <div class="hud-panel-desc" id="quiz-top-player-desc">No network leader found</div>
        </div>
        
        <div class="hud-main-terminal-window">
            
            <div class="hud-terminal-title-bar d-flex justify-content-between align-items-center">
                <div class="hud-terminal-glitch-text" id="quiz-analytics-heading">
                    <span class="hud-terminal-prefix">⚡</span> MODULE: SECURE_QUIZ_ANALYTICS_MATRIX
                </div>
                <div class="hud-terminal-deco-lines" aria-hidden="true">
                    <span></span><span></span><span></span>
                </div>
            </div>
            
            <div class="hud-terminal-content">
                <div class="analytics-header">
                    <div class="analytics-tabs hud-terminal-tabs" role="tablist" aria-label="Quiz analytics time period">
                        <button class="analytics-tab active" data-scope="alltime" role="tab" aria-selected="true" aria-controls="quiz-content">ALL-TIME LOGS</button>
                        <button class="analytics-tab" data-scope="weekly" role="tab" aria-selected="false" aria-controls="quiz-content">WEEKLY RESET</button>
                        <button class="analytics-tab" data-scope="monthly" role="tab" aria-selected="false" aria-controls="quiz-content">MONTHLY BATCH</button>
                    </div>
                </div>
                
                <div class="analytics-body" id="quiz-content" role="tabpanel">
                    
                    <div class="difficulty-tabs hud-sub-tabs" role="tablist" aria-label="Quiz difficulty level">
                        <button class="difficulty-tab active" data-difficulty="beginner" role="tab" aria-selected="true" aria-controls="quiz-difficulty-content">RANK_01: BEGINNER</button>
                        <button class="difficulty-tab" data-difficulty="intermediate" role="tab" aria-selected="false" aria-controls="quiz-difficulty-content">RANK_02: INTERMEDIATE</button>
                        <button class="difficulty-tab" data-difficulty="expert" role="tab" aria-selected="false" aria-controls="quiz-difficulty-content">RANK_03: EXPERT_LEVEL</button>
                    </div>
                    
                    <div class="user-quiz-stats hud-terminal-data-feed" aria-live="polite"></div>
                    <div class="quiz-leaderboard-list hud-terminal-leader-matrix" aria-live="polite"></div>
                    
                    <div class="play-now-section text-center pt-3">
                        <button class="btn-play-now btn-hud-terminal-action" onclick="window.location.href='quiz.php'" aria-describedby="quiz-play-description">
                            <span class="btn-text">INITIALIZE RUN</span>
                        </button>
                        <div id="quiz-play-description" class="visually-hidden">
                            Start a new quiz to test your coding knowledge and compete on the leaderboard
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

        <!-- ===== Mini-Game Leaderboard Section ===== -->
         <link href="assets/css/MiniGameV2.css" rel="stylesheet">
        <div class="hud-game-matrix-container" style="margin-top: 2.5rem;">
    <section class="container py-5" id="home-minigame-analytics" role="region" aria-labelledby="minigame-analytics-heading">
        <div class="hud-analytics-terminal-bg minigame-theme">
            
            <div class="hud-stat-panel diagnostic-mg-best" role="img" aria-label="Best minigame score">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">HIGH_SCORE <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="minigame-best-score" aria-live="polite">--</div>
                <div class="hud-panel-desc">Personal record threshold</div>
            </div>
            
            <div class="hud-stat-panel diagnostic-mg-recent" role="img" aria-label="Recent minigame session">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">LAST_RUN <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="minigame-recent-score" aria-live="polite">--</div>
                <div class="hud-panel-desc" id="minigame-recent-time">No active session logs</div>
            </div>
            
            <div class="hud-stat-panel diagnostic-mg-top" role="img" aria-label="Top player score">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">RANK_01_LEADER <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="minigame-top-player" aria-live="polite">--</div>
                <div class="hud-panel-desc" id="minigame-top-player-desc">Global lobby leader</div>
            </div>
            
            <div class="hud-main-terminal-window minigame-theme">
                
                <div class="hud-terminal-title-bar d-flex justify-content-between align-items-center">
                    <div class="hud-terminal-glitch-text" id="minigame-analytics-heading">
                        <span class="hud-terminal-prefix">🎮</span> MODULE: MINI_GAME_LEADERBOARD_MATRIX
                    </div>
                    <div class="hud-terminal-controls d-flex align-items-center gap-3">
                        <button class="window-refresh-btn" title="Re-sync data feed" aria-label="Refresh stats">⟳</button>
                        <div class="hud-terminal-deco-lines" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
                
                <div class="hud-terminal-content">
                    <div class="analytics-header">
                        <div class="analytics-tabs hud-terminal-tabs" role="tablist" aria-label="Mini-game analytics time period">
                            <button class="analytics-tab active" data-scope="alltime" role="tab" aria-selected="true" aria-controls="minigame-content">ALL-TIME DATA</button>
                            <button class="analytics-tab" data-scope="weekly" role="tab" aria-selected="false" aria-controls="minigame-content">WEEKLY RESET</button>
                            <button class="analytics-tab" data-scope="monthly" role="tab" aria-selected="false" aria-controls="minigame-content">MONTHLY BATCH</button>
                        </div>
                    </div>
                    
                    <div class="analytics-body" id="minigame-content" role="tabpanel">
                        <div class="user-quiz-stats hud-terminal-data-feed"></div>
                        <div class="quiz-leaderboard-list hud-terminal-leader-matrix"></div>
                        
                        <div class="play-now-section text-center pt-3">
                            <button class="btn-play-now btn-hud-terminal-action minigame-theme" onclick="window.location.href='mini-game.php'">
                                <span class="btn-text">START ARCADE RUN</span>
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>  

        <!-- ===== Challenge Leaderboard Section ===== -->
         <link href="assets/css/ChallengeLBV2.css" rel="stylesheet">    
        <div class="hud-game-matrix-container" style="margin-top: 2.5rem;">
    <section class="container py-5" id="home-challenge-analytics" role="region" aria-labelledby="challenge-analytics-heading">
        <div class="hud-analytics-terminal-bg challenge-theme">
            
            <div class="hud-stat-panel diagnostic-ch-best" role="img" aria-label="Best challenge score">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">ELITE_RECORD <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="challenge-best-score" aria-live="polite">--</div>
                <div class="hud-panel-desc">All-time peak capacity</div>
            </div>
            
            <div class="hud-stat-panel diagnostic-ch-recent" role="img" aria-label="Recent challenge trial">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">LAST_TRIAL <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="challenge-recent-score" aria-live="polite">--</div>
                <div class="hud-panel-desc" id="challenge-recent-time">No recent terminal link</div>
            </div>
            
            <div class="hud-stat-panel diagnostic-ch-top" role="img" aria-label="Top challenger player">
                <div class="hud-panel-edge-line"></div>
                <div class="hud-panel-header">APEX_OPERATIVE <span class="hud-panel-status-dot" aria-hidden="true"></span></div>
                <div class="hud-panel-value" id="challenge-top-player" aria-live="polite">--</div>
                <div class="hud-panel-desc" id="challenge-top-player-desc">Lobby champion matrix</div>
            </div>
            
            <div class="hud-main-terminal-window challenge-theme">
                
                <div class="hud-terminal-title-bar d-flex justify-content-between align-items-center">
                    <div class="hud-terminal-glitch-text" id="challenge-analytics-heading">
                        <span class="hud-terminal-prefix">🚀</span> CRITICAL: CHALLENGE_LEADERBOARD // EXPERT_ONLY
                    </div>
                    <div class="hud-terminal-controls d-flex align-items-center gap-3">
                        <button class="window-refresh-btn" title="Re-sync lobby logs" aria-label="Refresh stats">⟳</button>
                        <div class="hud-terminal-deco-lines" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
                
                <div class="hud-terminal-content">
                    <div class="analytics-header">
                        <div class="analytics-tabs hud-terminal-tabs" role="tablist" aria-label="Challenge analytics window frame">
                            <button class="analytics-tab active" data-scope="alltime" role="tab" aria-selected="true" aria-controls="challenge-content">ALL-TIME INDEX</button>
                            <button class="analytics-tab" data-scope="weekly" role="tab" aria-selected="false" aria-controls="challenge-content">WEEKLY RANK</button>
                            <button class="analytics-tab" data-scope="monthly" role="tab" aria-selected="false" aria-controls="challenge-content">MONTHLY PHASE</button>
                        </div>
                    </div>
                    
                    <div class="analytics-body" id="challenge-content" role="tabpanel">
                        <div class="user-quiz-stats hud-terminal-data-feed"></div>
                        <div class="quiz-leaderboard-list hud-terminal-leader-matrix"></div>
                        
                        <div class="play-now-section text-center pt-3">
                            <button class="btn-play-now btn-hud-terminal-action challenge-theme" onclick="window.location.href='challenges.php'">
                                <span class="btn-text">ENGAGE OVERCLOCK OVERRIDE</span>
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>
    </main>

    <!-- ===== Footer ===== -->
    <?php include 'includes/footer.php'; ?>

    <!-- ===== Custom Scripts ===== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- Home Page Specific Scripts -->
    <script>
        // Global variables for JavaScript
        window.CG_USER_ID = <?php echo $currentUser ? $currentUser['id'] : 'null'; ?>;
        window.CG_USERNAME = <?php echo $currentUser ? json_encode($currentUser['username']) : 'null'; ?>;
        window.CG_NICKNAME = <?php echo isset($_SESSION['guest_nickname']) ? json_encode($_SESSION['guest_nickname']) : 'null'; ?>;
        window.CG_USER_ROLE = <?php echo $currentRole ? json_encode($currentRole) : 'null'; ?>;
        window.CG_IS_ADMIN = <?php echo $auth->isAdmin() ? 'true' : 'false'; ?>;
        window.CSRF_TOKEN = <?php echo json_encode($csrf->getToken()); ?>;
    </script>
    <!-- Home Page JavaScript Files -->
    <script>
        // Make sure APIHelper is only loaded once
        if (typeof window.APIHelper === 'undefined') {
            document.write('<script src="assets/js/api-helper.js"><\/script>');
        }
    </script>
    <script src="assets/js/functionhome.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/welcome-modal.js"></script>
    <script src="assets/js/home-enhancements.js"></script>
    <script>
        
        // Function to update quick cards with progress
        function updateQuickCardsProgress(progress) {
            const tutorialCard = document.querySelector('.quick-card[data-card-type="tutorial"]');
            if (tutorialCard) {
                const progressEl = tutorialCard.querySelector('.card-progress');
                if (progressEl) {
                    progressEl.textContent = `${progress.completed_topics} of ${progress.total_topics}`;
                }
                const textEl = tutorialCard.querySelector('.card-text');
                if (textEl) {
                    textEl.textContent = progress.completed_topics > 0 ? 'Keep learning!' : 'Start your journey';
                }
            }
        }
        
        // Global error display function
        window.showGlobalError = function(message) {
            console.error('Global error:', message);
            
            // Try to find an existing error container or create one
            let errorContainer = document.getElementById('globalErrorContainer');
            
            if (!errorContainer) {
                errorContainer = document.createElement('div');
                errorContainer.id = 'globalErrorContainer';
                errorContainer.className = 'container mt-3';
                
                // Insert at the beginning of the main content
                const mainContent = document.querySelector('main') || document.body;
                if (mainContent.firstChild) {
                    mainContent.insertBefore(errorContainer, mainContent.firstChild);
                } else {
                    mainContent.appendChild(errorContainer);
                }
            }
            
            // Set the error message
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        };

        // Set up global variables for the page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded');
            
            // Set user data
            window.CG_USER_ID = '<?php echo $currentUser ? $currentUser['id'] : ''; ?>';
            
            window.CG_IS_LOGGED_IN = <?php echo $auth->isLoggedIn() ? 'true' : 'false'; ?>;
            
            console.log('User ID:', window.CG_USER_ID, 'Is Logged In:', window.CG_IS_LOGGED_IN);
            
            // Initialize components
            try {
                // Initialize all components if the function exists
                if (window.initializeAll && typeof window.initializeAll === 'function') {
                    console.log('Initializing all components...');
                    window.initializeAll();
                } else {
                    console.warn('initializeAll function not found');
                    showGlobalError('Some page features may not work correctly. Please refresh the page.');
                }
                
                // Load user progress if function exists and user is logged in
                if (window.CG_IS_LOGGED_IN) {
                    if (window.loadUserProgress && typeof window.loadUserProgress === 'function') {
                        console.log('Loading user progress...');
                        window.loadUserProgress().catch(error => {
                            console.error('Error in loadUserProgress:', error);
                            showGlobalError('Failed to load progress data. ' + (error.message || ''));
                        });
                    } else {
                        console.warn('loadUserProgress function not found');
                        const progressContainer = document.getElementById('progressContainer');
                        if (progressContainer) {
                            progressContainer.innerHTML = `
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <i class="bx bx-error-circle me-2"></i>
                                        Unable to load progress. Please refresh the page.
                                    </div>
                                </div>`;
                        }
                    }
                } else {
                    console.log('User not logged in, showing guest message');
                    const progressContainer = document.getElementById('progressContainer');
                    if (progressContainer) {
                        progressContainer.innerHTML = `
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bx bx-log-in-circle me-2"></i>
                                    Please <a href="login.php" class="alert-link">log in</a> to track your coding journey
                                </div>
                            </div>`;
                    }
                }
                
                // Load announcements if function exists
                if (window.loadAnnouncements && typeof window.loadAnnouncements === 'function') {
                    console.log('Loading announcements...');
                    window.loadAnnouncements().catch(error => {
                        console.error('Error in loadAnnouncements:', error);
                        const announcementsContainer = document.getElementById('announcementsContainer');
                        if (announcementsContainer) {
                            announcementsContainer.innerHTML = `
                                <div class="alert alert-warning">
                                    <i class="bx bx-error-circle me-2"></i>
                                    Failed to load announcements. Please refresh the page.
                                </div>`;
                        }
                    });
                } else {
                    console.warn('loadAnnouncements function not found');
                    const announcementsContainer = document.getElementById('announcementsContainer');
                    if (announcementsContainer) {
                        announcementsContainer.innerHTML = `
                            <div class="alert alert-warning">
                                <i class="bx bx-error-circle me-2"></i>
                                Unable to load announcements. Please refresh the page.
                            </div>`;
                    }
                }
                
                // Close login notification if exists
                const closeNotificationBtn = document.getElementById('closeLoginNotificationHome');
                if (closeNotificationBtn) {
                    closeNotificationBtn.addEventListener('click', function() {
                        const notification = document.getElementById('loginNotificationHome');
                        if (notification) {
                            notification.style.display = 'none';
                        }
                    });
                }
            } catch (error) {
                console.error('Error during initialization:', error);
                showGlobalError('An error occurred while initializing the page. ' + (error.message || ''));
            }
        });
    </script>
    <script>
        // Global error display function
        function showGlobalError(message) {
            console.error('Global error:', message);
            
            // Try to find an existing error container or create one
            let errorContainer = document.getElementById('globalErrorContainer');
            
            if (!errorContainer) {
                errorContainer = document.createElement('div');
                errorContainer.id = 'globalErrorContainer';
                errorContainer.className = 'container mt-3';
                
                // Insert at the beginning of the main content
                const mainContent = document.querySelector('main') || document.body;
                if (mainContent.firstChild) {
                    mainContent.insertBefore(errorContainer, mainContent.firstChild);
                } else {
                    mainContent.appendChild(errorContainer);
                }
            }
            
            // Set the error message
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        }
    </script>
    <?php
    // Helper function for announcement icons
    function getAnnouncementIcon($type) {
        $icons = [
            'update' => 'fa-star',
            'maintenance' => 'fa-tools',
            'tutorial' => 'fa-book',
            'default' => 'fa-bullhorn'
        ];
        return $icons[$type] ?? $icons['default'];
    }
    ?>
