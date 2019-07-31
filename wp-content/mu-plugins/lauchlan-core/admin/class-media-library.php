<?php

/**
 * Customizes the WordPress media library
 */

class Lauchlan_Core_Media_Library {

    public function __construct() {
        add_filter('upload_mimes', array($this, 'add_mime_types'));
        add_filter('post_mime_types', array($this, 'mime_types_sort'));
        add_filter('wp_handle_upload_prefilter', array($this, 'handle_upload_prefilter'));
        add_filter('media_view_settings', array($this, 'gallery_default_links'));
        add_filter('image_size_names_choose', array($this, 'add_image_insert_override'));
    }

    /**
     *  Allowed file types
     */
    public function add_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    /**
     * Add PDF option to type filter dropdown in Media Library
     */
    public function mime_types_sort($post_mime_types) {
        $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
        return $post_mime_types;
    }

    /**
     * Validate Image Uploads
     *
     * Enforce a maximum file size of 1MB, a maximum image size of 2000px,
     * and only JPG, SVG, GIF, and PNG files.
     */
    public function handle_upload_prefilter($file) {

        $file_dims      = getimagesize($file['tmp_name']);
        $file_width     = $file_dims[0];
        $file_height    = $file_dims[1];
        $max_dims       = array('width' => '2000', 'height' => '2000');

        $file_size      = $file['size'];
        $file_size_mb   = number_format($file_size / (1<<20), 2);

        $file_type      = $file['type'];
        $allowed_images = array('image/jpeg',
                                'image/svg+xml',
                                'image/gif',
                                'image/png');

        // Only process image files
        if (in_array($file_type, $allowed_images)) {

            // No images files larger than 1MB
            if ($file_size > 1000 * 1024)
                return array("error" => "Image size is too large. Maximum image size is 1MB. Uploaded image size is {$file_size_mb}MB.");

            // No images bigger than 2000x2000px
            elseif ($file_width > $max_dims['width'])
                return array("error" => "Image dimensions are too large. Maximum width is {$max_dims['width']}px. Uploaded image width is {$file_width}px.");

            elseif ($file_height > $max_dims['height'])
                return array("error" => "Image dimensions are too large. Maximum height is {$max_dims['height']}px. Uploaded image height is {$file_height}px.");

            else
                return $file;

        } else {

                return $file;

        }

    }

    /**
     * Force gallery images to link to file
     */
    public function gallery_default_links($settings) {
        $settings['galleryDefaults']['link'] = 'file';
        return $settings;
    }

    /**
     * Remove full-size images as an option when placing media
     */
    public function add_image_insert_override($size_names) {
        global $_wp_additional_image_sizes;
        $size_names = array(
            'thumbnail' => 'Thumbnail',
            'medium'    => 'Medium',
            'large'     => 'Large'
        );
        return $size_names;
    }

}


/**
 * Display SVG thumbnails in media library
 */
function lauchlan_display_svg() {
    ob_start();
    add_action('shutdown', 'lauchlan_display_svg_filter', 0);
    add_filter('final_output', 'lauchlan_display_svg_output');
}
add_action('admin_init', 'lauchlan_display_svg');

function lauchlan_display_svg_filter() {
    $final = '';
    $ob_levels = count(ob_get_level());
    for ($i = 0; $i < $ob_levels; $i++) {
        $final .= ob_get_clean();
    }
    echo apply_filters('final_output', $final);
}

function lauchlan_display_svg_output($content) {
    $content = str_replace(
        '<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
        '<# } else if ( \'svg+xml\' === data.subtype ) { #>
            <img class="details-image" src="{{ data.url }}" draggable="false" />
            <# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
        $content
    );
    $content = str_replace(
        '<# } else if ( \'image\' === data.type && data.sizes ) { #>',
        '<# } else if ( \'svg+xml\' === data.subtype ) { #>
            <div class="centered">
                <img src="{{ data.url }}" class="thumbnail" draggable="false" />
            </div>
        <# } else if ( \'image\' === data.type && data.sizes ) { #>',
        $content
    );
    return $content;
}