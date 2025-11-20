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



}