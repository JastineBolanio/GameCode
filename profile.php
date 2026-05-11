<?php
/**
 * ==========================================================
 * File: profile.php
 * 
 * Description:
 *   - User Profile page for Code Gaming platform
 *   - Features:
 *       • View and edit user profile details (username, email, avatar)
 *       • Upload and validate profile picture (JPG, PNG, GIF, max 2MB)
 *       • Display player stats (points, rank, challenges, quizzes)
 *       • Show recent activity and achievements
 *       • Modern, responsive UI with geometric design elements
 * 
 * Author: [Your Name]
 * Last Updated: [Current Date]
 * -- Code Gaming Team --
 * ==========================================================
 */

// At the top of the file, after including all necessary files


 // Start output buffering
ob_start();

// Debug logging
error_log("=== Starting request ===");
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

// Make sure the uploads directory exists and is writable
$uploadDir = __DIR__ . '/uploads/banners/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        error_log("Failed to create upload directory: " . $uploadDir);
        die(json_encode(['success' => false, 'message' => 'Failed to create upload directory']));
    }
}

if (!is_writable($uploadDir)) {
    error_log("Upload directory is not writable: " . $uploadDir);
    die(json_encode(['success' => false, 'message' => 'Upload directory is not writable']));
}

// Make sure no output is sent before headers
if (headers_sent($filename, $linenum)) {
    file_put_contents(__DIR__ . '/debug.log', "Headers already sent in $filename on line $linenum\n", FILE_APPEND);
    exit('Headers already sent');
}
 
 // Then your existing code...
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 ini_set('log_errors', 1);
 ini_set('error_log', __DIR__ . '/php_errors.log');



// Include required files
// At the top of profile.php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/CSRFProtection.php';
require_once __DIR__ . '/includes/Auth.php';
require_once __DIR__ . '/includes/XSSProtection.php';

// Initialize core components
$db = Database::getInstance();
$auth = Auth::getInstance();
$csrf = CSRFProtection::getInstance();
$xss = XSSProtection::getInstance();

if (!$auth->isLoggedIn() || $auth->isAdmin()) {
    header('Location: login.php');
    exit;
}

$currentUser = $auth->getCurrentUser();
if (!$currentUser) {
    header('Location: login.php');
    exit;
}
$userId = $currentUser['id'];

// Initialize message variable
$message = '';

$pageTitle = "My Profile";
$additionalStyles = '
    <link rel="stylesheet" href="assets/css/profile-new.css">
    ';
    include 'includes/header.php';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Clear any output buffers
    while (ob_get_level()) ob_end_clean();
    
    header('Content-Type: application/json');
    
    try {
        // Get and sanitize input
        $username = $xss->sanitizeText($_POST['username'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $location = $xss->sanitizeText($_POST['location'] ?? '');
        $bio = $xss->sanitizeText($_POST['bio'] ?? '');
        
        // Basic validation
        if (empty($username) || empty($email)) {
            throw new Exception('Username and email are required');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address');
        }
        
        // Check if username or email is already taken by another user
        $stmt = $db->prepare('SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?');
        $stmt->execute([$username, $email, $currentUser['id']]);
        if ($stmt->fetch()) {
            throw new Exception('Username or email is already in use');
        }
        
        // Handle profile picture upload if a new one was provided
        $profilePicture = $currentUser['profile_picture'] ?? '';
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/avatars/";
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception('Failed to create upload directory');
                }
            }
            
            $originalName = basename($_FILES['profile_picture']['name']);
            $fileName = uniqid('', true) . '-' . $originalName;
            $targetFile = $targetDir . $fileName;
            
            // Validate file type
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                throw new Exception('Only JPG, JPEG, PNG & GIF files are allowed');
            }
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                // Delete old profile picture if it exists and is not the default
                $oldPicture = $currentUser['profile_picture'] ?? '';
                if (!empty($oldPicture) && $oldPicture !== 'assets/images/default-avatar.gif' && file_exists($oldPicture)) {
                    @unlink($oldPicture);
                }
                $profilePicture = $targetFile;
            } else {
                throw new Exception('Failed to upload profile picture');
            }
        }
        
        // Update database
        $stmt = $db->prepare('UPDATE users SET username = ?, email = ?, location = ?, bio = ?, profile_picture = ? WHERE id = ?');
        if ($stmt->execute([$username, $email, $location, $bio, $profilePicture, $currentUser['id']])) {
            // Update session
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['location'] = $location;
            $_SESSION['user']['bio'] = $bio;
            $_SESSION['user']['profile_picture'] = $profilePicture;
            
            // Update current user data
            $currentUser = array_merge($currentUser, [
                'username' => $username,
                'email' => $email,
                'location' => $location,
                'bio' => $bio,
                'profile_picture' => $profilePicture
            ]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
            exit;
        } else {
            throw new Exception('Failed to update profile in database');
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

// Handle banner upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['header_banner'])) {
    // Clear any output buffers
    while (ob_get_level()) ob_end_clean();
    
    header('Content-Type: application/json');
    
    try {
        $targetDir = __DIR__ . '/uploads/banners/';
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                throw new Exception('Failed to create upload directory. Please check permissions.');
            }
        }
        
        // Ensure the directory is writable
        if (!is_writable($targetDir)) {
            throw new Exception('Upload directory is not writable. Please check permissions.');
        }

        $originalName = basename($_FILES['header_banner']['name']);
        $fileName = uniqid('', true) . '-' . $originalName;
        $targetFile = $targetDir . $fileName;
        
        // Validate file type
        $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            throw new Exception('Only JPG, JPEG, PNG & GIF files are allowed.');
        }
        
        // Check file size (max 5MB)
        if ($_FILES['header_banner']['size'] > 5 * 1024 * 1024) {
            throw new Exception('File is too large. Maximum size is 5MB.');
        }

        if (move_uploaded_file($_FILES['header_banner']['tmp_name'], $targetFile)) {
            // Update database
            $stmt = $db->prepare('UPDATE users SET header_banner = ? WHERE id = ?');
            $relativePath = 'uploads/banners/' . $fileName;
            if ($stmt->execute([$relativePath, $currentUser['id']])) {
                // Update session
                $_SESSION['user']['header_banner'] = $relativePath;
                $currentUser['header_banner'] = $relativePath;
                
                // Get the full URL for redirect
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                $host = $_SERVER['HTTP_HOST'];
                $redirectUrl = $protocol . $host . '/profile.php';
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Banner uploaded successfully!',
                    'bannerUrl' => '/' . $relativePath, // Return web-accessible path
                    'redirect' => $redirectUrl
                ]);
                exit;
            } else {
                @unlink($targetFile);
                throw new Exception('Failed to update banner in database.');
            }
        } else {
            throw new Exception('Failed to move uploaded file.');
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
        // In your profile picture upload handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    header('Content-Type: application/json');
    
    try {
        $targetDir = "uploads/avatars/";
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                throw new Exception('Failed to create upload directory.');
            }
        }

        $originalName = basename($_FILES['profile_picture']['name']);
        $fileName = uniqid('', true) . '-' . $originalName;
        $targetFile = $targetDir . $fileName;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            // Update database
            $stmt = $db->prepare('UPDATE users SET profile_picture = ? WHERE id = ?');
            if ($stmt->execute([$targetFile, $currentUser['id']])) {
                // Update session data directly
                $_SESSION['user']['profile_picture'] = $targetFile;
                $currentUser['profile_picture'] = $targetFile;
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Profile picture updated successfully!',
                    'profilePicture' => $targetFile
                ]);
                exit;
            } else {
                @unlink($targetFile); // Clean up if database update fails
                throw new Exception('Failed to update profile picture in database.');
            }
        } else {
            throw new Exception('Failed to move uploaded file.');
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}


// Handle profile form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_FILES['profile_picture']) && !isset($_FILES['header_banner']) && !isset($_POST['action'])) {
    if (empty($message)) {
        $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, profile_picture = :pic, bio = :bio, location = :location WHERE id = :id");
        if ($stmt->execute([
            'username' => $username, 
            'email' => $email, 
            'pic' => $profilePicPath, 
            'bio' => $bio,
            'location' => $location,
            'id' => $userId
        ])) {
            $message = "Profile updated successfully!";
            // Update session with new user data
            $_SESSION['user'] = [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
                'profile_picture' => $profilePicPath,
                'bio' => $bio,
                'location' => $location,
                'role' => $_SESSION['user']['role'] // Preserve the user's role
            ];
            $currentUser = $auth->getCurrentUser();
            $csrf->regenerateToken();
        } else {
            $message = "Failed to update profile.";
        }
    }
}

// Fetch user stats (placeholders - replace with actual data from your database)
// Fetch user stats
$stats = [
    'points' => 0,
    'rank' => 1,
    'challenges_completed' => 0,
    'quizzes_passed' => 0,
    'mini_games_completed' => 0,
    'tutorials_completed' => 0,
    'last_week_progress' => 0,
    'last_month_progress' => 0,
    'overall_progress' => 0
];

// Get user's points from quizzes and challenges
$pointsQuery = $db->prepare("
    SELECT (
        SELECT COALESCE(SUM(points_earned), 0) 
        FROM user_quiz_attempts 
        WHERE user_id = :user_id1
    ) + (
        SELECT COALESCE(SUM(points_earned), 0)
        FROM user_challenge_attempts 
        WHERE user_id = :user_id2
    ) as total_points
");
$pointsQuery->execute([
    ':user_id1' => $userId,
    ':user_id2' => $userId
]);
$stats['points'] = $pointsQuery->fetch(PDO::FETCH_COLUMN) ?: 0;

// Get challenges completed
$challengesQuery = $db->prepare("
    SELECT COUNT(DISTINCT question_id) 
    FROM user_challenge_attempts 
    WHERE user_id = :user_id AND is_correct = 1
");
$challengesQuery->execute([':user_id' => $userId]);
$stats['challenges_completed'] = $challengesQuery->fetch(PDO::FETCH_COLUMN);

// Get quizzes passed
$quizzesQuery = $db->prepare("
    SELECT COUNT(DISTINCT question_id) 
    FROM user_quiz_attempts 
    WHERE user_id = :user_id AND is_correct = 1
");
$quizzesQuery->execute([':user_id' => $userId]);
$stats['quizzes_passed'] = $quizzesQuery->fetch(PDO::FETCH_COLUMN);

// Get mini-games completed (Guess and Typing)
$gamesQuery = $db->prepare("
    SELECT COUNT(DISTINCT game_type) 
    FROM mini_game_results 
    WHERE user_id = :user_id 
    AND game_type IN ('guess', 'typing')
");
$gamesQuery->execute([':user_id' => $userId]);
$stats['mini_games_completed'] = $gamesQuery->fetch(PDO::FETCH_COLUMN);

// Get tutorials progress
$tutorialsQuery = $db->prepare("
    SELECT 
        COUNT(DISTINCT topic_id) as total_topics,
        SUM(CASE WHEN status = 'done_reading' THEN 1 ELSE 0 END) as completed_topics,
        SUM(CASE WHEN status = 'currently_reading' THEN 1 ELSE 0 END) as in_progress_topics
    FROM user_progress 
    WHERE user_id = :user_id
");

$tutorialsQuery->execute([':user_id' => $userId]);
$tutorialProgress = $tutorialsQuery->fetch(PDO::FETCH_ASSOC);

// If no progress found, set default values
if (!$tutorialProgress || $tutorialProgress['total_topics'] === null) {
    $tutorialProgress = [
        'total_topics' => 0,
        'completed_topics' => 0,
        'in_progress_topics' => 0
    ];
}

$stats['tutorials_completed'] = (int)$tutorialProgress['completed_topics'];
$stats['tutorials_in_progress'] = (int)$tutorialProgress['in_progress_topics'];
$stats['total_topics'] = (int)$tutorialProgress['total_topics'];
$stats['tutorial_progress_percentage'] = $stats['total_topics'] > 0 ? 
    round(($stats['tutorials_completed'] / $stats['total_topics']) * 100) : 0;

// Calculate rank (simplified version)
// Get all users and their total points for ranking
$stmt = $db->prepare("
    SELECT 
        user_id, 
        COALESCE(SUM(points_earned), 0) as total_points
    FROM (
        SELECT user_id, points_earned FROM user_quiz_attempts
        UNION ALL
        SELECT user_id, points_earned FROM user_challenge_attempts
    ) AS combined
    GROUP BY user_id
    ORDER BY total_points DESC
");
$stmt->execute();
$allUsersPoints = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate rank
$rank = 1;
$userRank = 1;

foreach ($allUsersPoints as $userPoints) {
    if ($userPoints['user_id'] == $userId) {
        $userRank = $rank;
        break;
    }
    $rank++;
}

$stats['rank'] = $userRank;

// Calculate progress percentages (simplified example)
$stats['overall_progress'] = min(100, 
    ($stats['challenges_completed'] * 5) + 
    ($stats['quizzes_passed'] * 2) + 
    ($stats['mini_games_completed'] * 10) + 
    ($stats['tutorial_progress_percentage'] * 0.3) // Weighted contribution to overall progress
);
$stats['last_week_progress'] = min(100, $stats['overall_progress'] * 0.8); // Example calculation
$stats['last_month_progress'] = min(100, $stats['overall_progress'] * 0.9); // Example calculation
?>


<main class="profile-page">

    <!-- Header Banner with Geometric Pattern -->
<div class="profile-banner-wrapper">
    <div class="profile-banner" style="background-image: url('<?php echo !empty($currentUser['header_banner']) ? htmlspecialchars($currentUser['header_banner']) : 'assets/images/default-banner.jpg'; ?>');">
        <div class="banner-pattern"></div>
        <div class="banner-upload-overlay" data-bs-toggle="modal" data-bs-target="#bannerUploadModal">
            <i class="fas fa-camera"></i> Change Banner
        </div>
    </div>
    <div class="profile-avatar-container">
        <img src="<?php echo !empty($currentUser['profile_picture']) ? htmlspecialchars($currentUser['profile_picture']) : '/assets/images/default-avatar.gif'; ?>" 
             alt="Profile Picture" 
             class="profile-avatar"
             id="avatarPreview"
             onerror="this.onerror=null; this.src='/assets/images/default-avatar.gif';">
        <div class="avatar-accent"></div>
    </div>
</div>

    <div class="container py-4">
        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Profile Header -->
        <div class="profile-header">
            <h1 class="profile-name"><?php echo htmlspecialchars($currentUser['username']); ?></h1>
            <p class="profile-title">Code Enthusiast</p>
            <p class="profile-location">
                <i class="fas fa-map-marker-alt me-2"></i>
                <span id="userLocation"><?php echo htmlspecialchars($currentUser['location'] ?? 'Earth, Milky Way'); ?></span>
            </p>
        </div>

        <div class="row">
            <link rel="stylesheet" href="assets/css/MainContent.css">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Progress Ring Section -->
                <div class="card gaming-hud-card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="hud-header mb-0" style="letter-spacing: 2px;">
                <i class="fa-solid fa-gauge-high me-2 text-info"></i>LEARNING_PROGRESS
            </h5>
            <div class="user-email text-info small">
                <i class="fa-solid fa-id-card-clip me-1"></i>
                <?php echo htmlspecialchars($currentUser['email']); ?>
            </div>
        </div>
        
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <div class="progress-ring-container position-relative d-inline-block">
                    <?php 
                        $circumference = 2 * M_PI * 54;
                        $offset = $circumference * (1 - $stats['overall_progress'] / 100);
                    ?>
                    <svg class="progress-ring__circle" width="150" height="150" viewBox="0 0 120 120">
                        <circle class="progress-ring__circle-bg" cx="60" cy="60" r="54" stroke-width="6" />
                        <circle class="progress-ring__circle-fill" 
                                cx="60" cy="60" r="54" stroke-width="6" 
                                stroke-dasharray="<?php echo $circumference; ?>" 
                                stroke-dashoffset="<?php echo $offset; ?>" />
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <div class="progress-ring__percent" style="font-size: 2rem; font-weight: 800; color: #fff; text-shadow: 0 0 10px var(--neon-cyan);">
                            <?php echo $stats['overall_progress']; ?>%
                        </div>
                        <div class="stat-label" style="font-size: 0.6rem;">INTEGRATED</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="progress-stats">
                    <div class="stat-item">
                        <span class="stat-label"><i class="fa-solid fa-trophy me-1"></i> Global Rank</span>
                        <span class="stat-value text-white">#<?php echo $stats['rank']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label"><i class="fa-solid fa-star me-1"></i> Total Points</span>
                        <span class="stat-value"><?php echo $stats['points']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Last Week</span>
                        <span class="stat-value" style="font-size: 1.1rem;"><?php echo $stats['last_week_progress']; ?>%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Last Month</span>
                        <span class="stat-value" style="font-size: 1.1rem;"><?php echo $stats['last_month_progress']; ?>%</span>
                    </div>
                </div>
            </div>
        </div>

        <hr style="border-color: rgba(0,243,255,0.1); margin: 25px 0;">

        <div class="progress-stats">
            <div class="stat-item">
                <div class="stat-value" style="font-size: 1.2rem;"><?php echo $stats['challenges_completed']; ?></div>
                <div class="stat-label">Challenges</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" style="font-size: 1.2rem;"><?php echo $stats['quizzes_passed']; ?></div>
                <div class="stat-label">Quizzes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" style="font-size: 1.2rem;"><?php echo $stats['mini_games_completed']; ?>/2</div>
                <div class="stat-label">Mini-Games</div>
            </div>
            
            <div class="stat-item" style="flex-grow: 2;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="stat-label">Tutorial Sync</span>
                    <span class="text-info small fw-bold"><?php echo $stats['tutorials_completed']; ?>/<?php echo $stats['total_topics']; ?></span>
                </div>
                <div class="stats-overview-progress" style="height: 4px; background: #222;">
                    <div class="stats-overview-progress-bar" style="height: 100%; background: var(--neon-cyan); box-shadow: 0 0 10px var(--neon-cyan); width: <?php echo $stats['tutorial_progress_percentage']; ?>%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
                
                <!-- About Me Section -->
                <div class="card dossier-card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="hud-header mb-0">
                <i class="fa-solid fa-address-card me-2 text-info"></i>USER_DOSSIER
            </h5>
            <button class="btn-pixel py-1 px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit me-1"></i> UPDATE
            </button>
        </div>

        <div class="about-content">
            <div class="bio-terminal">
                <p id="userBio" class="mb-0">
                    <span class="text-info font-monospace small d-block mb-1">> DATA_STREAM:</span>
                    <?php echo nl2br(htmlspecialchars($currentUser['bio'] ?? 'Biological data not yet recorded. Update profile to sync.')); ?>
                </p>
            </div>
            <a href="#" class="read-more-btn d-inline-block mt-2" id="readMoreBtn">[ RECOVER FULL DATA ]</a>
        </div>
        
        <div class="profile-completeness mt-4">
            <?php 
                $completeness = 20; 
                $completeness += !empty($currentUser['profile_picture']) ? 20 : 0;
                $completeness += !empty($currentUser['bio']) ? 20 : 0;
                $completeness += !empty($currentUser['location']) ? 20 : 0;
                $completeness = min($completeness, 100);
            ?>
            
            <div class="d-flex justify-content-between align-items-end mb-2">
                <div class="stat-label">Neural Sync Completion</div>
                <div class="text-info fw-bold" style="font-size: 1.2rem;"><?php echo $completeness; ?>%</div>
            </div>

            <div class="xp-meter-container">
                <div class="xp-meter-fill" style="width: <?php echo $completeness; ?>%;"></div>
            </div>

            <div class="form-text mt-2 text-muted" style="font-size: 0.7rem; text-transform: uppercase;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> 
                Achieve 100% sync to unlock advanced player titles
            </div>
        </div>
    </div>
    </div>
                
                <!-- Recent Activity -->
                    <div class="card activity-feed-card mb-4">
    <div class="card-body">
        <h5 class="card-title mb-4" style="color: #00f3ff; font-weight: 800; letter-spacing: 2px;">
            <i class="fa-solid fa-bolt me-2"></i> RECENT_ACTIVITY_STREAM
        </h5>
        
        <div class="activity-feed">
            <div class="activity-item d-flex align-items-center">
                <div class="activity-icon rounded-circle me-3">
                    <i class="fas fa-trophy text-primary"></i>
                </div>
                <div>
                    <span class="activity-title">Completed Python Basics</span>
                    <span class="activity-time">> 2 HOURS AGO</span>
                </div>
            </div>

            <div class="activity-item d-flex align-items-center">
                <div class="activity-icon rounded-circle me-3">
                    <i class="fas fa-flag-checkered text-success"></i>
                </div>
                <div>
                    <span class="activity-title">Challenge: Web Security</span>
                    <span class="activity-time">> 1 DAY AGO</span>
                </div>
            </div>

            <div class="activity-item d-flex align-items-center">
                <div class="activity-icon rounded-circle me-3">
                    <i class="fas fa-book text-info"></i>
                </div>
                <div>
                    <span class="activity-title">Tutorial: JavaScript ES6+</span>
                    <span class="activity-time">> 3 DAYS AGO</span>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Connect With Me -->
<div class="card comms-card mb-4">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-white hud-header" style="letter-spacing: 2px;">
                <i class="fa-solid fa-satellite-dish me-2 text-info"></i>NETWORK_LINKS
            </h5>
            <div id="socialMediaMessage" class="ms-3 small text-success" style="display: none;">
                <i class="fas fa-check-circle"></i> <span id="socialMediaMessageText"></span>
            </div>
        </div>
        <button type="button" class="btn-pixel py-1 px-3" style="font-size: 10px;" data-bs-toggle="modal" data-bs-target="#socialMediaModal">
            <i class="fas fa-edit me-1"></i> MODIFY
        </button>
    </div>

    <div class="card-body">
        <div class="social-links">
            <a href="<?php echo !empty($currentUser['social_instagram']) ? 'https://instagram.com/' . htmlspecialchars($currentUser['social_instagram']) : '#'; ?>" 
               class="social-link link-ig <?php echo empty($currentUser['social_instagram']) ? 'opacity-50' : ''; ?>" target="_blank">
                <i class="fab fa-instagram me-2"></i> 
                <span><?php echo !empty($currentUser['social_instagram']) ? htmlspecialchars($currentUser['social_instagram']) : 'OFFLINE'; ?></span>
            </a>

            <a href="<?php echo !empty($currentUser['social_facebook']) ? 'https://facebook.com/' . htmlspecialchars($currentUser['social_facebook']) : '#'; ?>" 
               class="social-link link-fb <?php echo empty($currentUser['social_facebook']) ? 'opacity-50' : ''; ?>" target="_blank">
                <i class="fab fa-facebook me-2"></i> 
                <span><?php echo !empty($currentUser['social_facebook']) ? htmlspecialchars($currentUser['social_facebook']) : 'OFFLINE'; ?></span>
            </a>

            <a href="<?php echo !empty($currentUser['social_twitter']) ? 'https://twitter.com/' . htmlspecialchars($currentUser['social_twitter']) : '#'; ?>" 
               class="social-link link-tw <?php echo empty($currentUser['social_twitter']) ? 'opacity-50' : ''; ?>" target="_blank">
                <i class="fab fa-twitter me-2"></i> 
                <span><?php echo !empty($currentUser['social_twitter']) ? htmlspecialchars($currentUser['social_twitter']) : 'OFFLINE'; ?></span>
            </a>

            <a href="<?php echo !empty($currentUser['social_pinterest']) ? 'https://pinterest.com/' . htmlspecialchars($currentUser['social_pinterest']) : '#'; ?>" 
               class="social-link link-pin <?php echo empty($currentUser['social_pinterest']) ? 'opacity-50' : ''; ?>" target="_blank">
                <i class="fab fa-pinterest me-2"></i> 
                <span><?php echo !empty($currentUser['social_pinterest']) ? htmlspecialchars($currentUser['social_pinterest']) : 'OFFLINE'; ?></span>
            </a>
        </div>
    </div>
</div>
                
                <!-- Danger Zone -->
                <div class="card danger-zone-card mb-4">
    <div class="card-header danger-header d-flex align-items-center py-3">
        <i class="fas fa-radiation-alt me-2 pulse-red"></i> 
        CRITICAL_TERMINATION_ZONE
    </div>
    
    <div class="card-body">
        <p class="danger-text mb-4">
            <span class="text-danger fw-bold">WARNING:</span> 
            Initiating these protocols will result in permanent data erasure. 
            Recovery of player stats, rank, and inventory is impossible after execution.
        </p>
        
        <div class="d-grid gap-3">
            <button class="btn-destruct" id="btnDeactivate">
                <i class="fas fa-power-off me-2"></i> Suspend Neural Link
            </button>
            
            <button class="btn-destruct" id="btnDelete" style="border-style: double; border-width: 3px;">
                <i class="fas fa-skull me-2"></i> Wipe Core Database
            </button>
        </div>
    </div>
    
    <div style="height: 5px; background: #ff2a6d; width: 100%; opacity: 0.3;"></div>
</div>
            </div>
        </div>
    </div>
</main>

<!-- Banner Upload Modal -->
<div class="modal fade" id="bannerUploadModal" tabindex="-1" aria-labelledby="bannerUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerUploadModalLabel">Upload Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bannerUploadForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="header_banner" class="form-label">Choose a banner image (JPEG, PNG, GIF, max 5MB)</label>
                        <input type="file" class="form-control" id="header_banner" name="header_banner" accept="image/*" required>
                        <div class="form-text">Recommended size: 1200x300 pixels</div>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf->getToken(); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadBannerBtn">
                        <span class="upload-text">Upload Banner</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="profileForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf->getToken(); ?>">
                    
                    <div class="mb-3 text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?php echo !empty($currentUser['profile_picture']) ? htmlspecialchars($currentUser['profile_picture']) : 'assets/images/default-avatar.gif'; ?>" 
                                alt="Profile Picture" 
                                class="rounded-circle mb-2" 
                                id="profileImagePreview"
                                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <label for="profile_picture" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" style="width: 36px; height: 36px; line-height: 24px; cursor: pointer;">
                                <i class="fas fa-camera"></i>
                                <input type="file" class="d-none" id="profile_picture" name="profile_picture" accept="image/*">
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                            value="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                            value="<?php echo htmlspecialchars($currentUser['location'] ?? ''); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($currentUser['bio'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Account Action Modal -->
<div class="modal fade" id="accountActionModal" tabindex="-1" aria-labelledby="accountActionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="accountActionForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountActionLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="accountActionInput" />
                    <div class="mb-3">
                        <p id="accountActionText" class="mb-2"></p>
                        <label for="verifyPassword" class="form-label">Enter password to confirm</label>
                        <input type="password" class="form-control" id="verifyPassword" name="password" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="accountActionSubmit">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Social Media Links Modal -->
<div class="modal fade" id="socialMediaModal" tabindex="-1" aria-labelledby="socialMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="socialMediaModalLabel">Update Social Media Links</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="socialMediaForm" method="POST" onsubmit="return false;">
                <input type="hidden" name="action" value="update_social_media">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf->getToken(); ?>">
                    <div class="mb-3">
                        <label for="social_instagram" class="form-label">
                            <i class="fab fa-instagram me-2 text-instagram"></i> Instagram
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">https://instagram.com/</span>
                            <input type="text" class="form-control" id="social_instagram" name="social_instagram" 
                                value="<?php echo !empty($currentUser['social_instagram']) ? htmlspecialchars($currentUser['social_instagram']) : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="social_facebook" class="form-label">
                            <i class="fab fa-facebook me-2 text-primary"></i> Facebook
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">https://facebook.com/</span>
                            <input type="text" class="form-control" id="social_facebook" name="social_facebook"
                                value="<?php echo !empty($currentUser['social_facebook']) ? htmlspecialchars($currentUser['social_facebook']) : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="social_twitter" class="form-label">
                            <i class="fab fa-twitter me-2 text-info"></i> Twitter
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">https://twitter.com/</span>
                            <input type="text" class="form-control" id="social_twitter" name="social_twitter"
                                value="<?php echo !empty($currentUser['social_twitter']) ? htmlspecialchars($currentUser['social_twitter']) : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="social_pinterest" class="form-label">
                            <i class="fab fa-pinterest me-2 text-danger"></i> Pinterest
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">https://pinterest.com/</span>
                            <input type="text" class="form-control" id="social_pinterest" name="social_pinterest"
                                value="<?php echo !empty($currentUser['social_pinterest']) ? htmlspecialchars($currentUser['social_pinterest']) : ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Include the external JavaScript file -->
<script src="assets/js/profile-page.js"></script>
<script src="assets/js/profile.js"></script>
