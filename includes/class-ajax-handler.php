<?php
/**
 * AJAX Handler Class
 * Handles all AJAX requests for Elematic widgets
 *
 * @package Elematic
 * @since 1.2
 */

namespace Elematic;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Ajax_Handler {

    /**
     * Constructor
     * Register AJAX actions
     */
    public function __construct() {
        // Load More Posts - for logged in users
        add_action( 'wp_ajax_load_more_posts', array( $this, 'load_more_posts_handler' ) );

        // Load More Posts - for non-logged in users
        add_action( 'wp_ajax_nopriv_load_more_posts', array( $this, 'load_more_posts_handler' ) );
    }

    /**
     * Handle Load More Posts AJAX request
     * Optimized with better error handling and security
     *
     * @since 1.2
     * @return void
     */
    public function load_more_posts_handler() {

        // Read and unslash POST data
        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $post_data = wp_unslash( $_POST );

        /**
         * SECURITY: Verify Nonce
         */
        $nonce = isset( $post_data['nonce'] ) ? sanitize_text_field( $post_data['nonce'] ) : '';

        if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'load_more_nonce' ) ) {
            wp_send_json_error(
                array(
                    'message' => esc_html__( 'Security check failed.', 'elematic-addons-for-elementor' ),
                )
            );
        }

        /**
         * SETTINGS: Parse and sanitize
         */
        $settings_raw = isset( $post_data['settings'] ) ? $post_data['settings'] : '';

        if ( empty( $settings_raw ) ) {
            wp_send_json_error(
                array(
                    'message' => esc_html__( 'Invalid request parameters.', 'elematic-addons-for-elementor' ),
                )
            );
        }

        // Parse settings (handle both string and array)
        if ( is_string( $settings_raw ) ) {
            $settings_json = sanitize_textarea_field( $settings_raw );
            $settings      = json_decode( $settings_json, true );
        } elseif ( is_array( $settings_raw ) ) {
            $settings = $this->sanitize_settings_array( $settings_raw );
        } else {
            $settings = array();
        }

        /**
         * PAGE: Get current page number
         */
        $page = isset( $post_data['page'] ) ? absint( $post_data['page'] ) : 1;

        // Validate we have everything needed
        if ( empty( $settings ) || ! is_array( $settings ) || $page < 1 ) {
            wp_send_json_error(
                array(
                    'message' => esc_html__( 'Invalid request parameters.', 'elematic-addons-for-elementor' ),
                )
            );
        }

        /**
         * BUILD QUERY ARGS
         */
        $query_args = $this->build_query_args( $settings, $page );

        /**
         * RUN QUERY
         */
        $post_query = new \WP_Query( $query_args );

        if ( $post_query->have_posts() ) {
            ob_start();

            while ( $post_query->have_posts() ) {
                $post_query->the_post();

                // Render template based on grid style
                $this->render_post_template( $settings );
            }

            wp_reset_postdata();

            $posts_html = ob_get_clean();

            wp_send_json_success(
                array(
                    'html'        => $posts_html,
                    'page'        => $page,
                    'max_pages'   => (int) $post_query->max_num_pages,
                    'found_posts' => (int) $post_query->found_posts,
                )
            );
        } else {
            wp_send_json_error(
                array(
                    'message' => esc_html__( 'No more posts found.', 'elematic-addons-for-elementor' ),
                )
            );
        }

        wp_die();
    }

    /**
     * Sanitize settings array (recursive for nested arrays)
     *
     * @param array $settings_raw Raw settings array
     * @return array Sanitized settings
     */
    private function sanitize_settings_array( $settings_raw ) {
        $sanitized = array();
        
        foreach ( $settings_raw as $key => $value ) {
            $key = sanitize_key( $key );
            
            if ( is_array( $value ) ) {
                $sanitized[ $key ] = $this->sanitize_settings_array( $value );
            } elseif ( is_string( $value ) ) {
                $sanitized[ $key ] = sanitize_text_field( $value );
            } elseif ( is_numeric( $value ) ) {
                $sanitized[ $key ] = is_int( $value ) ? absint( $value ) : floatval( $value );
            } else {
                $sanitized[ $key ] = $value;
            }
        }
        
        return $sanitized;
    }

    /**
     * Build WP_Query arguments from settings
     *
     * @param array $settings Widget settings
     * @param int $page Current page number
     * @return array Query arguments
     */
    private function build_query_args( $settings, $page ) {
        $post_type = ! empty( $settings['post_type'] ) ? sanitize_key( $settings['post_type'] ) : 'post';

        $query_args = array(
            'post_type'           => $post_type,
            'posts_per_page'      => ! empty( $settings['number_of_posts'] ) ? absint( $settings['number_of_posts'] ) : 3,
            'ignore_sticky_posts' => true,
            'post_status'         => 'publish',
            'paged'               => $page,
        );

        // Sorting
        $post_sortby = ! empty( $settings['post_sortby'] ) ? sanitize_text_field( $settings['post_sortby'] ) : 'latestpost';
        $order       = ! empty( $settings['order'] ) ? sanitize_text_field( $settings['order'] ) : 'DESC';
        $orderby     = ! empty( $settings['orderby'] ) ? sanitize_text_field( $settings['orderby'] ) : 'date';

        if ( 'mostdiscussed' === $post_sortby ) {
            $query_args['orderby'] = 'comment_count';
            $query_args['order']   = $order;
        } else {
            $query_args['orderby'] = $orderby;
            $query_args['order']   = $order;
        }

        // Handle offset (if not on first page)
        if ( ! empty( $settings['offset'] ) ) {
            $offset = absint( $settings['offset'] );
            if ( $page > 1 ) {
                $offset += ( $query_args['posts_per_page'] * ( $page - 1 ) );
            }
            $query_args['offset'] = $offset;
            unset( $query_args['paged'] ); // Can't use both offset and paged
        }

        // Taxonomy query
        if ( ! empty( $settings['tax_query'] ) && is_array( $settings['tax_query'] ) ) {
            $tax_query = $this->build_optimized_tax_query( $settings['tax_query'] );
            if ( ! empty( $tax_query ) ) {
                // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
                $query_args['tax_query'] = $tax_query;
            }
        }

        return $query_args;
    }

    /**
     * Render post template based on grid style
     *
     * @param array $settings Widget settings
     * @return void
     */
    private function render_post_template( $settings ) {
        $grid_style = ! empty( $settings['grid_style'] ) ? sanitize_text_field( $settings['grid_style'] ) : 'style-1';
        
        $template_file = ELEMATIC_PATH . 'widgets/post-grid/templates/' . $grid_style . '.php';

        if ( file_exists( $template_file ) ) {
            // $settings is in scope for the template
            include $template_file;
        }
    }

    /**
     * Build optimized tax_query using term_id instead of slug
     * Groups terms by taxonomy for better performance
     *
     * @param array $tax_queries Array of "taxonomy:term" strings
     * @return array Optimized tax_query array or empty array
     */
    private function build_optimized_tax_query( $tax_queries ) {
        $prepared_tax_query   = array( 'relation' => 'OR' );
        $term_ids_by_taxonomy = array();

        foreach ( $tax_queries as $taxquery ) {
            // Validate format
            if ( ! is_string( $taxquery ) || empty( $taxquery ) || strpos( $taxquery, ':' ) === false ) {
                continue;
            }

            // Parse taxonomy and term
            list( $tax, $term_slug ) = explode( ':', $taxquery, 2 );
            $tax       = trim( sanitize_text_field( $tax ) );
            $term_slug = trim( sanitize_text_field( $term_slug ) );

            // Validate taxonomy and term
            if ( empty( $tax ) || empty( $term_slug ) || ! taxonomy_exists( $tax ) ) {
                continue;
            }

            // Get term object (cached by WordPress)
            $term_obj = get_term_by( 'slug', sanitize_title( $term_slug ), $tax );

            if ( $term_obj && ! is_wp_error( $term_obj ) ) {
                if ( ! isset( $term_ids_by_taxonomy[ $tax ] ) ) {
                    $term_ids_by_taxonomy[ $tax ] = array();
                }
                $term_ids_by_taxonomy[ $tax ][] = (int) $term_obj->term_id;
            }
        }

        // Build optimized tax_query
        foreach ( $term_ids_by_taxonomy as $taxonomy => $term_ids ) {
            if ( ! empty( $term_ids ) ) {
                $prepared_tax_query[] = array(
                    'taxonomy' => sanitize_text_field( $taxonomy ),
                    'field'    => 'term_id',
                    'terms'    => array_map( 'absint', $term_ids ),
                    'operator' => 'IN',
                );
            }
        }

        // Only return if we have valid queries
        if ( count( $prepared_tax_query ) > 1 ) {
            return $prepared_tax_query;
        }

        return array();
    }

    
}