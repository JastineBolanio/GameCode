<?php
/**
 * ==========================================================
 * File: privacy.php
 * 
 * Description:
 *   - Privacy Policy page with interactive Rellax background
 *   - Features:
 *       • Floating privacy icons and security elements
 *       • Expandable content sections
 *       • Interactive privacy quiz
 *       • Language toggle functionality
 *       • Print/Download options
 *       • Responsive design with accessibility
 * 
 * Usage:
 *   - Public page accessible to all users and visitors
 *   - Displays comprehensive privacy policy with engaging UI
 * 
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include visitor tracking if file exists
if (file_exists(__DIR__ . '/includes/track_visitor.php')) {
    require_once __DIR__ . '/includes/track_visitor.php';
}

// Include CSRF protection if file exists
$csrf = null;
if (file_exists(__DIR__ . '/includes/CSRFProtection.php')) {
    require_once __DIR__ . '/includes/CSRFProtection.php';
    $csrf = CSRFProtection::getInstance();
}

// Check if auth class exists and initialize it
$auth = null;
if (file_exists(__DIR__ . '/includes/Auth.php')) {
    require_once __DIR__ . '/includes/Auth.php';
    if (class_exists('Auth') && method_exists('Auth', 'getInstance')) {
        $auth = Auth::getInstance();
    }
}

// Set page title for header
$pageTitle = 'Privacy Policy';

// Include header
include 'includes/header.php';
?>

<!-- Privacy Policy Hero Section -->
 <link rel="stylesheet" href="assets/css/PrivacyV2.css">
<section class="privacy-hero gaming-privacy-wrapper py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center privacy-content-alignment">
                
                <div class="back-button-wrapper mb-4">
                    <a href="anchor.php" class="btn console-back-trigger">
                        <i class="fas fa-terminal me-2"></i> RETURN_TO_CORE
                    </a>
                </div>
                
                <h1 class="privacy-title crypto-header-title">
                    <span class="privacy-icon crypto-icon-glow">🔒</span>
                    PRIVACY_PROTOCOLS
                    <span class="privacy-icon crypto-icon-glow">🔒</span>
                </h1>
                
                <p class="privacy-subtitle crypto-meta-body">
                    We are strictly committed to data insulation, continuous encryption optimization, and total architecture transparency.
                </p>
                
            </div>
        </div>
    </div>
    
    <div class="floating-elements telemetry-floating-nodes">
        <div class="privacy-element" data-rellax-speed="2">🔐</div>
        <div class="privacy-element" data-rellax-speed="-1">🛡️</div>
        <div class="privacy-element" data-rellax-speed="3">✅</div>
        <div class="privacy-element" data-rellax-speed="-2">🔒</div>
        <div class="privacy-element" data-rellax-speed="1">⚡</div>
        <div class="privacy-element" data-rellax-speed="2">🎯</div>
        <div class="privacy-element" data-rellax-speed="-3">🔍</div>
        <div class="privacy-element" data-rellax-speed="1">💎</div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="privacy-content">
    <div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            
            <div class="reading-progress terminal-progress-wrapper mb-4">
                <div class="progress-bar terminal-bar-bg">
                    <div class="progress-fill terminal-fill-cyan"></div>
                </div>
                <span class="progress-text matrix-progress-label">
                    TELEMETRY_READ_PROGRESS: <span class="progress-percentage terminal-highlight-cyan">0%</span>
                </span>
            </div>

            <div class="policy-section terminal-secure-card fully-expanded" id="introduction">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('introduction')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-biohazard icon-alert-glow me-2"></i> 01 // PRIVACY SECURE NODE
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-introduction"></i>
    </div>
    
    <div class="section-content terminal-box-body red-alert-body" id="body-introduction">
        <p class="policy-body-text red-contrast-text">Welcome to SkillForge! We respect your privacy and are completely committed to insulating your personal data footprints. This master architecture file defines how we isolate, track, and encrypt your processing metrics.</p>
        <p class="policy-body-text red-contrast-text">By establishing active sessions with SkillForge, you grant temporary clearance tokens in accordance with this strict protective doctrine. We do not channel, distribute, or leak database contents to third-party assets.</p>
        
        <div class="policy-highlight terminal-danger-well-box">
            <i class="fas fa-shield-alt icon-alert-glow me-2"></i>
            <strong class="danger-strong-text">SYSTEM_COMMITMENT:</strong> 
            <span class="danger-body-text">Your privacy is our priority. We implement industry-standard cryptographic security measures to protect your data pools.</span>
        </div>
    </div>
</div>

                <!-- Information We Collect -->
                <div class="policy-section terminal-secure-card mb-3" id="data-collection">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('data-collection')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-database icon-alert-glow me-2"></i> 02 // INFORMATION WE COLLECT
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-data-collection"></i>
    </div>
    
    <div class="section-content terminal-box-body red-alert-body" id="body-data-collection">
        
        <h4 class="terminal-body-subtitle"><i class="fas fa-angle-right me-1"></i> PERSONAL_DATA_MATRICES</h4>
        <ul class="terminal-protocol-list">
            <li><strong class="danger-strong-text">Account Data:</strong> <span class="list-body-text">Username, email address, and core security profile metrics.</span></li>
            <li><strong class="danger-strong-text">Usage Data:</strong> <span class="list-body-text">Game progress, execution speeds, achievements, and telemetry learning patterns.</span></li>
            <li><strong class="danger-strong-text">Technical Data:</strong> <span class="list-body-text">Masked IP parameters, browser environment tokens, device footprints, and essential cookies.</span></li>
        </ul>
        
        <h4 class="terminal-body-subtitle mt-4"><i class="fas fa-angle-right me-1"></i> INGESTION_METHODOLOGY</h4>
        <div class="collection-methods terminal-method-grid">
            
            <div class="method-card terminal-sub-well">
                <i class="fas fa-user-plus icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">REGISTRATION</h5>
                <p class="sub-well-text">During profile token creation</p>
            </div>
            
            <div class="method-card terminal-sub-well">
                <i class="fas fa-gamepad icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">GAMEPLAY</h5>
                <p class="sub-well-text">During live engine sessions</p>
            </div>
            
            <div class="method-card terminal-sub-well">
                <i class="fas fa-cookie-bite icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">COOKIES</h5>
                <p class="sub-well-text">To persist environment states</p>
            </div>
            
        </div>
        
    </div>
</div>

                <!-- How We Use Information -->
               <div class="policy-section terminal-secure-card mb-3" id="data-usage">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('data-usage')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-cogs icon-alert-glow me-2"></i> 03 // HOW WE USE YOUR INFORMATION
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-data-usage"></i>
    </div>
    
    <div class="section-content terminal-box-body red-alert-body" id="body-data-usage">
        
        <h4 class="terminal-body-subtitle mb-3"><i class="fas fa-terminal me-1"></i> ACTIVE_PROCESSING_PIPELINES</h4>
        <div class="usage-grid terminal-usage-grid">
            
            <div class="usage-item terminal-sub-well-dark">
                <i class="fas fa-chart-line icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">OPTIMIZE_LEARNING</h5>
                <p class="sub-well-text-bright">Personalize your unique coding journey and dynamically adapt tracking metrics.</p>
            </div>
            
            <div class="usage-item terminal-sub-well-dark">
                <i class="fas fa-trophy icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">ACHIEVEMENTS_ENGINE</h5>
                <p class="sub-well-text-bright">Calculate, verify, and output profile cryptographic accomplishments.</p>
            </div>
            
            <div class="usage-item terminal-sub-well-dark">
                <i class="fas fa-users icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">COMMUNITY_MATRIX</h5>
                <p class="sub-well-text-bright">Deploy live system leaderboards, rank nodes, and safe interactive social instances.</p>
            </div>
            
            <div class="usage-item terminal-sub-well-dark">
                <i class="fas fa-tools icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">CORE_INFRASTRUCTURE</h5>
                <p class="sub-well-text-bright">Maintain backend processing structures and eliminate environmental vulnerabilities.</p>
            </div>
            
        </div>
        
    </div>
</div>

                <!-- Data Sharing -->
                <div class="policy-section terminal-secure-card mb-3" id="data-sharing">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('data-sharing')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-share-alt icon-alert-glow me-2"></i> 04 // DATA SHARING &amp; THIRD PARTIES
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-data-sharing"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-data-sharing">
        
        <p class="policy-body-text red-contrast-text">
            We operate under a zero-monetization database protocol: your metric tokens are never sold, traded, or rented to external corporate nodes. Information distribution is blocked unless forced by the following critical systemic conditions:
        </p>
        
        <div class="sharing-scenarios terminal-scenario-stack mt-3">
            
            <div class="scenario terminal-list-row">
                <div class="row-icon-housing">
                    <i class="fas fa-check-circle icon-alert-glow"></i>
                </div>
                <span class="row-text-content">
                    <strong class="danger-strong-text">EXPLICIT_USER_CONSENT:</strong> 
                    <span class="list-body-text">When you manually authorize connection interfaces or public gateway integrations.</span>
                </span>
            </div>
            
            <div class="scenario terminal-list-row">
                <div class="row-icon-housing">
                    <i class="fas fa-gavel icon-alert-glow"></i>
                </div>
                <span class="row-text-content">
                    <strong class="danger-strong-text">STATUTORY_LEGAL_MANDATE:</strong> 
                    <span class="list-body-text">When verification is demanded by verified legal jurisdiction infrastructure orders.</span>
                </span>
            </div>
            
            <div class="scenario terminal-list-row">
                <div class="row-icon-housing">
                    <i class="fas fa-shield-alt icon-alert-glow"></i>
                </div>
                <span class="row-text-content">
                    <strong class="danger-strong-text">ISOLATED_SERVICE_PROVIDERS:</strong> 
                    <span class="list-body-text">Trusted database maintenance nodes bound strictly by non-disclosure encryption clauses.</span>
                </span>
            </div>
            
        </div>
    </div>
</div>

                <!-- User Rights -->
                <div class="policy-section terminal-secure-card mb-3" id="user-rights">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('user-rights')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-user-shield icon-alert-glow me-2"></i> 05 // YOUR RIGHTS &amp; CONTROL
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-user-rights"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-user-rights">
        
        <h4 class="terminal-body-subtitle mb-3"><i class="fas fa-terminal me-1"></i> USER_PRIVILEGE_MATRICES</h4>
        <div class="rights-grid terminal-rights-grid">
            
            <div class="right-item terminal-sub-well-dark">
                <i class="fas fa-eye icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">ACCESS_RECORDS</h5>
                <p class="sub-well-text-bright">Request and review all raw personal footprint logs linked to your active profile node.</p>
            </div>
            
            <div class="right-item terminal-sub-well-dark">
                <i class="fas fa-edit icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">UPDATE_METRICS</h5>
                <p class="sub-well-text-bright">Modify or rectify inaccurate data parameters registered inside our live directory pools.</p>
            </div>
            
            <div class="right-item terminal-sub-well-dark">
                <i class="fas fa-trash icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">PURGE_DATA</h5>
                <p class="sub-well-text-bright">Completely wipe, drop, and decouple your historical account tables from the main engine.</p>
            </div>
            
            <div class="right-item terminal-sub-well-dark">
                <i class="fas fa-download icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">EXPORT_SCHEMA</h5>
                <p class="sub-well-text-bright">Extract a structured download file containing your platform runtime configuration variables.</p>
            </div>
            
        </div>
        
        <div class="control-panel terminal-action-well mt-4">
            <h4 class="terminal-body-subtitle menu-header-border"><i class="fas fa-sliders-h me-2 text-alert-neon"></i> OVERRIDE_CONTROLS</h4>
            
            <div class="action-buttons terminal-button-cluster">
                <button class="btn console-action-trigger trigger-blue-glow" onclick="exportData()">
                    <i class="fas fa-download me-2"></i> EXPORT_SESSION_DATA
                </button>
                <button class="btn console-action-trigger trigger-red-flash" onclick="requestDeletion()">
                    <i class="fas fa-trash me-2"></i> TERMINATE_ACCOUNT_NODE
                </button>
            </div>
        </div>

    </div>
</div>

                <!-- Security Measures -->
                <div class="policy-section terminal-secure-card mb-3" id="security">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('security')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-lock icon-alert-glow me-2"></i> 06 // SECURITY MEASURES
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-security"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-security">
        
        <h4 class="terminal-body-subtitle mb-3"><i class="fas fa-shield-alt me-1"></i> ACTIVE_DEFENSE_PROTOCOLS</h4>
        <div class="security-features terminal-security-grid">
            
            <div class="security-item terminal-sub-well-dark">
                <i class="fas fa-key icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">ENCRYPTION_LAYER</h5>
                <p class="sub-well-text-bright">All data payloads are strictly encrypted during network transit and database rest states.</p>
            </div>
            
            <div class="security-item terminal-sub-well-dark">
                <i class="fas fa-server icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">SECURE_INFRASTRUCTURE</h5>
                <p class="sub-well-text-bright">Hosted exclusively on decentralized, industry-standard hardened processing clusters.</p>
            </div>
            
            <div class="security-item terminal-sub-well-dark">
                <i class="fas fa-fingerprint icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">ACCESS_RESTRICITONS</h5>
                <p class="sub-well-text-bright">Enforced zero-trust validation mechanisms and continuous session authentication checks.</p>
            </div>
            
            <div class="security-item terminal-sub-well-dark">
                <i class="fas fa-sync icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">PATCH_DEPLOYMENT</h5>
                <p class="sub-well-text-bright">Continuous automated telemetry monitoring, integrity evaluation, and threat mitigation updates.</p>
            </div>
            
        </div>
        
    </div>
</div>
                <!-- Interactive Privacy Quiz -->
                <div class="policy-section terminal-secure-card mb-3" id="privacy-quiz">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('privacy-quiz')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-question-circle icon-alert-glow me-2"></i> 07 // PRIVACY KNOWLEDGE QUIZ
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-privacy-quiz"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-privacy-quiz">
        <div class="quiz-container terminal-quiz-wrapper">
            
            <div class="quiz-question active-question" data-question="1">
                <h4 class="terminal-quiz-heading">QUESTION_01 // What data do we log when you run learning nodes?</h4>
                <div class="quiz-options terminal-option-stack">
                    <button class="quiz-option terminal-quiz-btn" data-correct="true">
                        <span class="btn-matrix-tag">[A]</span> Game progress and session scores
                    </button>
                    <button class="quiz-option terminal-quiz-btn" data-correct="false">
                        <span class="btn-matrix-tag">[B]</span> Your localized personal photo directories
                    </button>
                    <button class="quiz-option terminal-quiz-btn" data-correct="false">
                        <span class="btn-matrix-tag">[C]</span> Raw unencrypted bank account details
                    </button>
                </div>
            </div>
            
            <div class="quiz-question" data-question="2" style="display: none;">
                <h4 class="terminal-quiz-heading">QUESTION_02 // Do we monetize or transmit your personal info records?</h4>
                <div class="quiz-options terminal-option-stack">
                    <button class="quiz-option terminal-quiz-btn" data-correct="false">
                        <span class="btn-matrix-tag">[A]</span> Affirmative, shared with third-party advertisers
                    </button>
                    <button class="quiz-option terminal-quiz-btn" data-correct="true">
                        <span class="btn-matrix-tag">[B]</span> Negative, data is insulated and never sold
                    </button>
                    <button class="quiz-option terminal-quiz-btn" data-correct="false">
                        <span class="btn-matrix-tag">[C]</span> Exclusively under localized permission tokens
                    </button>
                </div>
            </div>
            
            <div class="quiz-result terminal-quiz-final" style="display: none;">
                <h4 class="terminal-quiz-heading text-alert-neon"><i class="fas fa-flag-checkered me-2"></i> EVALUATION_COMPLETE!</h4>
                <p class="policy-body-text red-contrast-text">
                    System Diagnostic Results: You successfully verified <span class="quiz-score terminal-score-highlight">0</span> out of 2 privacy protocols.
                </p>
                <button class="btn console-action-trigger trigger-red-flash mt-2" onclick="restartQuiz()">
                    <i class="fas fa-sync-alt me-2"></i> RE-RUN_DIAGNOSTICS
                </button>
            </div>
            
        </div>
    </div>
</div>
                <!-- Action Buttons -->
                <div class="policy-actions">
                    <button class="btn btn-primary" onclick="printPolicy()">
                        <i class="fas fa-print"></i> Print Policy
                    </button>
                    <button class="btn btn-success" onclick="downloadPDF()">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                    <button class="btn btn-info" onclick="sharePolicy()">
                        <i class="fas fa-share"></i> Share Policy
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>

<style>
/*===================================
  Privacy Policy Styling
===================================*/
.privacy-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    min-height: 70vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 0 0 7rem 0;
    padding-top: 0;
}

.back-button-wrapper {
    position: absolute;
    top: 2rem;
    left: 2rem;
    z-index: 10;
}

.back-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-5px);
}

.privacy-title {
    color: white;
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

.privacy-icon {
    display: inline-block;
    animation: float 3s ease-in-out infinite;
    margin: 0 1rem;
}

.privacy-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

/* Floating Elements */
.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.privacy-element {
    position: absolute;
    font-size: 2rem;
    opacity: 0.6;
    animation: float 4s ease-in-out infinite;
}

.privacy-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
.privacy-element:nth-child(2) { top: 60%; left: 80%; animation-delay: 1s; }
.privacy-element:nth-child(3) { top: 30%; left: 70%; animation-delay: 2s; }
.privacy-element:nth-child(4) { top: 70%; left: 20%; animation-delay: 3s; }
.privacy-element:nth-child(5) { top: 40%; left: 90%; animation-delay: 0.5s; }
.privacy-element:nth-child(6) { top: 80%; left: 60%; animation-delay: 1.5s; }
.privacy-element:nth-child(7) { top: 10%; left: 50%; animation-delay: 2.5s; }
.privacy-element:nth-child(8) { top: 50%; left: 30%; animation-delay: 3.5s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Content Styling */
.privacy-content {
    background: var(--bg-primary);
    padding: 4rem 0 7rem 0;
    position: relative;
}

.reading-progress {
    position: sticky;
    top: 0;
    background: var(--nav-bg);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    z-index: 100;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #00A4EF, #4B8BBE);
    width: 0%;
    transition: width 0.3s ease;
}

.policy-section {
    background: var(--nav-bg);
    border-radius: 15px;
    margin-bottom: 2rem;
    overflow: hidden;
    box-shadow: 0 4px 20px var(--shadow-color);
    transition: all 0.3s ease;
}

.policy-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px var(--shadow-color);
}

.section-header {
    background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
    color: white;
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.section-header:hover {
    background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary));
}

.section-header h2 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.section-content {
    padding: 2rem;
    display: none;
}

.policy-section.active .section-content {
    display: block;
}

.policy-section.active .toggle-icon {
    transform: rotate(180deg);
}

.policy-highlight {
    background: rgba(0, 164, 239, 0.1);
    border-left: 4px solid var(--accent-primary);
    padding: 1rem;
    margin: 1rem 0;
    border-radius: 0 10px 10px 0;
}

.collection-methods, .usage-grid, .rights-grid, .security-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 1.5rem 0;
}

.method-card, .usage-item, .right-item, .security-item {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    transition: all 0.3s ease;
}

.method-card:hover, .usage-item:hover, .right-item:hover, .security-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-5px);
}

.method-card i, .usage-item i, .right-item i, .security-item i {
    font-size: 2rem;
    color: var(--accent-primary);
    margin-bottom: 1rem;
}

.sharing-scenarios {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin: 1.5rem 0;
}

.scenario {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

.scenario i {
    font-size: 1.5rem;
}

.control-panel {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 10px;
    margin-top: 1.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

/* Quiz Styling */
.quiz-container {
    background: rgba(255, 255, 255, 0.05);
    padding: 2rem;
    border-radius: 10px;
}

.quiz-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
}

.quiz-option {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
}

.quiz-option:hover {
    background: rgba(255, 255, 255, 0.2);
}

.quiz-option.correct {
    background: rgba(76, 175, 80, 0.3);
    border-color: #e04917;
}

.quiz-option.incorrect {
    background: rgba(244, 67, 54, 0.3);
    border-color: #F44336;
}

.policy-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 3rem;
    flex-wrap: wrap;
}

/* Responsive Design */
@media (max-width: 768px) {
    .privacy-title {
        font-size: 2.5rem;
    }
    
    .back-button-wrapper {
        position: relative;
        top: auto;
        left: auto;
        margin-bottom: 2rem;
    }
    
    .collection-methods, .usage-grid, .rights-grid, .security-features {
        grid-template-columns: 1fr;
    }
    
    .policy-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.min.js"></script>
<script>
// Initialize Rellax
document.addEventListener('DOMContentLoaded', function() {
    new Rellax('.privacy-element', {
        speed: -2,
        vertical: true,
        horizontal: false
    });
    
    // Initialize privacy policy functionality
    initializePrivacyPolicy();
});

function initializePrivacyPolicy() {
    // Section toggles
    document.querySelectorAll('.section-header').forEach(header => {
        header.addEventListener('click', function() {
            const section = this.closest('.policy-section');
            const content = section.querySelector('.section-content');
            
            if (section.classList.contains('active')) {
                section.classList.remove('active');
                content.style.display = 'none';
            } else {
                section.classList.add('active');
                content.style.display = 'block';
            }
        });
    });
    
    // Reading progress
    updateReadingProgress();
    window.addEventListener('scroll', updateReadingProgress);
    
    // Quiz functionality
    initializeQuiz();
}

function updateReadingProgress() {
    const scrollTop = window.pageYOffset;
    const docHeight = document.body.offsetHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    
    document.querySelector('.progress-fill').style.width = scrollPercent + '%';
    document.querySelector('.progress-percentage').textContent = Math.round(scrollPercent) + '%';
}

function initializeQuiz() {
    let currentQuestion = 1;
    let score = 0;
    
    document.querySelectorAll('.quiz-option').forEach(option => {
        option.addEventListener('click', function() {
            const isCorrect = this.getAttribute('data-correct') === 'true';
            const allOptions = this.parentElement.querySelectorAll('.quiz-option');
            
            // Disable all options
            allOptions.forEach(opt => opt.style.pointerEvents = 'none');
            
            // Show correct/incorrect
            allOptions.forEach(opt => {
                if (opt.getAttribute('data-correct') === 'true') {
                    opt.classList.add('correct');
                } else {
                    opt.classList.add('incorrect');
                }
            });
            
            if (isCorrect) score++;
            
            // Next question or show result
            setTimeout(() => {
                if (currentQuestion < 2) {
                    currentQuestion++;
                    showQuestion(currentQuestion);
                } else {
                    showQuizResult();
                }
            }, 1500);
        });
    });
}

function showQuestion(questionNum) {
    document.querySelectorAll('.quiz-question').forEach(q => q.style.display = 'none');
    document.querySelector(`[data-question="${questionNum}"]`).style.display = 'block';
    
    // Reset options
    document.querySelectorAll('.quiz-option').forEach(opt => {
        opt.classList.remove('correct', 'incorrect');
        opt.style.pointerEvents = 'auto';
    });
}

function showQuizResult() {
    document.querySelectorAll('.quiz-question').forEach(q => q.style.display = 'none');
    document.querySelector('.quiz-result').style.display = 'block';
    document.querySelector('.quiz-score').textContent = score;
}

function restartQuiz() {
    location.reload();
}

// Action functions
function exportData() {
    alert('Data export feature will be implemented soon!');
}

function requestDeletion() {
    if (confirm('Are you sure you want to request account deletion? This action cannot be undone.')) {
        alert('Deletion request submitted. We will process your request within 30 days.');
    }
}

function printPolicy() {
    window.print();
}

function downloadPDF() {
    alert('PDF download feature will be implemented soon!');
}

function sharePolicy() {
    if (navigator.share) {
        navigator.share({
            title: 'SkillForge Privacy Policy',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}
</script> 
