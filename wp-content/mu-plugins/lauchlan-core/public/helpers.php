<?php

/**
 * Frequently-used Helper Functions
 */

/**
 * Get inline SVG markup
 * @param  string  $file  File name (if ending in /{something}.svg, use that for full path instead of concatenating)
 * @param  boolean $echo  Echo SVG file contents or return if false
 * @param  string  $path  Path of image directory relative to theme's root
 * @return string         Markup of SVG file
 */
function get_inline_svg($file, $echo = true, $path = 'assets/images') {
    if (preg_match('/^(.*?)\/(.*?)\.svg$/i', $file)) {
        $file_path = $file;
    } else {
        $file_path = get_template_directory() . '/' . $path . '/' . $file;
    }

    if (file_exists($file_path)) {
        if ($echo === true) {
            echo file_get_contents($file_path);
        } else {
            return file_get_contents($file_path);
        }
    }
}

/**
 * Returns actual disk path of asset from
 * given absolute URI
 * @param  string $uri Absolute URI
 * @return string      Disk path
 */
function get_local_image_path($uri = false) {
    if ($uri) {
        return ABSPATH . preg_replace('/.*\/\/(.*?)\/(.*?)/', '\2', $uri);
    }
}

/**
 * Create web-friendly slug from any string
 * @param  string $text String to convert
 * @return string       Web-friendly slug
 */
function create_slug($text) {
    // Lower case everything
    $text = strtolower($text);
    // Make alphanumeric (removes all other characters)
    $text = preg_replace("/[^a-z0-9_\s-]/", "", $text);
    // Clean up multiple dashes or whitespaces
    $text = preg_replace("/[\s-]+/", " ", $text);
    // Convert whitespaces and underscore to dash
    $text = preg_replace("/[\s_]/", "-", $text);

    return $text;
}

/**
 * Test if current post is an ancestor of given post ID
 * @param  integer $pid Post ID of parent
 * @return boolean
 */
function is_tree($pid) {
    global $post;
    if (is_page($pid))
        return true;
    $anc = get_post_ancestors($post->ID);
    foreach ($anc as $ancestor) {
        if (is_page() && $ancestor == $pid) {
            return true;
        }
    }
    return false;
}

/**
 * Return post ID of the topmost parent of the current post
 * @return integer Post ID
 */
function get_post_top_ancestor_id() {
    global $post;
    if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    return $post->ID;
}

/**
 * Display the classes for the html element
 * @param string|array $class One or more classes to add to the class list.
 */
function html_class($class = '') {
    echo 'class="no-js ' . join(' ', get_html_class($class)) . '"';
}

/**
 * Retrieve the classes for the html element as an array
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function get_html_class($class = '') {
    $classes = array();

    if (!empty($class)) {
        if (!is_array($class)) {
            $class = preg_split('#\s+#', $class);
        }
        $classes = array_merge($classes, $class);
    } else {
        $class = array();
    }

    $classes = array_map('esc_attr', $classes);

    $classes = apply_filters('html_class', $classes, $class);

	return array_unique($classes);
}
