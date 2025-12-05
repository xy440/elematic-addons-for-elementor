<?php
namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Helper {

    /**
     * Returns a list of valid HTML tags for controls.
     *
     * @return string[]
     */
    public static function elematic_html_tags() {
        return [
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'Span',
            'p'    => 'P',
        ];
    }

    /**
     * Safely render a heading or text container element.
     *
     * @param string $tag   The HTML tag (h1–h6, div, span, p).
     * @param string $text  The text/content inside the tag.
     * @param array  $attrs Optional associative array of extra attributes.
     */
    public static function elematic_render_heading( $tag, $text, $attrs = [] ) {
        // Whitelist of allowed tags (matches Helper::elematic_html_tags)
        $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];

        // Fallback to <div> if invalid
        $tag = in_array( strtolower( $tag ), $allowed_tags, true ) ? $tag : 'div';

        // Build attributes string
        $attr_string = '';
        foreach ( $attrs as $key => $value ) {
            $attr_string .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
        }

        // Render output
        printf(
            '<%1$s%3$s>%2$s</%1$s>',
            esc_attr( $tag ),
            esc_html( $text ),
            $attr_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Attributes are already escaped
        );
    }


    /**
     * Get All Post Types
     * @return array
     */
    static function get_all_post_types() {
        $post_types = get_post_types( [ 'public' => true, 'show_in_nav_menus' => true ] );
        $exclude_post_types = [ 'elementor_library', 'attachment', 'product', 'lp_course', 'lp_lesson', 'lp_quiz', 'give_forms' ];

        foreach ( $exclude_post_types as $exclude_cpt ) {
            unset( $post_types[ $exclude_cpt ] );
        }

        /**
         * Filter the list of allowed post types
         */
        return apply_filters( 'elematic_get_all_post_types', $post_types );
    }


    /**
     * Get all categories (terms) across taxonomies using get_terms().
     *
     * This version is safer and cache-friendly compared to direct SQL.
     * It respects WordPress's built-in caching and taxonomy APIs.
     * @param array|string $taxonomies Optional. List of taxonomy names, or 'all' to fetch all public taxonomies. Default null (auto-detect).
     * @param array        $args       Optional. Extra query args for get_terms().
     *
     * @return array Associative array of terms in the format:
     *               taxonomy:slug => "taxonomy: Label"
     */
    static function get_all_categories( $taxonomies = null, $args = [] ) {

        // Determine taxonomies
        if ( is_null( $taxonomies ) ) {
            $taxonomies = get_taxonomies(
                [ 'public' => true, 'show_ui' => true ],
                'names'
            );
            // Exclude taxonomies not useful for UI
            $taxonomies = array_diff( $taxonomies, [ 'nav_menu', 'link_category', 'post_format' ] );
        }

        // Merge default args
        $query_args = wp_parse_args( $args, [
            'taxonomy'   => $taxonomies,
            'hide_empty' => false,  // Show all terms
            'fields'     => 'all',
        ] );

        $terms = get_terms( $query_args );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return [];
        }

        $results = [];
        foreach ( $terms as $t ) {
            $key   = "{$t->taxonomy}:{$t->slug}";
            $label = "{$t->taxonomy}: {$t->name}";
            $results[ $key ] = $label;
        }

        return $results;
    }

    /**
     * Trim the current post title to a specific character length without breaking words.
     *
     * @param int $charlength Maximum number of characters allowed.
     * @return string Trimmed title string.
     */
    static function title_length( $charlength ) {
        $title = get_the_title();

        // Edge case: no title or empty string
        if ( empty( $title ) ) {
            return '';
        }

        // Ensure $charlength is an integer
        $charlength = (int) $charlength;

        // Add one char buffer (as in your original)
        $charlength++;

        // Only trim if title is longer than allowed
        if ( mb_strlen( $title ) > $charlength ) {
            // Get substring
            $subex = mb_substr( $title, 0, $charlength );

            // Avoid cutting in the middle of a word
            $words   = explode( ' ', $subex );
            $last    = end( $words );
            $excut   = -( mb_strlen( $last ) );

            if ( $excut < 0 ) {
                $subex = mb_substr( $subex, 0, $excut );
            }

            // Return trimmed title with ellipsis
            return rtrim( $subex ) . '…';
        }

        // Title fits, return as-is
        return $title;
    }


    /**
     * Truncate the post excerpt to a given number of words.
     *
     * This helper retrieves the current post's excerpt, strips HTML tags,
     * and shortens it to a maximum number of words. If the excerpt is
     * longer than the limit, an optional ending (e.g. "...") is appended.
     *
     * @since 1.0.0
     *
     * @param int    $limit  The maximum number of words to keep.
     * @param string $ending Optional. String to append if truncated. Default '...'.
     *
     * @return string The truncated excerpt, escaped for safe output.
     */
    public static function excerpt_limit( $limit, $ending = '...' ) {
        $excerpt = wp_strip_all_tags( get_the_excerpt(), true );
        $words   = preg_split( '/\s+/', $excerpt );

        if ( count( $words ) > $limit ) {
            $excerpt = implode( ' ', array_slice( $words, 0, $limit ) ) . $ending;
        } else {
            $excerpt = implode( ' ', $words );
        }

        return esc_html( $excerpt );
    }


    /**
     * Display post categories with icon.
     * Properly escaped for security.
     * 
     * @return string HTML markup for categories
     */
    public static function elematic_category() {
        if ( has_category() ) {
            // Get categories as array of objects for better control
            $categories = get_the_category();
            
            if ( ! empty( $categories ) ) {
                $output = '<span class="elematic-post-category">';
                $output .= '<i class="fas fa-bookmark"></i> ';
                
                $category_links = array();
                foreach ( $categories as $category ) {
                    $category_links[] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( get_category_link( $category->term_id ) ),
                        esc_html( $category->name )
                    );
                }
                
                $output .= implode( ', ', $category_links );
                $output .= '</span>';
                
                return $output;
            }
        }
        
        return '';
    }


    /**
     * Display post comments count with Elementor icon.
     */
    public static function elematic_comments() {
        $count = get_comments_number();

        if ( $count >= 1 ) {
            return sprintf(
                '<span class="elematic-post-meta-comments"><i class="fas fa-comment"></i> %d</span>',
                esc_html( $count )
            );
        }

        return '';
    }

    /**
     * Get the post author name with a link to their archive page.
     *
     * Returns the author’s display name wrapped in a link to their author
     * archive, along with an icon. Can be used in post meta templates
     * or combined with other markup.
     *
     * @since 1.0.0
     *
     * @return string The HTML markup for the author meta.
     */
    public static function elematic_author() {
        $author_url  = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) );
        $author_name = esc_html( get_the_author() );

        $html  = '<span class="nickname">';
        $html .= '<i class="fas fa-user"></i> ';
        $html .= '<a href="' . $author_url . '">' . $author_name . '</a>';
        $html .= '</span>';

        return $html;
    }

    /**
     * Get the post publish date with icon markup, honoring WP date format.
     *
     * Uses the site's date format (Settings → General) for display and W3C format
     * for the datetime attribute. Includes a Font Awesome calendar icon.
     *
     * @since 1.0.0
     *
     * @return string HTML for the post date.
     */
    public static function elematic_date() {
        // Display format follows the site's "date_format" option when no format is passed.
        $display_date = get_the_date(); // same as get_the_date( get_option('date_format') )
        $w3c_date     = get_the_date( DATE_W3C );

        $html  = '<span class="elematic-post-meta-date">';
        $html .= '<i class="fas fa-calendar-alt" aria-hidden="true"></i> ';
        $html .= '<time datetime="' . esc_attr( $w3c_date ) . '">';
        $html .= esc_html( $display_date );
        $html .= '</time></span>';

        return $html;
    }


  // Pagination Numbering
  public static function elematic_pagination_number($numpages = '', $pagerange = '', $paged='') {
      if (empty($pagerange)) {
        $pagerange = 2;
      }
      global $paged;
      if (empty($paged)) {
        $paged = 1;
      }
      if(is_front_page()) {
          $paged = (get_query_var('page')) ? get_query_var('page') : 1;
      } else {
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      }
      if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages) {
            $numpages = 1;
        }
      }

       
      /** 
       * We construct the pagination arguments to enter into our paginate_links
       * function. 
       */
      $prev_arrow = is_rtl() ? '<span class="elementor-screen-only">Next</span><i class="fas fa-arrow-right"></i>' : '<span class="elementor-screen-only">Prev</span><i class="fas fa-arrow-left"></i>';
      $next_arrow = is_rtl() ? '<span class="elementor-screen-only">Prev</span><i class="fzas fa-arrow-left"></i>' : '<span class="elementor-screen-only">Next</span><i class="fas fa-arrow-right"></i>';
      $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => true,
        'prev_text'       => $prev_arrow,
        'next_text'       => $next_arrow,
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
      );
      $paginate_links = paginate_links($pagination_args);
      if ($paginate_links) {
        echo "<nav class='elematic-pagination'>";
        echo wp_kses_post($paginate_links); 
        echo "</nav>";
      }
    }

    /**
     * Get all SVG shapes dynamically from the image-mask directory.
     *
     * @return array Array of shape options for the image chooser control.
     */
    public static function elematic_get_svg_shapes() {
        
        // Check if transient exists for caching
        $cached_shapes = get_transient( 'elematic_svg_shapes_cache' );
        if ( false !== $cached_shapes && is_array( $cached_shapes ) ) {
            return $cached_shapes;
        }
        
        $shapes = array();
        $shapes_dir = ELEMATIC_PATH . 'assets/images/image-mask/';
        $shapes_url = ELEMATIC_URL . 'assets/images/image-mask/';
        
        // Check if directory exists
        if ( ! is_dir( $shapes_dir ) ) {
            return $shapes;
        }
        
        // Get all SVG files from the directory
        $svg_files = glob( $shapes_dir . 'shape-*.svg' );
        
        if ( empty( $svg_files ) ) {
            return $shapes;
        }
        
        // Sort files naturally (shape-1, shape-2, ..., shape-10, etc.)
        natsort( $svg_files );
        
        foreach ( $svg_files as $svg_file ) {
            $filename = basename( $svg_file, '.svg' );
            
            // Extract shape number from filename (e.g., "shape-1" from "shape-1.svg")
            if ( preg_match( '/^shape-(\d+)$/', $filename, $matches ) ) {
                $shape_number = $matches[1];
                $shape_key = $filename;
                
                $shapes[ $shape_key ] = array(
                    'title'      => sprintf(
                        /* translators: %s: shape number */
                        esc_html__( 'Shape %s', 'elematic-addons-for-elementor' ),
                        $shape_number
                    ),
                    'imagesmall' => $shapes_url . $filename . '.svg',
                    'width'      => '25%',
                );
            }
        }
        
        // Cache the shapes for 24 hours (DAY_IN_SECONDS)
        set_transient( 'elematic_svg_shapes_cache', $shapes, DAY_IN_SECONDS );
        
        return $shapes;
    }

    /**
     * Clear shapes cache when needed.
     * Call this function when you add/remove shape files.
     */
    public static function clear_svg_shapes_cache() {
        delete_transient( 'elematic_svg_shapes_cache' );
    }

    /**
     *  Get Contact Form 7 forms list
     */
    public static function elematic_contact_form_seven() {
        $wpcf7_form_list = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'showposts' => -1,
        ));
        $options = array();
        $options[0] = esc_html__( 'Select a Contact Form', 'elematic-addons-for-elementor' );
        if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) {
            foreach ( $wpcf7_form_list as $post ) {
                $options[ $post->ID ] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__( 'Create a Form First', 'elematic-addons-for-elementor' );
        }
        return $options;
    }


    /**
     * Build WP_Query arguments for post widgets
     * 
     * @param array $settings Widget settings from Elementor
     * @param int $paged Current page number
     * @return array WP_Query arguments
     */
    public static function setup_query_args( $settings, $paged = 1 ) {
        
        // Get posts per page and offset
        $posts_per_page = isset( $settings['number_of_posts'] ) ? absint( $settings['number_of_posts'] ) : 6;
        $offset = isset( $settings['offset'] ) ? absint( $settings['offset'] ) : 0;
        
        // Calculate offset for pagination
        // CRITICAL: When using offset with pagination, we must account for both
        // Formula: total_offset = initial_offset + (posts_per_page * (current_page - 1))
        $calculated_offset = $offset;
        if ( $paged > 1 && $offset > 0 ) {
            $calculated_offset = $offset + ( $posts_per_page * ( $paged - 1 ) );
        }
        
        // Handle orderby based on post_sortby setting
        if ( isset( $settings['post_sortby'] ) && 'mostdiscussed' === $settings['post_sortby'] ) {
            $query_args = [
                'orderby'               => 'comment_count',
                'order'                 => isset( $settings['order'] ) ? $settings['order'] : 'DESC',
                'ignore_sticky_posts'   => true,
                'post_status'           => 'publish',
                'posts_per_page'        => $posts_per_page,
            ];
        } else {
            $query_args = [
                'orderby'               => isset( $settings['orderby'] ) ? $settings['orderby'] : 'date',
                'order'                 => isset( $settings['order'] ) ? $settings['order'] : 'DESC',
                'ignore_sticky_posts'   => true,
                'post_status'           => 'publish',
                'posts_per_page'        => $posts_per_page,
            ];
        }
        
        // Add offset or paged parameter
        // IMPORTANT: Don't use both 'offset' and 'paged' together - they conflict
        if ( $calculated_offset > 0 ) {
            $query_args['offset'] = $calculated_offset;
        } else {
            $query_args['paged'] = $paged;
        }
        
        // Add post type if specified
        if ( ! empty( $settings['post_type'] ) ) {
            $query_args['post_type'] = $settings['post_type'];
        }
        
        // Handle taxonomy query
        if ( ! empty( $settings['tax_query'] ) && is_array( $settings['tax_query'] ) ) {
            $tax_queries = $settings['tax_query'];
            $prepared_tax_query = [ 'relation' => 'OR' ];
            $term_ids_by_taxonomy = [];
            
            foreach ( $tax_queries as $taxquery ) {
                if ( ! is_string( $taxquery ) || empty( $taxquery ) || strpos( $taxquery, ':' ) === false ) {
                    continue;
                }
                
                list( $tax, $term_slug ) = explode( ':', $taxquery, 2 );
                $tax = trim( $tax );
                $term_slug = trim( $term_slug );
                
                if ( empty( $tax ) || empty( $term_slug ) || ! taxonomy_exists( $tax ) ) {
                    continue;
                }
                
                $term_obj = get_term_by( 'slug', sanitize_title( $term_slug ), $tax );
                
                if ( $term_obj && ! is_wp_error( $term_obj ) ) {
                    if ( ! isset( $term_ids_by_taxonomy[$tax] ) ) {
                        $term_ids_by_taxonomy[$tax] = [];
                    }
                    $term_ids_by_taxonomy[$tax][] = (int) $term_obj->term_id;
                }
            }
            
            foreach ( $term_ids_by_taxonomy as $taxonomy => $term_ids ) {
                if ( ! empty( $term_ids ) ) {
                    $prepared_tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term_ids,
                        'operator' => 'IN',
                    ];
                }
            }
            
            if ( count( $prepared_tax_query ) > 1 ) {
                // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
                $query_args['tax_query'] = $prepared_tax_query;
            }
        }
        
        return $query_args;
    }

    /**
     * Fix pagination count when offset is used
     * 
     * @param WP_Query $query The WP_Query object
     * @param array $settings Widget settings
     * @return WP_Query Modified query object
     */
    public static function fix_query_offset_pagination( $query, $settings ) {
        $offset = isset( $settings['offset'] ) ? absint( $settings['offset'] ) : 0;
        
        if ( $offset > 0 && $query->found_posts > 0 ) {
            $posts_per_page = isset( $settings['number_of_posts'] ) ? absint( $settings['number_of_posts'] ) : 6;
            $adjusted_found_posts = $query->found_posts - $offset;
            
            if ( $adjusted_found_posts < 0 ) {
                $adjusted_found_posts = 0;
            }
            
            $query->max_num_pages = ceil( $adjusted_found_posts / $posts_per_page );
        }
        
        return $query;
    }

    /**
     * Get current page number
     * 
     * @return int Current page number
     */
    public static function get_current_page() {
        if ( get_query_var( 'paged' ) ) {
            return get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) {
            return get_query_var( 'page' );
        }
        return 1;
    }

        /**
     * Render pagination - universal function for all post widgets
     * 
     * @param array $settings Widget settings
     * @param WP_Query $query The WP_Query object
     * @param string $widget_id Unique widget ID
     * @param int $paged Current page number
     */
    public static function render_pagination( $settings, $query, $widget_id, $paged = 1 ) {
        
        if ( empty( $settings['pagination'] ) || 'show' !== $settings['pagination'] ) {
            return;
        }
        
        $pagination_style = isset( $settings['pagination_style'] ) ? $settings['pagination_style'] : 'loadmore';
        
        if ( 'loadmore' === $pagination_style ) {
            self::render_load_more_button( $settings, $query, $widget_id );
        } elseif ( 'numbering' === $pagination_style ) {
            self::elematic_pagination_number( $query->max_num_pages, '', $paged );
        }
    }

    

    /**
     * Render Load More button with minimal, optimized data
     * 
     * @param array $settings Widget settings
     * @param WP_Query $query The WP_Query object
     * @param string $widget_id Unique widget ID
     */
    public static function render_load_more_button( $settings, $query, $widget_id ) {
        
        // Get button text with fallbacks
        $load_more_text = isset( $settings['load_more_text'] ) && ! empty( $settings['load_more_text'] ) 
            ? $settings['load_more_text'] 
            : esc_html__( 'Load More', 'elematic-addons-for-elementor' );
        
        $loading_text = isset( $settings['loading_text'] ) && ! empty( $settings['loading_text'] ) 
            ? $settings['loading_text'] 
            : esc_html__( 'Loading...', 'elematic-addons-for-elementor' );
        
        $no_more_text = isset( $settings['no_more_text'] ) && ! empty( $settings['no_more_text'] ) 
            ? $settings['no_more_text'] 
            : esc_html__( 'No more posts', 'elematic-addons-for-elementor' );
        
        // Create minimal settings - ONLY essentials
        $minimal_settings = self::get_minimal_ajax_settings( $settings );
        
        // Create security nonce - matches Ajax_Handler expectation
        $nonce = wp_create_nonce( 'load_more_nonce' );
        
        // Encode to JSON
        $settings_json = wp_json_encode( $minimal_settings );
        
        ?>
        <div id="elematic_pagination_load_more" class="elematic-load-more">
            <button 
                id="elematic-load-more-btn-<?php echo esc_attr( $widget_id ); ?>" 
                class="elematic-load-more-btn" 
                type="button" 
                data-widget-id="<?php echo esc_attr( $widget_id ); ?>"
                data-nonce="<?php echo esc_attr( $nonce ); ?>"
                data-loading-text="<?php echo esc_attr( $loading_text ); ?>" 
                data-load-more-text="<?php echo esc_attr( $load_more_text ); ?>" 
                data-no-more-text="<?php echo esc_attr( $no_more_text ); ?>" 
                data-settings='<?php echo esc_attr( $settings_json ); ?>' 
                data-page="1"
                data-max-pages="<?php echo esc_attr( $query->max_num_pages ); ?>">
                <?php echo esc_html( $load_more_text ); ?>
            </button>
        </div>
        <?php
    }


    /**
     * Get minimal settings for AJAX - ONLY what's needed
     * This reduces HTML size by 60-70%
     * 
     * @param array $settings Full widget settings
     * @return array Minimal settings array
     */
    private static function get_minimal_ajax_settings( $settings ) {
        return [
            // === Query Parameters ===
            'post_type'       => $settings['post_type'] ?? 'post',
            'number_of_posts' => absint( $settings['number_of_posts'] ?? 5 ),
            'offset'          => absint( $settings['offset'] ?? 0 ),
            'order'           => $settings['order'] ?? 'DESC',
            'orderby'         => $settings['orderby'] ?? 'date',
            'post_sortby'     => $settings['post_sortby'] ?? 'latestpost',
            'tax_query'       => $settings['tax_query'] ?? [], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
            
            // === Layout ===
            'grid_style'      => $settings['grid_style'] ?? 'style-1',
            'image_size'      => $settings['image_size'] ?? 'medium',
            
            // === Display Toggles (for template rendering) ===
            'date'            => $settings['date'] ?? 'show',
            'author'          => $settings['author'] ?? 'show',
            'title'           => $settings['title'] ?? 'show',
            'title_lenth'     => absint( $settings['title_lenth'] ?? 50 ),
            'post_category'   => $settings['post_category'] ?? 'hide',
            'comments'        => $settings['comments'] ?? 'show',
            'desc'            => $settings['desc'] ?? 'show',
            'excerpt_words'   => absint( $settings['excerpt_words'] ?? 15 ),
            'read_more'       => $settings['read_more'] ?? 'show',
            'read_more_txt'   => $settings['read_more_txt'] ?? 'Read More',
        ];
    }

    /**
     * Sanitize settings for AJAX/JSON output
     * Removes unnecessary data to reduce payload size
     * Includes ALL settings needed for query AND rendering posts
     * 
     * @param array $settings Full settings array
     * @param array $additional_keys Additional keys to include beyond defaults (optional)
     * @return array Filtered settings
     */
    public static function sanitize_settings_for_ajax( $settings, $additional_keys = [] ) {
        
        // Essential keys needed for AJAX query and rendering
        $essential_keys = [
            // Query parameters
            'post_type',
            'number_of_posts',
            'offset',
            'tax_query',
            'order',
            'orderby',
            'post_sortby',
            
            // Layout/Style
            'grid_style',      // Grid style (style-1, style-2, etc.)
            'columns',         // Column layout
            
            // Image settings
            'image_size',      // Thumbnail size
            
            // Content visibility toggles
            'date',            // Show/hide date
            'author',          // Show/hide author
            'title',           // Show/hide title
            'title_lenth',     // Title character limit (typo from original, keeping for compatibility)
            'post_category',   // Show/hide category
            'comments',        // Show/hide comments count
            'desc',            // Show/hide excerpt
            'excerpt_words',   // Excerpt word limit
            'read_more',       // Show/hide read more button
            'read_more_txt',   // Read more button text
        ];
        
        // Merge with any additional widget-specific keys
        if ( ! empty( $additional_keys ) ) {
            $essential_keys = array_merge( $essential_keys, $additional_keys );
        }
        
        // Remove duplicates
        $essential_keys = array_unique( $essential_keys );
        
        // Filter settings to only include essential keys
        return array_filter( $settings, function( $key ) use ( $essential_keys ) {
            return in_array( $key, $essential_keys, true );
        }, ARRAY_FILTER_USE_KEY );
    }


    /**
     * Returns a list of CSS timing-function options for controls.
     *
     * @return string[] Array of [slug => label], e.g. 'ease-in' => 'Ease In'.
     */
    public static function elematic_animation_timings() {
        return [
            'ease-default'      => esc_html__( 'Default',        'elematic-addons-for-elementor' ),
            'linear'            => esc_html__( 'Linear',         'elematic-addons-for-elementor' ),
            'ease-in'           => esc_html__( 'Ease In',        'elematic-addons-for-elementor' ),
            'ease-out'          => esc_html__( 'Ease Out',       'elematic-addons-for-elementor' ),
            'ease-in-out'       => esc_html__( 'Ease In Out',    'elematic-addons-for-elementor' ),
            'ease-in-quad'      => esc_html__( 'Ease In Quad',   'elematic-addons-for-elementor' ),
            'ease-in-cubic'     => esc_html__( 'Ease In Cubic',  'elematic-addons-for-elementor' ),
            'ease-in-quart'     => esc_html__( 'Ease In Quart',  'elematic-addons-for-elementor' ),
            'ease-in-quint'     => esc_html__( 'Ease In Quint',  'elematic-addons-for-elementor' ),
            'ease-in-sine'      => esc_html__( 'Ease In Sine',   'elematic-addons-for-elementor' ),
            'ease-in-expo'      => esc_html__( 'Ease In Expo',   'elematic-addons-for-elementor' ),
            'ease-in-circ'      => esc_html__( 'Ease In Circ',   'elematic-addons-for-elementor' ),
            'ease-in-back'      => esc_html__( 'Ease In Back',   'elematic-addons-for-elementor' ),
            'ease-out-quad'     => esc_html__( 'Ease Out Quad',  'elematic-addons-for-elementor' ),
            'ease-out-cubic'    => esc_html__( 'Ease Out Cubic', 'elematic-addons-for-elementor' ),
            'ease-out-quart'    => esc_html__( 'Ease Out Quart', 'elematic-addons-for-elementor' ),
            'ease-out-quint'    => esc_html__( 'Ease Out Quint', 'elematic-addons-for-elementor' ),
            'ease-out-sine'     => esc_html__( 'Ease Out Sine',  'elematic-addons-for-elementor' ),
            'ease-out-expo'     => esc_html__( 'Ease Out Expo',  'elematic-addons-for-elementor' ),
            'ease-out-circ'     => esc_html__( 'Ease Out Circ',  'elematic-addons-for-elementor' ),
            'ease-out-back'     => esc_html__( 'Ease Out Back',  'elematic-addons-for-elementor' ),
            'ease-in-out-quad'  => esc_html__( 'Ease In-Out Quad','elematic-addons-for-elementor' ),
            'ease-in-out-cubic' => esc_html__( 'Ease In-Out Cubic','elematic-addons-for-elementor' ),
            'ease-in-out-quart' => esc_html__( 'Ease In-Out Quart','elematic-addons-for-elementor' ),
            'ease-in-out-quint' => esc_html__( 'Ease In-Out Quint','elematic-addons-for-elementor' ),
            'ease-in-out-sine'  => esc_html__( 'Ease In-Out Sine','elematic-addons-for-elementor' ),
            'ease-in-out-expo'  => esc_html__( 'Ease In-Out Expo','elematic-addons-for-elementor' ),
            'ease-in-out-circ'  => esc_html__( 'Ease In-Out Circ','elematic-addons-for-elementor' ),
            'ease-in-out-back'  => esc_html__( 'Ease In-Out Back','elematic-addons-for-elementor' ),
        ];
    }



}