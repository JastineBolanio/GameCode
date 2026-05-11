<?php
// Include visitor tracking
require_once 'includes/track_visitor.php';

/**
 * ==========================================================
 * File: quiz.php
 * 
 * Description:
 *   - Interactive Quiz page for Code Gaming platform
 *   - Features:
 *       • Welcome and difficulty selection screens with instructions
 *       • Multiple-choice questions with pixel-art styled UI
 *       • 3 difficulty levels (Beginner, Intermediate, Expert)
 *       • 7 lives system and expert timer mode
 *       • 40 programming questions (HTML, CSS, JS, Python, Bootstrap, C++, Java)
 *       • Pixel-art styled UI and animated elements
 *       • Leaderboard, feedback, and end-of-quiz modals
 *       • Guest nickname input and validation
 * 
 * Usage:
 *   - Accessible to all users and guests
 *   - Allows users to test programming knowledge and compete for high scores
 * 
 * @author [Santiago]
 * @version 1.0.0
 * @last_updated 2025-07-22
 * -- Code Gaming Team --
 * ==========================================================
 */

// With the actual required includes, for example:
  require_once 'includes/Database.php';
  require_once 'includes/Auth.php';

// Initialize core components
$db = Database::getInstance();
$auth = Auth::getInstance();

// Set page title for the header
$pageTitle = "Quiz";
?>

<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/quiz-style.css">
<main class="quiz-main-bg">
  <!-- Pixel Font Title Banner -->
  <div class="quiz-title-banner">
    <h1 class="quiz-title">QUIZ CODE GAMING</h1>
    <div class="quiz-subtitle">Test Your Programming Knowledge!</div>
  </div>

  <!-- Quiz Container -->
<section class="quiz-container">
    <div class="quiz-welcome-screen">
        <div class="welcome-content text-center">
            <div class="welcome-icon mb-4">
                <i class="fa-solid fa-microchip glow-pulse"></i>
            </div>
            
            <h2 class="welcome-title">INITIALIZING SYNC...</h2>
            <p class="welcome-message mx-auto">
                Embark on an epic journey through the world of programming! 
                Choose your difficulty, test your skills, and climb the leaderboard.
            </p>

            <div class="welcome-features">
                <div class="feature-item">
                    <i class="fa-solid fa-layer-group feature-icon"></i>
                    <span class="feature-text">3 Difficulty Tiers</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-heart-pulse feature-icon" style="color: var(--neon-red)"></i>
                    <span class="feature-text">7 Lives System</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-stopwatch feature-icon"></i>
                    <span class="feature-text">Expert Timer Mode</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-ranking-star feature-icon"></i>
                    <span class="feature-text">Global Rankings</span>
                </div>
            </div>

            <button class="btn-pixel welcome-start-btn" id="startQuizBtn" 
                    onclick="document.querySelector('.quiz-welcome-screen').style.display='none'; 
                             document.querySelector('.quiz-start-screen').style.display='block';
                             if(window.initDifficultySelection) initDifficultySelection();">
                TAKE THE QUIZ
            </button>
        </div>
    </div>

    <!-- Start Screen -->
    <div class="quiz-start-screen" style="display:none;">
    <h2 class="quiz-section-title text-center mb-4 hud-header">SELECT CHALLENGE TIER</h2>
    
    <div class="difficulty-options">
        <!-- Beginner Tier -->
        <button class="btn-pixel difficulty-btn" data-difficulty="beginner">
            <div class="difficulty-icon" style="color: #00ff88;"><i class="fa-solid fa-seedling"></i></div>
            <div class="difficulty-info">
                <div class="difficulty-name">Beginner</div>
                <div class="difficulty-desc">Standard syntax & basics</div>
            </div>
        </button>

        <!-- Intermediate Tier -->
        <button class="btn-pixel difficulty-btn" data-difficulty="intermediate">
            <div class="difficulty-icon" style="color: #bc13fe;"><i class="fa-solid fa-bolt-lightning"></i></div>
            <div class="difficulty-info">
                <div class="difficulty-name">Intermediate</div>
                <div class="difficulty-desc">Logic & complex structures</div>
            </div>
        </button>

        <!-- Expert Tier -->
        <button class="btn-pixel difficulty-btn" data-difficulty="expert">
            <div class="difficulty-icon" style="color: #ff2a6d;"><i class="fa-solid fa-skull-crossbones"></i></div>
            <div class="difficulty-info">
                <div class="difficulty-name">Expert</div>
                <div class="difficulty-desc">Architecture & optimization</div>
            </div>
        </button>
    </div>
    
    <div class="quiz-intro gaming-panel text-center p-3 mb-4">
        <p class="mb-1 fw-bold text-uppercase" style="letter-spacing: 2px; color: #fff;">Mission Objectives:</p>
        <p class="small text-secondary">
            Analyze 40 core data fragments across 
            <span class="text-white">HTML, CSS, JS, Python, Bootstrap, C++, and Java</span>.
        </p>
    </div>
    
    <?php if (!$auth->isLoggedIn()): ?>
    <div class="nickname-input text-center mb-4">
        <label for="guest-nickname" class="d-block small text-uppercase fw-bold mb-2">Assign Callsign:</label>
        <input type="text" id="guest-nickname" maxlength="20" placeholder="ENTER NICKNAME" />
        <span id="nickname-status" class="nickname-status"></span>
    </div>
    <?php endif; ?>
    
    <div class="start-controls d-flex justify-content-center gap-3">
        <button class="btn-pixel instructions-btn" title="View Instructions">
            <i class="fa-solid fa-circle-info"></i>
        </button>
        <button class="btn-pixel start-quiz-btn" style="flex-grow: 1; max-width: 300px;">
            START MISSION
        </button>
    </div>
</div>

<!-- IN-PROGRESS HUD (Cleaned up) -->
<div class="quiz-in-progress" style="display:none;">
    <div class="quiz-status-bar d-flex justify-content-between align-items-center">
        <div class="quiz-hearts d-flex gap-1 text-danger">
            <i class="fa-solid fa-heart"></i>
            <i class="fa-solid fa-heart"></i>
            <i class="fa-solid fa-heart"></i>
            <!-- Hearts rendered by JS -->
        </div>
        <div class="quiz-progress fw-bold">FRAG: 01/40</div>
        <div class="quiz-timer neon-text fw-bold" style="display:none;">
            <i class="fa-solid fa-clock me-1"></i> 00:30
        </div>
    </div>
    
    <div class="quiz-game-area mt-5">
        <div class="quiz-spaceship text-center mb-4">
            <i class="fa-solid fa-jet-fighter fa-3x neon-text"></i>
        </div>
        <div class="quiz-question-box p-4 border border-secondary bg-black text-center mb-4">
            <p class="hud-header small mb-2 text-info">Incoming Data Stream...</p>
            <h4 class="question-text fw-bold"></h4>
        </div>
        <div class="quiz-choices d-grid gap-3">
            <!-- Choice buttons injected by JS -->
        </div>
    </div>
</div>
  </section>

  <!-- Feedback Modal (Correct/Wrong) -->
  <div id="quiz-feedback-modal" class="quiz-modal" style="display:none;">
    <div class="modal-content">
      <!-- Enhanced feedback content -->
    </div>
  </div>

  <!-- End of Quiz Modal -->
  <div id="quiz-end-modal" class="quiz-modal" style="display:none;">
    <div class="modal-content">
      <!-- Enhanced end screen content -->
    </div>
  </div>

  <!-- Leaderboard Modal/Sidebar -->
  <div id="quiz-leaderboard-modal" class="quiz-modal" style="display:none;">
    <div class="modal-content">
      <!-- Enhanced leaderboard content -->
    </div>
  </div>

  <section class="quiz-credits-section">
    <div class="credits-content">
      <span>Enjoy answering questions!</span>
    </div>
  </section>
  
  <!-- Quiz Scripts - Must be inside main/body -->
  <script>
  // Set user variables BEFORE loading quiz.js
  <?php if ($auth->isLoggedIn()): ?>
    <?php $currentUser = $auth->getCurrentUser(); ?>
    window.CG_USER_ID = <?php echo json_encode($currentUser['id'] ?? null); ?>;
    window.CG_USERNAME = <?php echo json_encode($currentUser['username'] ?? null); ?>;
    console.log('User variables set:', { userId: window.CG_USER_ID, username: window.CG_USERNAME });
  <?php else: ?>
    console.log('User not logged in');
  <?php endif; ?>
  </script>
  <script src="assets/js/quiz.js"></script>
</main>

 <!-- ===== Footer ===== -->
 <?php include 'includes/footer.php'; ?>
