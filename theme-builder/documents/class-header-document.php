<?php

if (!defined('ABSPATH')) exit;

class Elematic_Header_Document extends \Elementor\Core\DocumentTypes\PageBase {

    public static function get_type() {
        return 'header';
    }

    public static function get_title() {
        return __('Header', 'elematic-addons-for-elementor');
    }

    public static function get_plural_title() {
        return __('Headers', 'elematic-addons-for-elementor');
    }

    public function get_name() {
        return 'header';
    }

    public static function get_properties() {
        $properties = parent::get_properties();

        $properties['cpt'] = ['elematic_template'];
        $properties['support_kit'] = true;
        $properties['support_page_layout'] = false;
        $properties['support_wp_page_templates'] = false;

        return $properties;
    }

    public function get_css_wrapper_selector() {
        return '.elementor.elementor-' . $this->get_main_id();
    }
}
