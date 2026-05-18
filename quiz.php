<?php
// Include visitor tracking
require_once 'includes/track_visitor.php';

/**
 * ==========================================================
 * File: quiz.php
 * 
 * Description:
 *   - Interactive Quiz page for SkillForge platform
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
    <h1 class="quiz-title">QUIZ SkillForge</h1>
    <div class="quiz-subtitle">Test Your Programming Knowledge!</div>
  </div>

  <!-- Quiz Container -->
  <section class="quiz-container">
    <!-- Welcome Intro Screen -->
     <link rel="stylesheet" href="assets/css/WelcomeIntro.css">
    <div class="quiz-welcome-screen">
    <div class="hud-analytics-terminal-bg initialization-terminal-wrapper">
        <div class="hud-main-terminal-window quiz-primary-window">
            
            <div class="hud-terminal-title-bar d-flex justify-content-between align-items-center w-100">
                <div class="hud-terminal-glitch-text">
                    <span class="hud-terminal-prefix">⚡</span> SYSTEM_INITIALIZATION: KNOWLEDGE_EVALUATION
                </div>
                <div class="hud-terminal-deco-lines" aria-hidden="true">
                    <span></span><span></span><span></span>
                </div>
            </div>
            
            <div class="hud-terminal-content p-4 p-md-5">
                <div class="welcome-content mb-4 text-center">
                    <div class="welcome-icon-wrapper mb-3">
                        <i class='bx bx-rocket game-icon-pulse'></i>
                    </div>
                    <h2 class="hud-terminal-main-title text-uppercase">Ready to take the quiz?</h2>
                    <p class="hud-terminal-subtitle">
                        Embark on an elite assessment matrix through compiled logic segments. 
                        Calibrate your syntax compiler core, verify execution blocks, and secure your index log on the network mainframe.
                    </p>
                </div>
                
                <div class="welcome-features hud-feature-grid mb-5">
                    <div class="feature-item">
                        <span class="feature-icon">🎯</span>
                        <div class="feature-meta">
                            <span class="feature-label text-uppercase">Vector Tuning</span>
                            <span class="feature-text">3 Difficulty Tiers</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">💖</span>
                        <div class="feature-meta">
                            <span class="feature-label text-uppercase">Integrity Shield</span>
                            <span class="feature-text">7 Lives System</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">⏰</span>
                        <div class="feature-meta">
                            <span class="feature-label text-uppercase">Chronometer</span>
                            <span class="feature-text">Expert Timer Mode</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🏆</span>
                        <div class="feature-meta">
                            <span class="feature-label text-uppercase">Mainframe Log</span>
                            <span class="feature-text">Leaderboards</span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center w-100">
                    <button class="btn btn-game-action trigger-cyan welcome-start-btn text-uppercase" id="startQuizBtn" 
                            onclick="document.querySelector('.quiz-welcome-screen').style.display='none'; 
                                     document.querySelector('.quiz-start-screen').style.display='block';
                                     if(window.initDifficultySelection) window.initDifficultySelection();">
                        Initialize Evaluation Mode
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</div>

    <!-- Start Screen -->
    <div class="quiz-start-screen" style="display:none;">
  <!-- Gaming-style Header -->
  <h2 class="quiz-section-title"><i class="fas fa-gamepad"></i> Select Your Mission</h2>
  
  <div class="difficulty-options">
    <!-- Beginner / Easy Mode -->
    <button class="btn-pixel difficulty-btn" data-difficulty="beginner">
      <div class="difficulty-icon"><i class="fas fa-shield-halved"></i></div>
      <div class="difficulty-info">
        <div class="difficulty-name">Beginner [LVL 1]</div>
        <div class="difficulty-desc">Perfect for new recruits</div>
      </div>
    </button>
    
    <!-- Intermediate / Normal Mode -->
    <button class="btn-pixel difficulty-btn" data-difficulty="intermediate">
      <div class="difficulty-icon"><i class="fas fa-sword"></i></div>
      <div class="difficulty-info">
        <div class="difficulty-name">Intermediate [LVL 50]</div>
        <div class="difficulty-desc">For seasoned code warriors</div>
      </div>
    </button>
    
    <!-- Expert / Hardcore Mode -->
    <button class="btn-pixel difficulty-btn" data-difficulty="expert">
      <div class="difficulty-icon"><i class="fas fa-dragon"></i></div>
      <div class="difficulty-info">
        <div class="difficulty-name">Expert [NIGHTMARE]</div>
        <div class="difficulty-desc">The ultimate boss battle</div>
      </div>
    </button>
  </div>
  
  <!-- Gaming-style Quest Intro -->
  <div class="quiz-intro">
    <p><i class="fas fa-scroll"></i> Ready to test your programming build? Choose your difficulty level and enter the arena!</p>
    <p><i class="fas fa-trophy"></i> This campaign contains 40 trials covering HTML, CSS, JavaScript, Python, Bootstrap, C++, and Java.</p>
  </div>
  
  <?php if (!$auth->isLoggedIn()): ?>
  <!-- Guest Player Registration -->
  <div class="nickname-input">
    <label for="guest-nickname"><i class="fas fa-user-tag"></i> Enter Player 1 Name:</label>
    <input type="text" id="guest-nickname" maxlength="20" placeholder="INSERT COOL NICKNAME..." />
    <span id="nickname-status" class="nickname-status"></span>
  </div>
  <?php endif; ?>
  
  <!-- Control Buttons -->
  <div class="start-controls">
    <button class="btn-pixel instructions-btn" title="View Quest Rules">
      <i class="fas fa-circle-question"></i>
    </button>
    <button class="btn-pixel start-quiz-btn">
      <i class="fas fa-play"></i> START GAME
    </button>
  </div>
</div>

    <!-- Quiz In-Progress (hidden until quiz starts) -->
    <div class="quiz-in-progress" style="display:none;">
      <div class="quiz-status-bar">
        <div class="quiz-hearts"><!-- ♥♥♥♥♥♥♥ --></div>
        <div class="quiz-progress">Q1/40</div>
        <div class="quiz-timer" style="display:none;">00:30</div>
      </div>
      
      <div class="quiz-game-area">
        <div class="quiz-spaceship">
          <!-- Spaceship sprite/animation placeholder -->
        </div>
        <div class="quiz-question-box">
          <!-- Question text (pixel-art styled) -->
        </div>
        <div class="quiz-choices">
          <!-- Multiple-choice or True/False buttons -->
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
