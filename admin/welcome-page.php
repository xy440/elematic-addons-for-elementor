<?php
if (!defined('ABSPATH')) exit;
?>

<div class="elematic-welcome-page" x-data="{ activeTab: 'getting-started' }">
    <div class="elematic-welcome-header">
        <div class="elematic-welcome-logo">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                <rect width="48" height="48" rx="8" fill="#5C49E3"/>
                <path d="M14 18H34M14 24H34M14 30H28" stroke="white" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <div>
                <h1><?php esc_html_e('Welcome to Elematic', 'elematic-addons-for-elementor'); ?></h1>
                <p><?php esc_html_e('Premium Addons for Elementor', 'elematic-addons-for-elementor'); ?></p>
            </div>
        </div>
        <div class="elematic-welcome-version">
            <span class="version-badge">v<?php echo esc_html( ELEMATIC_VERSION ); ?></span>
        </div>
    </div>

    <div class="elematic-welcome-content">
        <div class="elematic-welcome-tabs">
            <button @click="activeTab = 'getting-started'" 
                    :class="{'active': activeTab === 'getting-started'}"
                    class="elematic-tab-btn">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M10 2L12 8H18L13 12L15 18L10 14L5 18L7 12L2 8H8L10 2Z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <?php esc_html_e('Getting Started', 'elematic-addons-for-elementor'); ?>
            </button>
            <button @click="activeTab = 'features'" 
                    :class="{'active': activeTab === 'features'}"
                    class="elematic-tab-btn">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <rect x="2" y="2" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M6 6H14M6 10H14M6 14H10" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <?php esc_html_e('Features', 'elematic-addons-for-elementor'); ?>
            </button>
        </div>

        <div class="elematic-welcome-tab-content">
            <!-- Getting Started Tab -->
            <div x-show="activeTab === 'getting-started'" class="elematic-tab-panel">
                <div class="elematic-cards-grid">
                    <!-- Theme Builder Card -->
                    <div class="elematic-feature-card elematic-card-primary">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <rect x="4" y="4" width="24" height="24" rx="2" stroke="white" stroke-width="2"/>
                                <path d="M4 10H28M12 4V28" stroke="white" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Theme Builder', 'elematic-addons-for-elementor'); ?></h3>
                        <p><?php esc_html_e('Create custom headers and footers with Elementor. Design once, use everywhere.', 'elematic-addons-for-elementor'); ?></p>
                        <a href="<?php echo esc_url( admin_url('admin.php?page=elematic-theme-builder') ); ?>" class="elematic-btn elematic-btn-primary">
                            <?php esc_html_e('Open Theme Builder', 'elematic-addons-for-elementor'); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Widgets Card -->
                    <div class="elematic-feature-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <rect x="4" y="4" width="10" height="10" rx="1" stroke="currentColor" stroke-width="2"/>
                                <rect x="18" y="4" width="10" height="10" rx="1" stroke="currentColor" stroke-width="2"/>
                                <rect x="4" y="18" width="10" height="10" rx="1" stroke="currentColor" stroke-width="2"/>
                                <rect x="18" y="18" width="10" height="10" rx="1" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('40+ Premium Widgets', 'elematic-addons-for-elementor'); ?></h3>
                        <p><?php esc_html_e('Access a vast collection of powerful widgets to enhance your website design.', 'elematic-addons-for-elementor'); ?></p>
                        <div class="widget-count">
                            <span class="count-badge"><?php esc_html_e('40+', 'elematic-addons-for-elementor'); ?></span>
                            <?php esc_html_e('Widgets Available', 'elematic-addons-for-elementor'); ?>
                        </div>
                    </div>

                    <!-- Documentation Card -->
                    <!-- <div class="elematic-feature-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M8 4H20L24 8V28H8V4Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 12H20M12 16H20M12 20H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3><?php //esc_html_e('Documentation', 'elematic-addons-for-elementor'); ?></h3>
                        <p><?php //esc_html_e('Learn how to use all features with our comprehensive documentation.', 'elematic-addons-for-elementor'); ?></p>
                        <a href="#" class="elematic-btn elematic-btn-secondary" target="_blank">
                            <?php //esc_html_e('View Docs', 'elematic-addons-for-elementor'); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M12 4L4 12M12 4H6M12 4V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div> -->

                    <!-- Support Card -->
                    <div class="elematic-feature-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="2"/>
                                <path d="M16 10V16L20 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Need Help?', 'elematic-addons-for-elementor'); ?></h3>
                        <p><?php esc_html_e('Get support from our friendly team. We\'re here to help you succeed.', 'elematic-addons-for-elementor'); ?></p>
                        <a href="https://wordpress.org/support/plugin/elematic-addons-for-elementor/" class="elematic-btn elematic-btn-secondary" target="_blank">
                            <?php esc_html_e('Get Support', 'elematic-addons-for-elementor'); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M12 4L4 12M12 4H6M12 4V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="elematic-quick-links">
                    <h3><?php esc_html_e('Quick Links', 'elematic-addons-for-elementor'); ?></h3>
                    <div class="quick-links-grid">
                        <a href="<?php echo esc_url( admin_url('admin.php? page=elematic-theme-builder') ); ?>" class="quick-link">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <?php esc_html_e('Create Header', 'elematic-addons-for-elementor'); ?>
                        </a>
                        <a href="<?php echo esc_url( admin_url('admin. php?page=elematic-theme-builder') ); ?>" class="quick-link">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="2" width="12" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <?php esc_html_e('Create Footer', 'elematic-addons-for-elementor'); ?>
                        </a>
                        <a href="<?php echo esc_url( admin_url('edit.php?post_type=page') ); ?>" class="quick-link">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M8 2L10 6H14L11 9L12 14L8 11L4 14L5 9L2 6H6L8 2Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <?php esc_html_e('Edit with Elementor', 'elematic-addons-for-elementor'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Tab -->
            <div x-show="activeTab === 'features'" class="elematic-tab-panel">
                <div class="elematic-features-list">
                    <div class="feature-item">
                        <div class="feature-icon">✨</div>
                        <div class="feature-content">
                            <h4><?php esc_html_e('Theme Builder', 'elematic-addons-for-elementor'); ?></h4>
                            <p><?php esc_html_e('Create custom headers and footers with advanced display conditions', 'elematic-addons-for-elementor'); ?></p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🎨</div>
                        <div class="feature-content">
                            <h4><?php esc_html_e('40+ Premium Widgets', 'elematic-addons-for-elementor'); ?></h4>
                            <p><?php esc_html_e('Advanced widgets for every need - from basic to complex layouts', 'elematic-addons-for-elementor'); ?></p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-content">
                            <h4><?php esc_html_e('Performance Optimized', 'elematic-addons-for-elementor'); ?></h4>
                            <p><?php esc_html_e('Clean code and optimized loading for fast website performance', 'elematic-addons-for-elementor'); ?></p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📱</div>
                        <div class="feature-content">
                            <h4><?php esc_html_e('Fully Responsive', 'elematic-addons-for-elementor'); ?></h4>
                            <p><?php esc_html_e('All widgets and features work perfectly on all devices', 'elematic-addons-for-elementor'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
