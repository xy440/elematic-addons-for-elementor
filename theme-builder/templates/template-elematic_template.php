<?php
/**
 * Template for Elematic Template CPT - Used for Elementor Editing
 * 
 * This template is used specifically when editing Elematic Templates
 * in Elementor editor mode. It provides the_content() that Elementor needs.
 * 
 * We bypass theme header/footer to avoid conflicts with custom header/footer rendering.
 */

if (!defined('ABSPATH')) exit;

// Suppress theme header/footer to avoid conflicts
define('ELEMATIC_EDITING_TEMPLATE', true);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('elematic-template-editor'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php the_content(); ?>
        </main>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
