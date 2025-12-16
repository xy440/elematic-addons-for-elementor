<?php

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * class-frontend-editor.php (Frontend Edit Buttons)
 * =================================================================
 * 
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
        add_action('wp_footer', [$this, 'enqueue_editor_config']);
    }
    
    public function enqueue_assets() {
        wp_enqueue_style(
            'elematic-frontend-editor',
            ELEMATIC_URL . 'assets/css/frontend-editor.css',
            [],
            ELEMATIC_VERSION
        );
        
        wp_enqueue_script(
            'elematic-frontend-editor',
            ELEMATIC_URL . 'assets/js/frontend-editor.js',
            ['jquery'],
            ELEMATIC_VERSION,
            true
        );
    }
    
    public function render_edit_buttons() {
        // Don't show edit buttons on the template's own edit page
        if (get_post_type() === 'elematic_template') {
            return;
        }
        
        $header_id = Elematic_Conditions::instance()->get_active_template('header');
        $footer_id = Elematic_Conditions::instance()->get_active_template('footer');
        
        ?>
        <div class="elematic-frontend-editor">
            <?php if ($header_id): ?>
                <button class="elematic-edit-btn elematic-edit-header"
                        data-template-id="<?php echo esc_attr($header_id); ?>"
                        data-template-type="header"
                        title="<?php esc_attr_e('Edit Header', 'elematic-addons-for-elementor'); ?>">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M1 13H13" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <?php esc_html_e('Edit Header', 'elematic-addons-for-elementor'); ?>
                </button>
            <?php endif; ?>
            
            <?php if ($footer_id): ?>
                <button class="elematic-edit-btn elematic-edit-footer"
                        data-template-id="<?php echo esc_attr($footer_id); ?>"
                        data-template-type="footer"
                        title="<?php esc_attr_e('Edit Footer', 'elematic-addons-for-elementor'); ?>">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M11 1L13 3L7 9L5 10L6 8L11 1Z" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M1 13H13" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <?php esc_html_e('Edit Footer', 'elematic-addons-for-elementor'); ?>
                </button>
            <?php endif; ?>
        </div>
        
        <?php
    }
    
    private function get_edit_url($post_id) {
        return add_query_arg([
            'post' => $post_id,
            'action' => 'elementor',
        ], admin_url('post.php'));
    }
    
    /**
 * Output JavaScript config for editor detection
 */
public function enqueue_editor_config() {
    $current_post_id = get_the_ID();
    
    // Use Elementor's built-in editor detection if available
    $is_elementor_editor = false;
    if (defined('ELEMENTOR_VERSION') && class_exists('\Elementor\Plugin')) {
        $is_elementor_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
    }
    
    ?>
    <script>
    window.elematicEditorConfig = {
        currentPostId: <?php echo (int) $current_post_id; ?>,
        isElementorEditor: <?php echo $is_elementor_editor ?  'true' : 'false'; ?>
    };
    </script>
    <?php
}


}