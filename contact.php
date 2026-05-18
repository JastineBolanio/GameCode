<?php
/**
 * Contact Page - SkillForge
 * 
 * Description:
 *   - Contact form and information page for users to reach out to the SkillForge team
 *   - Includes a contact form, location map, and contact information
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
$pageTitle = 'Contact Us';

// Include header
include 'includes/header.php';
?>

<!-- Main Content -->
<main class="container py-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-gradient">Get In Touch</h1>
        <p class="lead text">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
    </div>

    <div class="row g-5">
        <!-- Contact Form -->
         <link rel="stylesheet" href="assets/css/ContactV2.css">
        <div class="col-lg-7">
    <div class="card comms-card-ui gaming-ui">
        <!-- Tech corner brackets for HUD aesthetics -->
        <div class="hud-bracket top-left"></div>
        <div class="hud-bracket top-right"></div>
        <div class="hud-bracket bottom-left"></div>
        <div class="hud-bracket bottom-right"></div>

        <div class="card-body p-4 p-md-5">
            <div class="comms-header">
                <h2 class="h4 mb-1">
                    <i class="fas fa-satellite-dish header-glow-icon"></i> 
                    <span>COMMS_TERMINAL <span class="sub-title">// ESTABLISH_LINK</span></span>
                </h2>
                <div class="terminal-status"><span class="status-dot pulse-anim"></span> SECURE_LINE</div>
            </div>
            
            <form id="contactForm" action="/contact/submit" method="POST" class="mt-4">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf->getToken(); ?>">
                
                <div class="row g-4">
                    <!-- Operator Name Input -->
                    <div class="col-md-6">
                        <div class="gaming-input-group">
                            <label for="name" class="input-tag">[OPERATOR_ID]</label>
                            <input type="text" class="gaming-control" id="name" name="name" placeholder="ENTER NAME..." required>
                            <span class="input-bar"></span>
                        </div>
                    </div>
                    
                    <!-- Operator Email Input -->
                    <div class="col-md-6">
                        <div class="gaming-input-group">
                            <label for="email" class="input-tag">[NET_ADDRESS]</label>
                            <input type="email" class="gaming-control" id="email" name="email" placeholder="ENTER EMAIL..." required>
                            <span class="input-bar"></span>
                        </div>
                    </div>
                    
                    <!-- Transmission Subject Input -->
                    <div class="col-12">
                        <div class="gaming-input-group">
                            <label for="subject" class="input-tag">[SIGNAL_HEADER]</label>
                            <input type="text" class="gaming-control" id="subject" name="subject" placeholder="TRANSMISSION SUBJECT..." required>
                            <span class="input-bar"></span>
                        </div>
                    </div>
                    
                    <!-- Encrypted Message Body -->
                    <div class="col-12">
                        <div class="gaming-input-group">
                            <label for="message" class="input-tag">[ENCRYPTED_DATA_PACKET]</label>
                            <textarea class="gaming-control" id="message" name="message" placeholder="COMPILE MESSAGE DATA HERE..." style="height: 140px;" required></textarea>
                            <span class="input-bar"></span>
                        </div>
                    </div>
                    
                    <!-- Protocol Authorization -->
                    <div class="col-12">
                        <div class="form-check custom-gaming-check">
                            <input class="form-check-input gaming-checkbox" type="checkbox" id="privacyPolicy" name="privacyPolicy" required>
                            <label class="form-check-label data-protocol-label" for="privacyPolicy">
                                AUTHORIZE: Data sync matches <a href="privacy.php" class="protocol-link">Core Privacy Protocol</a> & <a href="terms.php" class="protocol-link">Terms of Engagement</a>.
                            </label>
                        </div>
                    </div>
                    
                    <!-- Broadcast Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-gaming-broadcast">
                            <span class="btn-grid-bg"></span>
                            <span class="btn-content">
                                <i class="fas fa-rss-square me-2 flash-anim"></i> BROADCAST SIGNAL
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Contact Information -->
        <div class="col-lg-5">
    <div class="card info-card-ui gaming-ui mb-4">
        <!-- Tech corner brackets for HUD consistency -->
        <div class="hud-bracket top-left"></div>
        <div class="hud-bracket top-right"></div>
        <div class="hud-bracket bottom-left"></div>
        <div class="hud-bracket bottom-right"></div>

        <div class="card-body p-4">
            <h2 class="h4 mb-4 terminal-title">
                <i class="fas fa-network-wired header-glow-icon"></i> 
                <span>INTEL_DATA <span class="sub-title">// CONTACT</span></span>
            </h2>
            
            <!-- Location Block -->
            <div class="d-flex mb-4 intel-block">
                <div class="flex-shrink-0 icon-frame me-3">
                    <i class="fas fa-map-marked-alt icon-glow"></i>
                </div>
                <div>
                    <h3 class="h6 mb-1 intel-header">[HQ_COORDINATES]</h3>
                    <p class="mb-0 intel-text">ICCT Colleges.<br>Institute of Creative Computer Technology</p>
                </div>
            </div>

            <!-- Squad Network (Emails) -->
            <div class="d-flex mb-4 intel-block">
                <div class="flex-shrink-0 icon-frame me-3">
                    <i class="fas fa-users-cog icon-glow"></i>
                </div>
                <div class="w-100">
                    <h3 class="h6 mb-2 intel-header">[SQUAD_NETWORK]</h3>
                    <div class="proponent-grid">
                        <a href="mailto:jastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_01:</span> jastinebolanio2023
                        </a>
                        <a href="mailto:jastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_02:</span> jastinebolanio2023
                        </a>
                        <a href="mailto:jastinebolanio2023@gmail.comjastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_03:</span> jastinebolanio2023
                        </a>
                        <a href="mailto:jastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_04:</span> jastinebolanio2023
                        </a>
                        <a href="mailto:jastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_05:</span> jastinebolanio2023
                        </a>
                        <a href="mailto:jastinebolanio2023@gmail.com" class="proponent-link">
                            <span class="squad-pip status-online"></span> <span class="unit-id">UNIT_06:</span> jastinebolanio2023
                        </a>
                    </div>
                </div>
            </div>

            <!-- Call/Phone Block -->
            <div class="d-flex intel-block">
                <div class="flex-shrink-0 icon-frame me-3">
                    <i class="fas fa-headset icon-glow"></i>
                </div>
                <div>
                    <h3 class="h6 mb-1 intel-header">[COMMS_CHANNEL]</h3>
                    <p class="mb-0">
                        <a href="tel:+6369696767<" class="phone-link freq-anim">+63 69696767</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- Map -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="ratio ratio-16x9">
                    <iframe
                    src="https://www.google.com/maps?q=14.6177068,121.1026223&z=17&output=embed"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Include Footer -->
<?php require_once __DIR__ . '/includes/footer.php'; ?>

<style>
/* Custom styles for contact page */
.text-gradient {
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
}

.form-control, .form-select {
    padding: 1rem 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
}

.form-control:focus, .form-select:focus {
    border-color: #818cf8;
    box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
}

.btn-primary {
    background-color: #4f46e5;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #4338ca;
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .btn-lg {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Add CSRF token
            formData.append('csrf_token', '<?php echo $csrf->getToken(); ?>');
            
            // Show loading state
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success mt-3';
                alert.innerHTML = '<i class="fas fa-check-circle me-2"></i> Your message has been sent successfully!';
                contactForm.appendChild(alert);
                
                // Reset form
                contactForm.reset();
                
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                // Remove success message after 5 seconds
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            }, 1500);
        });
    }
});
</script>
