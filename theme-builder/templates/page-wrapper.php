<?php
/**
 * Page Wrapper Template
 * This replaces the entire page when custom header/footer is active
 * Location: theme-builder/templates/page-wrapper.php
 */

if (!defined('ABSPATH')) exit;

/**
 * =================================================================
 * Helper Functions - Define FIRST before template output
 * =================================================================
 */

if (!function_exists('elematic_render_single_content')) {
    /**
     * Render single page/post content
     * Handles both Elementor and standard WordPress content
     */
    function elematic_render_single_content() {
        // Check if it's using Elementor
        if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID())) {
            // Render Elementor content
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor content is already sanitized
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display(get_the_ID());
        } else {
            // Standard WordPress content
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                // Show title only if it's not the front page
                if (!is_front_page() && get_the_title()) {
                    ?>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        
                        <?php if (is_single() && 'post' === get_post_type()) : ?>
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date()); ?>
                                    </time>
                                </span>
                                <span class="byline">
                                    <?php esc_html_e('by', 'elematic-addons-for-elementor'); ?>
                                    <span class="author vcard">
                                        <?php the_author(); ?>
                                    </span>
                                </span>
                            </div>
                        <?php endif; ?>
                    </header>
                    <?php
                }
                ?>
                
                <?php if (has_post_thumbnail() && is_single()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'elematic-addons-for-elementor'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
                
                <?php if (is_single() && get_the_tags()) : ?>
                    <footer class="entry-footer">
                        <?php the_tags('<div class="tags-links"><span class="tags-title">' . esc_html__('Tags:', 'elematic-addons-for-elementor') . '</span> ', ', ', '</div>'); ?>
                    </footer>
                <?php endif; ?>
            </article>
            <?php
            
            // If comments are open or there's at least one comment
            if ((comments_open() || get_comments_number()) && !is_front_page()) {
                comments_template();
            }
        }
    }
}

if (!function_exists('elematic_render_archive_content')) {
    /**
     * Render blog post excerpt for archives
     */
    function elematic_render_archive_content() {
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <header class="entry-header">
                <?php
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
                
                if ('post' === get_post_type()) {
                    ?>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                        </span>
                        <span class="byline">
                            <?php esc_html_e('by', 'elematic-addons-for-elementor'); ?>
                            <span class="author vcard">
                                <?php the_author(); ?>
                            </span>
                        </span>
                    </div>
                    <?php
                }
                ?>
            </header>

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="read-more">
                    <?php esc_html_e('Read More', 'elematic-addons-for-elementor'); ?>
                    <span class="screen-reader-text"><?php echo esc_html(get_the_title()); ?></span>
                </a>
            </footer>
        </article>
        <?php
    }
}

if (!function_exists('elematic_render_no_content')) {
    /**
     * Render "no content found" message
     */
    function elematic_render_no_content() {
        ?>
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Nothing Found', 'elematic-addons-for-elementor'); ?></h1>
            </header>

            <div class="page-content">
                <?php
                if (is_home() && current_user_can('publish_posts')) {
                    printf(
                        '<p>' . wp_kses(
                            /* translators: 1: link to WP admin new post page. */
                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'elematic-addons-for-elementor'),
                            array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )
                        ) . '</p>',
                        esc_url(admin_url('post-new.php'))
                    );
                } elseif (is_search()) {
                    ?>
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'elematic-addons-for-elementor'); ?></p>
                    <?php
                    get_search_form();
                } else {
                    ?>
                    <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'elematic-addons-for-elementor'); ?></p>
                    <?php
                    get_search_form();
                }
                ?>
            </div>
        </section>
        <?php
    }
}

if (!function_exists('elematic_render_404')) {
    /**
     * Render 404 page
     */
    function elematic_render_404() {
        ?>
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'elematic-addons-for-elementor'); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try searching?', 'elematic-addons-for-elementor'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>
        <?php
    }
}

// Now get the active templates after functions are defined
$elematic_header_id = Elematic_Conditions::instance()->get_active_template('header');
$elematic_footer_id = Elematic_Conditions::instance()->get_active_template('footer');

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!current_theme_supports('title-tag')): ?>
        <title><?php echo esc_html(wp_get_document_title()); ?></title>
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <?php
    // Render Custom Header (if exists)
    if ($elematic_header_id) {
        echo '<header id="masthead" class="site-header elematic-custom-header">';
        Elematic_Renderer::render_template($elematic_header_id);
        echo '</header>';
    }
    ?>

    <!-- Main Content Wrapper -->
    <div id="content" class="site-content">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php
                // Load content based on page type
                if (is_front_page() && is_page()) {
                    // Static front page
                    while (have_posts()) {
                        the_post();
                        elematic_render_single_content();
                    }
                } elseif (is_home()) {
                    // Blog posts index
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            elematic_render_archive_content();
                        }
                        the_posts_navigation();
                    } else {
                        elematic_render_no_content();
                    }
                } elseif (is_singular()) {
                    // Single post/page
                    while (have_posts()) {
                        the_post();
                        elematic_render_single_content();
                    }
                } elseif (is_archive()) {
                    // Archive pages
                    if (have_posts()) {
                        ?>
                        <header class="page-header">
                            <?php
                            the_archive_title('<h1 class="page-title">', '</h1>');
                            the_archive_description('<div class="archive-description">', '</div>');
                            ?>
                        </header>
                        <?php
                        while (have_posts()) {
                            the_post();
                            elematic_render_archive_content();
                        }
                        the_posts_navigation();
                    } else {
                        elematic_render_no_content();
                    }
                } elseif (is_search()) {
                    // Search results
                    if (have_posts()) {
                        ?>
                        <header class="page-header">
                            <h1 class="page-title">
                                <?php
                                printf(
                                    /* translators: %s: search query. */
                                    esc_html__('Search Results for: %s', 'elematic-addons-for-elementor'),
                                    '<span>' . esc_html(get_search_query()) . '</span>'
                                );
                                ?>
                            </h1>
                        </header>
                        <?php
                        while (have_posts()) {
                            the_post();
                            elematic_render_archive_content();
                        }
                        the_posts_navigation();
                    } else {
                        elematic_render_no_content();
                    }
                } elseif (is_404()) {
                    // 404 page
                    elematic_render_404();
                } else {
                    // Fallback for any other page type
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            elematic_render_single_content();
                        }
                    }
                }
                ?>
            </main>
        </div>
    </div>

    <?php
    // Render Custom Footer (if exists)
    if ($elematic_footer_id) {
        echo '<footer id="colophon" class="site-footer elematic-custom-footer">';
        Elematic_Renderer::render_template($elematic_footer_id);
        echo '</footer>';
    }
    ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>