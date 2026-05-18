<?php
/**
 * ==========================================================
 * File: terms.php
 * 
 * Description:
 *   - Terms of Service page with interactive Rellax background
 *   - Features:
 *       • Floating legal icons and compliance elements
 *       • Expandable content sections
 *       • Interactive acceptance flow
 *       • Terms knowledge quiz
 *       • Version history timeline
 *       • Print/Download options
 *       • Responsive design with accessibility
 * 
 * ==========================================================
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
$pageTitle = 'Terms of Service';

// Include header
include 'includes/header.php';
?>

<!-- Terms of Service Hero Section -->
 <link rel="stylesheet" href="assets/css/TermsV2.css">
<section class="terms-hero terminal-hero-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center positional-index-forced">
                
                <div class="back-button-wrapper mb-4">
                    <a href="anchor.php" class="btn console-action-trigger trigger-red-flash py-2 px-3">
                        <i class="fas fa-arrow-left me-2"></i> BACK_TO_HOME
                    </a>
                </div>
                
                <h1 class="terms-title terminal-hero-title">
                    <i class="fas fa-gavel icon-alert-glow me-3"></i>
                    TERMS_OF_SERVICE_MATRIX
                    <i class="fas fa-gavel icon-alert-glow ms-3"></i>
                </h1>
                
                <p class="terms-subtitle terminal-hero-subtitle mx-auto">
                    Please evaluate these architectural conditions carefully prior to instantiating live connection sessions with SkillForge. Node initialization implies binding agreement to these system terms.
                </p>
                
                <div class="last-updated terminal-meta-badge mt-4">
                    <i class="fas fa-calendar-alt text-alert-neon me-2"></i>
                    <span class="meta-label">LAST_SYSTEM_REVISION:</span> 
                    <span class="meta-date">5/18/2026</span>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="floating-elements terminal-bg-elements">
        <div class="legal-element terminal-glyph" data-rellax-speed="2">/* FILE */</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="-1">&lt;SYS&gt;</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="3">[TRUE]</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="-2">::LOCK::</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="1">#CORE</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="2">//SECURE</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="-3">!CRIT</div>
        <div class="legal-element terminal-glyph" data-rellax-speed="1">&amp;INIT</div>
    </div>
</section>

<!-- Terms of Service Content -->
<section class="terms-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                
                <!-- Progress Indicator -->
                <div class="reading-progress">
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                    <span class="progress-text">Reading Progress: <span class="progress-percentage">0%</span></span>
                </div>

                <!-- Acceptance Flow -->
                    <div class="acceptance-flow">
                        <div class="acceptance-step active" data-step="1">
                            <h3><i class="fas fa-user-check"></i> Step 1: Read the Terms</h3>
                            <p>Please read through all sections below to understand our terms of service.</p>
                        </div>
                        <div class="acceptance-step" data-step="2">
                            <h3><i class="fas fa-question-circle"></i> Step 2: Take the Quiz</h3>
                            <p>Complete a quick quiz to ensure you understand the key terms.</p>
                        </div>
                        <div class="acceptance-step" data-step="3">
                            <h3><i class="fas fa-check-double"></i> Step 3: Accept Terms</h3>
                            <p>Confirm your acceptance of the terms of service.</p>
                        </div>
                    </div>

                <!-- Introduction Section -->
                <div class="terms-section terminal-secure-card fully-expanded" id="introduction">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('introduction')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-info-circle icon-alert-glow me-2"></i> 01 // ACCEPTANCE OF TERMS PROTOCOL
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-introduction"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-introduction">
        <p class="policy-body-text red-contrast-text">Welcome to SkillForge! These Terms of Service ("Terms") govern your operational authorization parameters across our live platform and services. Instantiating connection sessions implies definitive intent to be bound by these criteria.</p>
        <p class="policy-body-text red-contrast-text">If you choose to dissent from these framework terms, terminate your session routing immediately. We reserve the right to recalibrate, modify, or update these rules instantly upon host deployment.</p>
        
        <div class="policy-highlight terminal-danger-well-box my-3">
            <i class="fas fa-exclamation-triangle icon-alert-glow me-2"></i>
            <strong class="danger-strong-text">CRITICAL_CAPACITY_MANDATE:</strong> 
            <span class="danger-body-text">By proceeding on this host, you verify that your operating identity node represents an age threshold of 18+ years and holds the total legal capability to authenticate this agreement.</span>
        </div>
        
        <div class="key-points mt-4">
            <h4 class="terminal-body-subtitle"><i class="fas fa-terminal me-2 text-alert-neon"></i> KEY_COMPLIANCE_POINTS:</h4>
            <ul class="terminal-protocol-list">
                <li><strong class="danger-strong-text">AGE_VERIFICATION:</strong> <span class="list-body-text">Identity node metadata must certify an active status of 18+ years.</span></li>
                <li><strong class="danger-strong-text">ACCOUNT_INSULATION:</strong> <span class="list-body-text">You maintain absolute liability for restricting access keys to your profile.</span></li>
                <li><strong class="danger-strong-text">STATUTORY_COMPLIANCE:</strong> <span class="list-body-text">You swear under system token to commit no malicious network exploits.</span></li>
                <li><strong class="danger-strong-text">TERMINATION_RIGHTS:</strong> <span class="list-body-text">Admin controllers retain system privilege to drop connections for rule updates.</span></li>
            </ul>
        </div>
        
    </div>
</div>

                <!-- User Accounts Section -->
                <div class="terms-section terminal-secure-card mb-3" id="user-accounts">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('user-accounts')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-user-circle icon-alert-glow me-2"></i> 02 // USER ACCOUNTS &amp; REGISTRATION
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-user-accounts"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-user-accounts">
        
        <h4 class="terminal-body-subtitle"><i class="fas fa-terminal me-2 text-alert-neon"></i> IDENTITY_NODE_CREATION</h4>
        <p class="policy-body-text red-contrast-text">To gain access to specialized platform testing instances, you must register a unique operator profile. You pledge to submit authentic, current, and verified data values across all directory fields during registration.</p>
        
        <div class="account-requirements terminal-usage-grid mt-3 mb-4">
            <div class="requirement-card terminal-sub-well-dark">
                <i class="fas fa-user-plus icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">REGISTRATION_METRICS</h5>
                <p class="sub-well-text-bright">Provide an authenticated email routing destination and profile identifier token.</p>
            </div>
            <div class="requirement-card terminal-sub-well-dark">
                <i class="fas fa-shield-alt icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">CREDENTIAL_PROTECTION</h5>
                <p class="sub-well-text-bright">Isolate and protect your administrative password access keys from all network nodes.</p>
            </div>
            <div class="requirement-card terminal-sub-well-dark">
                <i class="fas fa-edit icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">SCHEMA_MAINTENANCE</h5>
                <p class="sub-well-text-bright">Instantly refresh registered profile arrays if real-world operator data varies.</p>
            </div>
        </div>
        
        <h4 class="terminal-body-subtitle"><i class="fas fa-terminal me-2 text-alert-neon"></i> ACCOUNT_RESPONSIBILITIES</h4>
        <ul class="terminal-protocol-list">
            <li><strong class="danger-strong-text">RUNTIME_LIABILITY:</strong> <span class="list-body-text">You handle full liability for all calculations and commands executed under your identifier.</span></li>
            <li><strong class="danger-strong-text">BREACH_NOTIFICATION:</strong> <span class="list-body-text">Alert security controllers immediately upon discovering credential leak vulnerabilities.</span></li>
            <li><strong class="danger-strong-text">CREDENTIAL_ISOLATION:</strong> <span class="list-body-text">You are forbidden from proxying or distributing your access tokens to unauthorized third parties.</span></li>
            <li><strong class="danger-strong-text">MULTIPLEX_RESTRICTION:</strong> <span class="list-body-text">Generating duplicate secondary accounts for malicious load routing is strictly blocked.</span></li>
        </ul>
    </div>
</div>

<div class="terms-section terminal-secure-card mb-3" id="acceptable-use">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('acceptable-use')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-handshake icon-alert-glow me-2"></i> 03 // ACCEPTABLE USE POLICY
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-acceptable-use"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-acceptable-use">
        
        <div class="use-policy-grid terminal-split-dashboard">
            
            <div class="policy-item allowed terminal-sub-well-dark border-green-glow">
                <h5 class="sub-well-title text-success-neon"><i class="fas fa-check-circle me-2"></i> PERMITTED_OPERATIONS</h5>
                <ul class="terminal-protocol-list clean-bullets mt-3">
                    <li><i class="fas fa-chevron-right list-bullet-accent text-success-neon"></i> <span class="list-body-text">Executing, compiling, and analyzing source packages for educational training.</span></li>
                    <li><i class="fas fa-chevron-right list-bullet-accent text-success-neon"></i> <span class="list-body-text">Engaging in live structural debugging sprints and logical challenges.</span></li>
                    <li><i class="fas fa-chevron-right list-bullet-accent text-success-neon"></i> <span class="list-body-text">Distributing peer advice and knowledge streams while respecting structural boundaries.</span></li>
                    <li><i class="fas fa-chevron-right list-bullet-accent text-success-neon"></i> <span class="list-body-text">Fostering a productive development community space for emerging operators.</span></li>
                </ul>
            </div>
            
            <div class="policy-item prohibited terminal-sub-well-dark border-red-glow">
                <h5 class="sub-well-title text-danger-neon"><i class="fas fa-times-circle me-2"></i> PROHIBITED_OPERATIONS</h5>
                <ul class="terminal-protocol-list clean-bullets mt-3">
                    <li><i class="fas fa-ban list-bullet-accent text-danger-neon"></i> <span class="list-body-text">Exploiting logic bugs or using unapproved automated scripting engines to bypass checks.</span></li>
                    <li><i class="fas fa-ban list-bullet-accent text-danger-neon"></i> <span class="list-body-text">Harassing other profile operators or leaking metadata properties.</span></li>
                    <li><i class="fas fa-ban list-bullet-accent text-danger-neon"></i> <span class="list-body-text">Transmitting unsafe media components or malicious code files.</span></li>
                    <li><i class="fas fa-ban list-bullet-accent text-danger-neon"></i> <span class="list-body-text">Attempting reverse-engineering exploits or launching Denial of Service actions.</span></li>
                </ul>
            </div>
            
        </div>
        
        <div class="consequences terminal-action-well mt-4">
            <h4 class="terminal-body-subtitle menu-header-border"><i class="fas fa-shield-alt me-2 text-alert-neon"></i> ENFORCEMENT_MITIGATION_SCALES</h4>
            
            <div class="consequence-levels terminal-tier-stack">
                <div class="level terminal-tier-row">
                    <span class="badge-terminal tag-orange">LVL_01 // WARNING</span>
                    <p class="tier-descriptive-text">Applied to initial, low-impact procedural mistakes. System remains green under probationary tracking.</p>
                </div>
                <div class="level terminal-tier-row">
                    <span class="badge-terminal tag-crimson">LVL_02 // SUSPENSION</span>
                    <p class="tier-descriptive-text">Temporary lockdown of session access credentials. Connection drops for a determined observation cycle.</p>
                </div>
                <div class="level terminal-tier-row">
                    <span class="badge-terminal tag-dead">LVL_03 // TERMINATION</span>
                    <p class="tier-descriptive-text">Permanent expulsion of the profile node identity. All tables dropped; host gateways are blacklisted.</p>
                </div>
            </div>
        </div>

    </div>
</div>

                <!-- Intellectual Property Section -->
                <div class="terms-section terminal-secure-card mb-3" id="intellectual-property">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('intellectual-property')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-copyright icon-alert-glow me-2"></i> 04 // INTELLECTUAL PROPERTY RIGHTS
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-intellectual-property"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-intellectual-property">
        
        <div class="ip-rights terminal-usage-grid mb-4">
            
            <div class="ip-item terminal-sub-well-dark">
                <i class="fas fa-code icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">HOST_CONTENT</h5>
                <p class="sub-well-text-bright">SkillForge retains absolute ownership over all source packages, telemetry code architectures, and user interface elements.</p>
            </div>
            
            <div class="ip-item terminal-sub-well-dark">
                <i class="fas fa-user-edit icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">OPERATOR_CONTENT</h5>
                <p class="sub-well-text-bright">You retain proprietary rights to original scripts, custom payloads, and challenge solutions compiled by your node identity.</p>
            </div>
            
            <div class="ip-item terminal-sub-well-dark">
                <i class="fas fa-share-alt icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">SYSTEM_LICENSING</h5>
                <p class="sub-well-text-bright">You grant our host clusters a perpetual, royalty-free operational token to index, display, and process your shared logs.</p>
            </div>
            
        </div>
        
        <div class="copyright-notice terminal-action-well">
            <h4 class="terminal-body-subtitle menu-header-border"><i class="fas fa-shield-alt me-2 text-alert-neon"></i> COPYRIGHT_ENFORCEMENT_NOTICE</h4>
            <p class="policy-body-text red-contrast-text mb-0">
                All materials deployed across SkillForge are insulated under international copyright frameworks. Unauthorized reproduction, decryption, transmission, or engineering of derivative codebases without explicit authorization tokens is strictly forbidden.
            </p>
        </div>
        
    </div>
</div>

<div class="terms-section terminal-secure-card mb-3" id="privacy-data">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('privacy-data')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-user-shield icon-alert-glow me-2"></i> 05 // PRIVACY &amp; DATA PROTECTION
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-privacy-data"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-privacy-data">
        <p class="policy-body-text red-contrast-text">
            Isolating and securing your personal telemetry records is a baseline metric of our core architecture. The harvesting, processing, and distribution arrays for your personal dataset parameters are fully mapped inside our high-priority 
            <a href="privacy.php" class="terminal-matrix-link">PRIVACY_POLICY_MANUAL</a>.
        </p>
        
        <div class="data-usage mt-4">
            <h4 class="terminal-body-subtitle"><i class="fas fa-terminal me-2 text-alert-neon"></i> INTERNAL_DATA_ROUTING_SCHEMAS</h4>
            
            <div class="usage-categories terminal-quad-dashboard mt-3">
                
                <div class="category terminal-sub-well-dark text-center">
                    <i class="fas fa-chart-line icon-alert-glow mb-2"></i>
                    <span class="sub-well-title d-block">METRIC_OPTIMIZATION</span>
                </div>
                
                <div class="category terminal-sub-well-dark text-center">
                    <i class="fas fa-bell icon-alert-glow mb-2"></i>
                    <span class="sub-well-title d-block">SYSTEM_COMMS_ROUTING</span>
                </div>
                
                <div class="category terminal-sub-well-dark text-center">
                    <i class="fas fa-shield-alt icon-alert-glow mb-2"></i>
                    <span class="sub-well-title d-block">THREAT_MITIGATION</span>
                </div>
                
                <div class="category terminal-sub-well-dark text-center">
                    <i class="fas fa-cog icon-alert-glow mb-2"></i>
                    <span class="sub-well-title d-block">PLATFORM_OPERATIONS</span>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
                <!-- Disclaimers Section -->
               <div class="terms-section terminal-secure-card mb-3" id="disclaimers">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('disclaimers')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-exclamation-triangle icon-alert-glow me-2"></i> 06 // DISCLAIMERS &amp; SYSTEM LIMITATIONS
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-disclaimers"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-disclaimers">
        
        <div class="disclaimer-grid terminal-usage-grid mb-4">
            
            <div class="disclaimer-item terminal-sub-well-dark">
                <i class="fas fa-server icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">HOST_AVAILABILITY</h5>
                <p class="sub-well-text-bright">We target a 99.9% uptime coefficient but cannot promise uninterrupted or lag-free packet routing streams.</p>
            </div>
            
            <div class="disclaimer-item terminal-sub-well-dark">
                <i class="fas fa-graduation-cap icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">TRAINING_OUTCOMES</h5>
                <p class="sub-well-text-bright">While learning modules deliver production-grade code arrays, we offer no guarantee of individual competency outcomes.</p>
            </div>
            
            <div class="disclaimer-item terminal-sub-well-dark">
                <i class="fas fa-shield-alt icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">SECURITY_INSULATION</h5>
                <p class="sub-well-text-bright">We enforce robust cryptographic firewalls but cannot promise absolute penetration protection against advanced threats.</p>
            </div>
            
        </div>
        
        <div class="limitation-notice terminal-danger-well-box">
            <h4 class="terminal-body-subtitle text-danger-neon mb-2"><i class="fas fa-gavel me-2"></i> ABSOLUTE_LIABILITY_LIMITATION</h4>
            <p class="policy-body-text red-contrast-text mb-0">
                SkillForge and its controllers shall not be held liable for any indirect, incidental, structural, consequential, or punitive damages, including data loss or compiler corruption, resulting from your connection sessions.
            </p>
        </div>
        
    </div>
</div>

<div class="terms-section terminal-secure-card mb-3" id="termination">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('termination')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-user-times icon-alert-glow me-2"></i> 07 // TERMINATION &amp; SUSPENSION PROTOCOLS
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-termination"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-termination">
        
        <div class="termination-scenarios terminal-tier-stack mb-4">
            
            <div class="scenario terminal-tier-row">
                <span class="badge-terminal tag-orange"><i class="fas fa-user-edit me-2"></i> BY_YOU</span>
                <p class="tier-descriptive-text">Operators retain absolute system clearance to kill their account connection and clear active variables at any time.</p>
            </div>
            
            <div class="scenario terminal-tier-row">
                <span class="badge-terminal tag-crimson"><i class="fas fa-gavel me-2"></i> BY_ADMINS</span>
                <p class="tier-descriptive-text">Administrators reserve root privilege to drop user authorization keys instantly for confirmed policy violations.</p>
            </div>
            
            <div class="scenario terminal-tier-row">
                <span class="badge-terminal tag-dead"><i class="fas fa-clock me-2"></i> DORMANT_FLUSH</span>
                <p class="tier-descriptive-text">Identity nodes remaining completely stale without active authentication for 12+ months are safely purged from standard tables.</p>
            </div>
            
        </div>
        
        <div class="termination-effects terminal-action-well">
            <h4 class="terminal-body-subtitle menu-header-border"><i class="fas fa-skull-crossbones me-2 text-alert-neon"></i> SYSTEM_EFFECTS_OF_DEPROVISIONING</h4>
            <ul class="terminal-protocol-list">
                <li><strong class="danger-strong-text">IMMEDIATE_DEAUTH:</strong> <span class="list-body-text">Instant removal of session tokens and account login permissions.</span></li>
                <li><strong class="danger-strong-text">DATA_SCRUB:</strong> <span class="list-body-text">Purging of internal configuration records, subject to regulatory retention mandates.</span></li>
                <li><strong class="danger-strong-text">PROGRESS_WIPE:</strong> <span class="list-body-text">Irreversible deletion of rank achievements, accumulated scores, and solution sets.</span></li>
                <li><strong class="danger-strong-text">NON_REFUNDABLE:</strong> <span class="list-body-text">Total forfeiture of active commercial tokens or active premium service configurations.</span></li>
            </ul>
        </div>
        
    </div>
</div>

                <!-- Governing Law Section -->
                <div class="terms-section terminal-secure-card mb-3" id="governing-law">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('governing-law')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-balance-scale icon-alert-glow me-2"></i> 08 // GOVERNING LAW &amp; JURISDICTIONAL DISPUTES
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-governing-law"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-governing-law">
        
        <div class="legal-framework terminal-usage-grid">
            
            <div class="framework-item terminal-sub-well-dark">
                <i class="fas fa-map-marker-alt icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">APPLICABLE_STATUTES</h5>
                <p class="sub-well-text-bright">These structural platform terms and connection frameworks are strictly governed by the localized legal codes of <strong class="text-alert-neon">[Jurisdiction]</strong>.</p>
            </div>
            
            <div class="framework-item terminal-sub-well-dark">
                <i class="fas fa-gavel icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">DISPUTE_RESOLUTION</h5>
                <p class="sub-well-text-bright">Any systemic conflict or contractual divergence will be definitively settled under sealed, binding arbitration protocols rather than standard tribunals.</p>
            </div>
            
            <div class="framework-item terminal-sub-well-dark">
                <i class="fas fa-globe icon-alert-glow mb-2"></i>
                <h5 class="sub-well-title">CROSS_BORDER_ROUTING</h5>
                <p class="sub-well-text-bright">International remote network operators access this node under full personal obligation to remain compliant with regional boundary laws.</p>
            </div>
            
        </div>
        
    </div>
</div>

<div class="terms-section terminal-secure-card mb-3" id="terms-quiz">
    
    <div class="section-header terminal-secure-header" onclick="toggleTerminalAccordion('terms-quiz')">
        <h2 class="terminal-secure-title">
            <i class="fas fa-question-circle icon-alert-glow me-2"></i> 09 // MANDATORY TERMS KNOWLEDGE EVALUATION
        </h2>
        <i class="fas fa-chevron-down toggle-icon text-alert-neon" id="icon-terms-quiz"></i>
    </div>
    
    <div class="section-content red-alert-body" id="body-terms-quiz">
        <div class="quiz-container terminal-action-well">
            
            <div class="quiz-question" data-question="1">
                <h4 class="terminal-quiz-query"><span class="text-alert-neon">CRITICAL_EVAL_01 //</span> What is the verified minimum age configuration to access SkillForge instances?</h4>
                <div class="quiz-options terminal-quiz-stack mt-3">
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">13 years old</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="true">18 years old</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">16 years old</button>
                </div>
            </div>
            
            <div class="quiz-question" data-question="2" style="display: none;">
                <h4 class="terminal-quiz-query"><span class="text-alert-neon">CRITICAL_EVAL_02 //</span> What mitigation protocol initiates if you compromise the platform's Acceptable Use Policies?</h4>
                <div class="quiz-options terminal-quiz-stack mt-3">
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">Null sequence; no systemic action is logged.</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="true">Your operator entry node may be temporarily suspended or permanently banned.</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">The profile receives an automated reset exemption token.</button>
                </div>
            </div>
            
            <div class="quiz-question" data-question="3" style="display: none;">
                <h4 class="terminal-quiz-query"><span class="text-alert-neon">CRITICAL_EVAL_03 //</span> Which node entity is held strictly liable for keeping your authentication credentials secure?</h4>
                <div class="quiz-options terminal-quiz-stack mt-3">
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">The central SkillForge firewall array</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="true">You (The Individual Connected Operator)</button>
                    <button class="quiz-option tactical-quiz-btn" data-correct="false">The regional upstream internet gateway provider</button>
                </div>
            </div>
            
            <div class="quiz-result text-center py-3" style="display: none;">
                <div class="icon-alert-glow display-4 mb-2"><i class="fas fa-terminal"></i></div>
                <h4 class="terminal-body-subtitle text-white">EVALUATION SEQUENCE TERMINATED</h4>
                <p class="policy-body-text red-contrast-text">Compliance metrics output: <span class="quiz-score text-alert-neon fw-bold">0</span> out of 3 protocol matrices correctly verified.</p>
                <button class="btn tactical-action-trigger mt-2" onclick="restartQuiz()"><i class="fas fa-sync-alt me-2"></i> RE-INITIALIZE EVALUATION</button>
            </div>
            
        </div>
    </div>
</div>

                <!-- Version History -->
                <div class="terms-section gaming-ui" id="version-history">
    <div class="section-header" data-section="version-history">
        <h2>
            <i class="fas fa-gamepad header-glow-icon"></i> 
            <span>PATCH NOTES <span class="sub-title">// SYSTEM_LOG</span></span>
        </h2>
        <div class="toggle-container">
            <i class="fas fa-chevron-down toggle-icon"></i>
        </div>
    </div>
    
    <div class="section-content">
        <div class="version-timeline">
            <!-- Current Active Patch -->
            <div class="version-item current">
                <div class="version-date-wrapper">
                    <span class="status-badge pulse-anim">LIVE</span>
                    <div class="version-date">March - 18 - 2026</div>
                </div>
                <div class="version-content-box">
                    <h5>PATCH v2.1 <span class="accent-text">[CURRENT_BUILD]</span></h5>
                    <ul class="patch-list">
                        <li>Updated privacy and data protection terms</li>
                        <li>Added new acceptable use policies</li>
                        <li>Enhanced user rights and control sections</li>
                    </ul>
                </div>
            </div>

            <!-- Legacy Patch 2.0 -->
            <div class="version-item legacy">
                <div class="version-date-wrapper">
                    <div class="version-date">March - 18 - 2026</div>
                </div>
                <div class="version-content-box">
                    <h5>PATCH v2.0</h5>
                    <ul class="patch-list">
                        <li>Major restructuring of terms</li>
                        <li>Added intellectual property section</li>
                        <li>Updated termination policies</li>
                    </ul>
                </div>
            </div>

            <!-- Legacy Patch 1.0 -->
            <div class="version-item legacy">
                <div class="version-date-wrapper">
                    <div class="version-date">March - 18 - 2026</div>
                </div>
                <div class="version-content-box">
                    <h5>PATCH v1.0 <span class="alpha-text">[BASE_BUILD]</span></h5>
                    <ul class="patch-list">
                        <li>Initial terms of service</li>
                        <li>Basic user agreement</li>
                        <li>Privacy policy integration</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

                <!-- Final Acceptance -->
                <div class="final-acceptance">
                    <div class="acceptance-box">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="acceptTerms" class="accept-checkbox">
                            <label for="acceptTerms" class="accept-label">
                                <i class="fas fa-check"></i>
                                <span>I have read, understood, and agree to the Terms of Service</span>
                            </label>
                        </div>
                        <div class="acceptance-actions">
                            <button class="btn btn-success" id="acceptButton" disabled onclick="acceptTerms()">
                                <i class="fas fa-check-double"></i> Accept Terms
                            </button>
                            <button class="btn btn-outline-secondary" onclick="declineTerms()">
                                <i class="fas fa-times"></i> Decline
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="terms-actions">
                    <button class="btn btn-primary" onclick="printTerms()">
                        <i class="fas fa-print"></i> Print Terms
                    </button>
                    <button class="btn btn-success" onclick="downloadPDF()">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                    <button class="btn btn-info" onclick="shareTerms()">
                        <i class="fas fa-share"></i> Share Terms
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
  Terms of Service Styling
===================================*/
.terms-hero {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
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

.terms-title {
    color: white;
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

.terms-icon {
    display: inline-block;
    animation: float 3s ease-in-out infinite;
    margin: 0 1rem;
}

.terms-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

.last-updated {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    display: inline-block;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}

.last-updated i {
    margin-right: 0.5rem;
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

.legal-element {
    position: absolute;
    font-size: 2rem;
    opacity: 0.6;
    animation: float 4s ease-in-out infinite;
}

.legal-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
.legal-element:nth-child(2) { top: 60%; left: 80%; animation-delay: 1s; }
.legal-element:nth-child(3) { top: 30%; left: 70%; animation-delay: 2s; }
.legal-element:nth-child(4) { top: 70%; left: 20%; animation-delay: 3s; }
.legal-element:nth-child(5) { top: 40%; left: 90%; animation-delay: 0.5s; }
.legal-element:nth-child(6) { top: 80%; left: 60%; animation-delay: 1.5s; }
.legal-element:nth-child(7) { top: 10%; left: 50%; animation-delay: 2.5s; }
.legal-element:nth-child(8) { top: 50%; left: 30%; animation-delay: 3.5s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Content Styling */
.terms-content {
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
    background: linear-gradient(90deg, #2c3e50, #34495e);
    width: 0%;
    transition: width 0.3s ease;
}

/* Acceptance Flow */
.acceptance-flow {
    background: var(--nav-bg);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px var(--shadow-color);
}

.acceptance-step {
    display: none;
    text-align: center;
}

.acceptance-step.active {
    display: block;
}

.acceptance-step h3 {
    color: var(--accent-primary);
    margin-bottom: 1rem;
}

.acceptance-step i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

/* Terms Sections */
.terms-section {
    background: var(--nav-bg);
    border-radius: 15px;
    margin-bottom: 2rem;
    overflow: hidden;
    box-shadow: 0 4px 20px var(--shadow-color);
    transition: all 0.3s ease;
}

.terms-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px var(--shadow-color);
}

.section-header {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.section-header:hover {
    background: linear-gradient(135deg, #34495e, #2c3e50);
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

.terms-section.active .section-content {
    display: block;
}

.terms-section.active .toggle-icon {
    transform: rotate(180deg);
}

.terms-highlight {
    background: rgba(44, 62, 80, 0.1);
    border-left: 4px solid #2c3e50;
    padding: 1rem;
    margin: 1rem 0;
    border-radius: 0 10px 10px 0;
}

.key-points ul {
    list-style: none;
    padding: 0;
}

.key-points li {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.key-points li:before {
    content: "•";
    color: var(--accent-primary);
    font-weight: bold;
    margin-right: 0.5rem;
}

/* Grid Layouts */
.account-requirements, .use-policy-grid, .ip-rights, .disclaimer-grid, .legal-framework {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin: 1.5rem 0;
}

.requirement-card, .policy-item, .ip-item, .disclaimer-item, .framework-item {
    background: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    transition: all 0.3s ease;
}

.requirement-card:hover, .ip-item:hover, .disclaimer-item:hover, .framework-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-5px);
}

.policy-item.allowed {
    border-left: 4px solid #27ae60;
}

.policy-item.prohibited {
    border-left: 4px solid #e74c3c;
}

.requirement-card i, .policy-item i, .ip-item i, .disclaimer-item i, .framework-item i {
    font-size: 2rem;
    color: var(--accent-primary);
    margin-bottom: 1rem;
}

/* Consequence Levels */
.consequence-levels {
    display: flex;
    gap: 1rem;
    margin: 1rem 0;
}

.level {
    flex: 1;
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

.level-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.level-badge.warning {
    background: #f39c12;
    color: white;
}

.level-badge.suspension {
    background: #e67e22;
    color: white;
}

.level-badge.termination {
    background: #e74c3c;
    color: white;
}

/* Usage Categories */
.usage-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
}

.category {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
}

.category i {
    color: var(--accent-primary);
    font-size: 1.2rem;
}

/* Scenarios */
.termination-scenarios, .sharing-scenarios {
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

/* Version Timeline */
.version-timeline {
    position: relative;
    padding-left: 2rem;
}

.version-timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--accent-primary);
}

.version-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 2rem;
}

.version-item::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0.5rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--accent-primary);
}

.version-item.current::before {
    background: #27ae60;
    box-shadow: 0 0 10px #27ae60;
}

.version-date {
    font-weight: bold;
    color: var(--accent-primary);
    margin-bottom: 0.5rem;
}

.version-content h5 {
    margin-bottom: 0.5rem;
}

.version-content ul {
    margin: 0;
    padding-left: 1rem;
}

/* Final Acceptance */
.final-acceptance {
    background: var(--nav-bg);
    border-radius: 15px;
    padding: 2rem;
    margin: 3rem 0;
    text-align: center;
    box-shadow: 0 4px 20px var(--shadow-color);
}

.acceptance-box {
    max-width: 600px;
    margin: 0 auto;
}

.checkbox-wrapper {
    margin-bottom: 2rem;
}

.accept-checkbox {
    display: none;
}

.accept-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.accept-label:hover {
    background: rgba(255, 255, 255, 0.1);
}

.accept-label i {
    font-size: 1.5rem;
    color: #ccc;
    transition: all 0.3s ease;
}

.accept-checkbox:checked + .accept-label {
    background: rgba(39, 174, 96, 0.1);
    border: 2px solid #27ae60;
}

.accept-checkbox:checked + .accept-label i {
    color: #27ae60;
    transform: scale(1.2);
}

.acceptance-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
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
    background: rgba(39, 174, 96, 0.3);
    border-color: #27ae60;
}

.quiz-option.incorrect {
    background: rgba(231, 76, 60, 0.3);
    border-color: #e74c3c;
}

.terms-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 3rem;
    flex-wrap: wrap;
}

/* Links */
.terms-link {
    color: var(--accent-primary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.terms-link:hover {
    color: var(--accent-secondary);
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .terms-title {
        font-size: 2.5rem;
    }
    
    .back-button-wrapper {
        position: relative;
        top: auto;
        left: auto;
        margin-bottom: 2rem;
    }
    
    .account-requirements, .use-policy-grid, .ip-rights, .disclaimer-grid, .legal-framework {
        grid-template-columns: 1fr;
    }
    
    .terms-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .acceptance-actions {
        flex-direction: column;
    }
    
    .consequence-levels {
        flex-direction: column;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.min.js"></script>
<script>
// Initialize Rellax
document.addEventListener('DOMContentLoaded', function() {
    new Rellax('.legal-element', {
        speed: -2,
        vertical: true,
        horizontal: false
    });
    
    // Initialize terms functionality
    initializeTerms();
});

function initializeTerms() {
    // Section toggles
    document.querySelectorAll('.section-header').forEach(header => {
        header.addEventListener('click', function() {
            const section = this.closest('.terms-section');
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
    
    // Acceptance checkbox
    document.getElementById('acceptTerms').addEventListener('change', function() {
        document.getElementById('acceptButton').disabled = !this.checked;
    });
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
                if (currentQuestion < 3) {
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

// Acceptance functions
function acceptTerms() {
    if (document.getElementById('acceptTerms').checked) {
        // Show success animation
        const button = document.getElementById('acceptButton');
        button.innerHTML = '<i class="fas fa-check"></i> Terms Accepted!';
        button.classList.remove('btn-success');
        button.classList.add('btn-secondary');
        button.disabled = true;
        
        // Store acceptance in localStorage
        localStorage.setItem('termsAccepted', new Date().toISOString());
        
        // Show success message
        setTimeout(() => {
            alert('Thank you for accepting our Terms of Service! You can now fully access SkillForge.');
        }, 500);
    }
}

function declineTerms() {
    if (confirm('Declining the Terms of Service will limit your access to SkillForge. Are you sure?')) {
        alert('You have declined the Terms of Service. Some features may be limited.');
    }
}

// Action functions
function printTerms() {
    window.print();
}

function downloadPDF() {
    alert('PDF download feature will be implemented soon!');
}

function shareTerms() {
    if (navigator.share) {
        navigator.share({
            title: 'SkillForge Terms of Service',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}
</script> 
