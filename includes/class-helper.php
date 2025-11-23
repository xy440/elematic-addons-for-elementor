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




}