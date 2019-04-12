<?php
/**
 * Include this Class in functions.php 
 * @return Nav HTML with megamenu
 **/
 
class walkernav extends Walker_Nav_Menu
{

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $hasMegaMenu = in_array('has-megamenu', $classes);


        // start mega menu if found
        if( $hasMegaMenu ) {
        
            // check and get custom fields mega_menu_left
            if( have_rows('mega_menu_left', $item) ) {
                $counter = 1;
                $count = count( get_field('mega_menu_left', $item) );

                $mm_output .= "<div class=\"col-md-9\">\n";

                while( have_rows('mega_menu_left', $item) ): the_row();

                    if( get_row_layout() == 'submenu' ):

                        if( $counter == 1 ):
                            $mm_output .= "<div class=\"row\">\n";
                        endif;                    

                        $mm_output .= "<div class=\"col-sm-4\">\n";

                            if( $counter > 3 ) {
                                $mm_output .= "<div class=\"meg-divider\"></div>\n";
                            }

                            $mm_output .= "<div class=\"meg-item\">\n";
                                $mm_output .= "<h4>\n";

                                    if( get_sub_field('icon') ):
                                        $mm_output .= "<img src=\"". get_stylesheet_directory_uri() ."/assets/images/". get_sub_field('icon') ."\">"; 
                                    endif;

                                $mm_output .= get_sub_field('title') ."</h4>\n";

                        $links = get_sub_field('links');
                        if( $links ):
                            $mm_output .= "<div class=\"mega-links\">\n";

                            foreach ( $links as $link ):
                                $mm_output .= "<p><a href=\"". $link['link_url'] ."\" class=\"blueLinks\" >". $link['link_text'] ."</a></p>\n";
                            endforeach;

                            $mm_output .= "</div>";
                        endif;

                        $mm_output .= "</div>";             

                        if( $counter % 3 == 0 && $counter < $count ):
                            $mm_output .= "</div></div><div class=\"row\">\n";
                        else:
                            $mm_output .= "</div>";
                        endif;   

                        if( $counter == $count ):
                            $mm_output .= "</div>";
                        endif;
                        
                    endif;

                    $counter++;

                endwhile;

                $mm_output .= "</div>";

            }

            // check and get custom fields mega_menu_right
            if( have_rows('mega_menu_right', $item) ) {

                $mm_output .= "<div class=\"col-sm-3\">\n";

                    while( have_rows('mega_menu_right', $item) ): the_row();

                        if( get_row_layout() == 'submenu' ):                  

                            $mm_output .= "<div class=\"col-submenu\">\n";
                                $mm_output .= "<div class=\"meg-item\">\n";
                                    $mm_output .= "<h4>\n";

                                        if( get_sub_field('icon') ):
                                            $mm_output .= "<img src=\"". get_stylesheet_directory_uri() ."/assets/images/". get_sub_field('icon') ."\">"; 
                                        endif;

                                    $mm_output .= get_sub_field('title') ."</h4>\n";

                            $links = get_sub_field('links');
                            if( $links ):
                                $mm_output .= "<div class=\"mega-links\">\n";

                                foreach ( $links as $link ):
                                    $mm_output .= "<p><a href=\"". $link['link_url'] ."\" class=\"blueLinks\" >". $link['link_text'] ."</a></p>\n";
                                endforeach;

                                $mm_output .= "</div>";
                            endif;             

                            $mm_output .= "</div>";
                            
                        endif;

                        if( get_row_layout() == 'asset_card' ):

                            $mm_output .= "<div class=\"resource-module\" onclick=\"window.location.href='". get_sub_field('link') ."'\">\n";

                                $mm_output .= "<div class=\"resource-text-wrapper\">\n";
                                    $mm_output .= "<div class=\"res-image2\">\n";
                                        $mm_output .= "<img src=\"". get_sub_field('image') ."\" class=\"img-fluid\">\n";
                                    $mm_output .= "</div>";

                                    $mm_output .= "<p class=\"uppercase pull-right\"><img src=\"". get_stylesheet_directory_uri() ."/assets/images/". get_sub_field('icon') ."\" style=\"height:24px;\"> ". get_sub_field('icon_title') ."</p>\n";

                                    $mm_output .= "<div class=\"equal_height5\">";
                                        $mm_output .= "<h4><a href=\"". get_sub_field('link') ."\" class=\"animated-arrow\">". get_sub_field('title') ."</a></h4>\n";
                                    $mm_output .= "</div>\n</div>\n";      
                                $mm_output .= "</div>";                     
                        endif;                

                    endwhile;

                $mm_output .= "</div>";                

            }

            $mm_output = "<div class=\"mega-menu\">\n<div class=\"mega-inner\">\n<div class=\"row\">\n". $mm_output ."</div></div></div>";

        } //end mega menu

        if( $hasMegaMenu ) {
            $classes[] = 'has-children';
        }

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="'. esc_attr($class_names) .'"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen($id) ? ' id="'. esc_attr($id) .'"' : '';

        $output .= $indent.'<li'.$id.$value.$class_names.$li_attributes.'>';

        $attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        $attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';
        $attributes .= ($args->has_children) ? ' class="link"' : '';

        $item_output = $args->before;
        $item_output .= '<h4 class="menu-title"><a'. $attributes .'>';

        $item_output .= $args->link_before.apply_filters('the_title', $item->title, $item->ID).$args->link_after;
        $item_output .= '</a></h4>'. $mm_output;
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }


}
