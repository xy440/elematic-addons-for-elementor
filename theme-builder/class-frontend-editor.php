<?php

if (!defined('ABSPATH')) exit;

/**
 * Frontend edit buttons shown inside the Elementor editor preview.
 */
class Elematic_Frontend_Editor {
    
    private static $instance = null;
    
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        if (!current_user_can('edit_posts')) {
            return;
        }
        
        add_action('wp_footer', [$this, 'render_edit_buttons']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_footer', [$this, 'enqueue_editor_config']);
    }
    
    public function enqueue_assets() {
        if (get_post_type() === 'elematic_template') {
            return;
        }

        wp_enqueue_style(
            'elematic-frontend-editor',
            ELEMATIC_URL . 'assets/css/frontend-editor.min.css',
            [],
            ELEMATIC_VERSION
        );
        
        wp_enqueue_script(
            'elematic-frontend-editor',
            ELEMATIC_URL . 'assets/js/frontend-editor.min.js',
            ['jquery'],
            ELEMATIC_VERSION,
            true
        );
    }
    
    public function render_edit_buttons() {
        if (get_post_type() === 'elematic_template') {
            return;
        }
        
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        $page_id   = get_the_ID();
        
        if (!$page_id) {
            return;
        }
        
        ?>
        <div class="elematic-frontend-editor">
            <?php if ($header_id): ?>
                <button type="button" class="elematic-edit-btn elematic-edit-header"
                        data-template-id="<?php echo esc_attr($header_id); ?>"
                        data-template-type="header"
                        title="<?php esc_attr_e('Edit Header', 'elematic-addons-for-elementor'); ?>">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M1 13H13" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <?php esc_html_e('Edit Header', 'elematic-addons-for-elementor'); ?>
                </button>
            <?php endif; ?>

            <button type="button" class="elematic-edit-btn elematic-edit-page"
                    data-template-id="<?php echo esc_attr($page_id); ?>"
                    data-template-type="page"
                    title="<?php esc_attr_e('Edit Page', 'elematic-addons-for-elementor'); ?>">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M1 13H13" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <?php esc_html_e('Edit Page', 'elematic-addons-for-elementor'); ?>
            </button>
            
            <?php if ($footer_id): ?>
                <button type="button" class="elematic-edit-btn elematic-edit-footer"
                        data-template-id="<?php echo esc_attr($footer_id); ?>"
                        data-template-type="footer"
                        title="<?php esc_attr_e('Edit Footer', 'elematic-addons-for-elementor'); ?>">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M1 13H13" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <?php esc_html_e('Edit Footer', 'elematic-addons-for-elementor'); ?>
                </button>
            <?php endif; ?>
        </div>
        <?php
    }
    
    public function enqueue_editor_config() {
        $current_post_id = get_the_ID();
        
        $is_elementor_editor = false;
        if (defined('ELEMENTOR_VERSION') && class_exists('\Elementor\Plugin')) {
            $is_elementor_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
        }
        
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        
        ?>
        <script>
        window.elematicEditorConfig = {
            currentPostId: <?php echo (int) $current_post_id; ?>,
            isElementorEditor: <?php echo $is_elementor_editor ? 'true' : 'false'; ?>,
            headerTemplateId: <?php echo $header_id ? (int) $header_id : 'null'; ?>,
            footerTemplateId: <?php echo $footer_id ? (int) $footer_id : 'null'; ?>
        };
        </script>
        <?php
    }
}
