<?php
/*
 * generator Breadcrumbs
*/
function generator_custom_breadcrumbs() {
    $online_courses_showonhome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $online_courses_showcurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    global $post;
    if (is_home() || is_front_page()) {

        if ($online_courses_showonhome == 1)
            echo '<div id="crumbs" class="font-14 color-fff conter-text generator-breadcrumb"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'generator') . '</a></div>';
    } else {

        echo '<div id="crumbs" class="font-14 color-fff conter-text generator-breadcrumb"><a href="' . esc_url(home_url('/')). '">' . esc_html__('Home', 'generator') . '</a> ';
        if (is_category()) {
            $online_courses_thisCat = get_category(get_query_var('cat'), false);
            if ($online_courses_thisCat->parent != 0)
                echo esc_html(get_category_parents($online_courses_thisCat->parent, TRUE, ' '));
            echo  '/ '.esc_html__('Archive by category', 'generator') . ' " ' . single_cat_title('', false) . ' "';
        } elseif (is_search()) {
            echo  '/ '.esc_html__('Search Results For ', 'generator') . ' " ' . get_search_query() . ' "';
        } elseif (is_day()) {
            echo '/ '.'<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo '/ '.'<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F') ). '</a> ';
            echo  '/ <span>'.esc_html(get_the_time('d')).'</span>';
        } elseif (is_month()) {
            echo '/ '.'<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo  '/ <span>'.esc_html(get_the_time('F')).'</span>' ;
        } elseif (is_year()) {
            echo '/ <span>'.esc_html(get_the_time('Y')).'</span>' ;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $online_courses_post_type = get_post_type_object(get_post_type());
                $online_courses_slug = $online_courses_post_type->rewrite;
                echo '<a href="' . esc_url(home_url('/'. $online_courses_slug['slug'] . '/')) .'">' . esc_html($online_courses_post_type->labels->singular_name) . '</a>';
                if ($online_courses_showcurrent == 1)
                    echo  esc_html(get_the_title()) ;
            } else {
                $online_courses_cat = get_the_category();
                $online_courses_cat = $online_courses_cat[0];
                $online_courses_cats = get_category_parents($online_courses_cat, TRUE, ' ');
                if ($online_courses_showcurrent == 0)
                    $online_courses_cats =
                            preg_replace("#^(.+)\s\s$#", "$1", $online_courses_cats);
                echo '/ '.$online_courses_cats;
                if ($online_courses_showcurrent == 1)
                    echo  '/ <span>'.esc_html(get_the_title()).'</span>';
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $online_courses_post_type = get_post_type_object(get_post_type());
            echo esc_html($online_courses_post_type->labels->singular_name );
        } elseif (is_attachment()) {
            $online_courses_parent = get_post($post->post_parent);
            $online_courses_cat = get_the_category($online_courses_parent->ID);
            $online_courses_cat = $online_courses_cat[0];
            echo esc_html(get_category_parents($online_courses_cat, TRUE, '  '));
            echo '<a href="' . esc_url(get_permalink($online_courses_parent)) . '">' . esc_html($online_courses_parent->post_title) . '</a>';
            if ($online_courses_showcurrent == 1)
                echo   esc_html(get_the_title());
        } elseif (is_page() && !$post->post_parent) {
            if ($online_courses_showcurrent == 1)
                echo '/ <span>'.esc_html(get_the_title()).'</span>';
        } elseif (is_page() && $post->post_parent) {
            $online_courses_parent_id = $post->post_parent;
            $online_courses_breadcrumbs = array();
            while ($online_courses_parent_id) {
                $online_courses_page = get_page($online_courses_parent_id);
                $online_courses_breadcrumbs[] = '<a href="' . get_permalink($online_courses_page->ID) . '">' . get_the_title($online_courses_page->ID) . '</a>';
                $online_courses_parent_id = $online_courses_page->post_parent;
            }
            $online_courses_breadcrumbs = array_reverse($online_courses_breadcrumbs);
            for ($online_courses_i = 0; $online_courses_i < count($online_courses_breadcrumbs); $online_courses_i++) {
                echo esc_html($online_courses_breadcrumbs[$online_courses_i]);
                if ($online_courses_i != count($online_courses_breadcrumbs) - 1)
                    echo ' ';
            }
            if ($online_courses_showcurrent == 1)
                echo '/ <span>'.get_the_title().'</span>';
        } elseif (is_tag()) {
            echo  esc_html__('Posts tagged', 'generator') . ' " ' . esc_html(single_tag_title('', false)) . ' "';
        } elseif (is_author()) {
            global $author;
            $online_courses_userdata = get_userdata($author);
            echo  esc_html__('Articles Published by', 'generator') . ' " ' . esc_html($online_courses_userdata->display_name ). ' "';
        } elseif (is_404()) {
            echo esc_html__('Error 404', 'generator') ;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo esc_html__('Page', 'generator') . ' ' . esc_html(get_query_var('paged'));
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }
        echo '</div>';
    }
} // end generator_custom_breadcrumbs()
