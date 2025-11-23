<?php 

/**
 * Post Widget Template Style 2
 */

use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="elematic-post-grid-item elematic-img-zoom elematic-post-grid-<?php echo esc_attr( $settings['grid_style'] ); ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
        <?php if($settings['date'] == 'show') : ?>
            <div class="elematic-date-style">
                <span><?php echo esc_html( get_the_date( 'j' ) ); ?></span>
                <small><?php echo esc_html( get_the_date( 'M' ) ); ?></small>
            </div>
        <?php endif; ?>

        <?php if(has_post_thumbnail()) : ?>
            <div class="elematic-post-thumb">
                <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail($settings['image_size']); ?>
                </a>
            </div>

        <?php endif; ?>

        <div class="elematic-post-content">
            <?php if('show' === $settings['title']) : ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                    <h3 class="elematic-post-title"><?php echo esc_html( Helper::title_length($settings['title_lenth']) ); ?></h3>
                </a>
            <?php endif; ?>

            <?php if( 'show' === $settings['author'] || 'show' === $settings['comments'] || 'show' === $post_category ): ?>
                <div class="elematic-post-meta">
                    <?php if( 'show' === $settings['author'] ) : echo wp_kses_post( Helper::elematic_author() ); endif; ?>
                    <?php if( 'show' === $settings['comments'] ) : echo wp_kses_post( Helper::elematic_comments() ); endif; ?>
                    <?php if( 'show' === $settings['post_category'] ): echo wp_kses_post( Helper::elematic_category() ); endif ?>
                </div><!-- .elematic-post-meta -->
            <?php endif; ?>

            <?php if('show' === $settings['desc']) : ?>
                <div class="elematic-excerpt"><?php echo esc_html( Helper::excerpt_limit($settings['excerpt_words']) ); ?></div>
            <?php endif; ?>
            <?php if( 'show' === $settings['read_more'] ): ?>
                <a class="elematic-post-grid-read-more" href="<?php the_permalink(); ?>"><?php echo esc_html( $settings['read_more_txt'] ); ?> <i class="fas fa-arrow-right"></i></a>
            <?php endif; ?>
        </div>
    </article>
</div><!-- style 2 -->