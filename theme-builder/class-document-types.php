<?php

if (!defined('ABSPATH')) exit;

class Elematic_Document_Types {

    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('elementor/documents/register', [$this, 'register_document_types']);
        add_action('init', [$this, 'maybe_migrate_template_types'], 20);
        add_filter('elementor/document/wrapper_attributes', [$this, 'add_location_wrapper_classes'], 10, 2);
    }

    public function add_location_wrapper_classes($attributes, $document) {
        if (!$document) {
            return $attributes;
        }

        $post = $document->get_post();

        if (!$post || $post->post_type !== 'elematic_template') {
            return $attributes;
        }

        $type = $document->get_name();

        if ($type === 'header') {
            $attributes['class'] .= ' elementor-location-header elematic-custom-header';
            $attributes['role'] = 'banner';
        } elseif ($type === 'footer') {
            $attributes['class'] .= ' elementor-location-footer elematic-custom-footer';
            $attributes['role'] = 'contentinfo';
        }

        return $attributes;
    }

    public function register_document_types($documents_manager) {
        require_once ELEMATIC_PATH . 'theme-builder/documents/class-header-document.php';
        require_once ELEMATIC_PATH . 'theme-builder/documents/class-footer-document.php';

        $documents_manager
            ->register_document_type('header', Elematic_Header_Document::class)
            ->register_document_type('footer', Elematic_Footer_Document::class);
    }

    /**
     * Migrate legacy templates that used the generic "page" document type.
     */
    public function maybe_migrate_template_types() {
        if (get_option('elematic_template_doc_types_migrated') === ELEMATIC_VERSION) {
            return;
        }

        $templates = get_posts([
            'post_type'      => 'elematic_template',
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        foreach ($templates as $template_id) {
            $this->sync_template_document_type($template_id);
        }

        update_option('elematic_template_doc_types_migrated', ELEMATIC_VERSION);
    }

    public function sync_template_document_type($template_id) {
        $type = $this->get_template_type_slug($template_id);

        if (!in_array($type, ['header', 'footer'], true)) {
            return;
        }

        update_post_meta($template_id, '_elementor_template_type', $type);
    }

    private function get_template_type_slug($template_id) {
        $terms = wp_get_post_terms($template_id, 'elematic_template_type');

        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms[0]->slug;
        }

        return '';
    }
}
