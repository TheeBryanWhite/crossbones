<?php

/**
 * Custom Pagination
 *
 * Use without arguments for standard loops, or include arguments to
 * customize pagination inside WP_Queries
 *
 * More info: http://callmenick.com/post/custom-wordpress-loop-with-pagination
 *
 * @param  {String} $numpages  Number of pages returned by our query
 * @param  {String} $pagerange Range of pages that we will display (even number)
 * @param  {String} $paged     The $paged value
 * @return {String}            Pagination HTML
 */

function lauchlan_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)) {
        $pagerange = 2;
    }

    global $paged;

    if (empty($paged)) {
        $paged = 1;
    }

    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if (!$numpages) {
            $numpages = 1;
        }
    }

    $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => True,
        'prev_text'       => __('&laquo;'),
        'next_text'       => __('&raquo;'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
        );

    $paginate_links = paginate_links($pagination_args);

    if ($paginate_links) {
        echo "<div id='pagination' class='pagination'>";
        echo $paginate_links;
        echo "</div>";
    }
}