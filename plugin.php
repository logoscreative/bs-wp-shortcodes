<?php
/*
Plugin Name: Bootstrap Shortcodes
Plugin URI: http://logoscreative.co
Description: Add shortcodes allowing common Bootstrap components to be used in the Visual Editor
Version: 3.0
Author: Cliff Seal
Author URI: http://logoscreative.co
Author Email: cliff@logos-creative.com
*/

/* Helper Function */

function slug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    return $str;
}

/* Collapse: http://twitter.github.com/bootstrap/javascript.html#collapse */

/* [collapse title=null element="h2" open=false][/collapse] */

function bs_collapse_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'title' => '',
                'element' => 'h2',
                'open' => false,
                'plusicon' => true
            ),
            $atts
        )
    );

    $idnum = rand(1,500);
    $open == true ? $open = ' in' : $open = '';
    $plusicon == true ? $plusicon = ' +' : $plusicon = '';

    $collapse_content = "<" . $element . "><a data-toggle='collapse' data-target='#coll" . $idnum . "' class='pointer'>" . $title . $plusicon . "</a></" . $element . "><div id='coll" . $idnum . "' class='collapse" . $open . "'>" . do_shortcode($content) . "</div>";

    return $collapse_content;

}

add_shortcode( 'collapse', 'bs_collapse_func' );

/* Tabs: http://twitter.github.com/bootstrap/javascript.html#tabs */

/* [tabs class=null][/tabs] */

function bs_tabs_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'class' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " " . $class;
    }

    $tabs_content = "<ul class='nav nav-tabs" . $class . "'>" . do_shortcode($content) . "</ul>";

    return $tabs_content;

}

add_shortcode( 'tabs', 'bs_tabs_func' );

/* Tab: http://twitter.github.com/bootstrap/javascript.html#tabs */

/* [tab title="default" active=false class=null icon=null element=null] */

function bs_tab_func($atts) {

    extract(
        shortcode_atts(
            array(
                'title' => 'default',
                'active' => false,
                'class' => '',
                'icon' => '',
                'element' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " " . $class;
    }

    if ( $active == true ) {
        $active = " class='active"  . $class . "'";
    } else {
        $active = " class='" . $class . "'";
    }

    $tab_content = "<li" . $active . ">";

    if ( $element != '' ) {
        $tab_content .= "<" . $element . ">";
    }

    $tab_content .= "<a href='#" . slug($title) . "' data-toggle='tab'>";

    if ( $icon != '' ) {
        $tab_content .= "<i class='icon-" . $icon . " icon-white icon-2x'></i><br />";
    }

    $tab_content .= do_shortcode($title) . "</a>";

    if ( $element != '' ) {
        $tab_content .= "</" . $element . ">";
    }

    $tab_content .= "</li>";

    return $tab_content;

}

add_shortcode( 'tab', 'bs_tab_func' );

/* Tab Content Group: http://twitter.github.com/bootstrap/javascript.html#tabs */

/* [tabcontent-group][/tabcontent-group] */

function bs_tab_content_group_func($atts, $content = null) {

    $tab_content_group_content = "<div class='tab-content'>" . do_shortcode($content) . "</div>";

    return $tab_content_group_content;

}

add_shortcode( 'tabcontent-group', 'bs_tab_content_group_func' );

/* Tab Content: http://twitter.github.com/bootstrap/javascript.html#tabs */

/* [tabcontent title=null class=null active=false fade=false][/tabcontent] */

function bs_tab_content_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'title' => 'default',
                'class' => '',
                'active' => false,
                'fade' => false
            ),
            $atts
        )
    );

    if ( $active == true ) {
        $active = " in active";
    } else {
        $active = "";
    }

    if ( $fade == true ) {
        $fade = " fade";
    } else {
        $fade = "";
    }

    $tab_content = "<div class='tab-pane" . $fade . $active . "' id='" . slug($title) . "'>" . do_shortcode($content) . "</div>";

    return $tab_content;

}

add_shortcode( 'tabcontent', 'bs_tab_content_func' );

/* Buttons: http://twitter.github.com/bootstrap/base-css.html#buttons */

/* [button text=null link=null style=null size=null icon=null iconwhite=false class=null newwindow=false] */

function bs_button_func($atts) {

    extract(
        shortcode_atts(
            array(
                'text' => '',
                'link' => '',
                'style' => '',
                'size' => '',
                'icon' => '',
                'iconwhite' => false,
                'class' => '',
                'newwindow' => false
            ),
            $atts
        )
    );

    if ( $style != '' ) {
        $style = " btn-" . $style;
    }

    if ( $size != '' ) {
        if ( $size == 'mini' ) {
            $size = 'xs';
        } elseif ( $size == 'small' ) {
            $size = 'sm';
        } elseif ( $size == 'large' ) {
            $size = 'lg';
        }
        $size = " btn-" . $size;
    }

    $iconwhite == true ? $iconclr = " icon-white" : $iconclr = "";

    if ( $icon != '' ) {
        $icon = " <i class='icon-" . $icon . $iconclr . "'></i>";
    }

    if ( $class != '' ) {
        $class = " " . $class;
    }

    $newwindow == true ? $newwindow = " target='_blank'" : $newwindow = "";

    if ( $link != '' ) {
        $button_content = "<a href='" . $link . "' class='btn" . $style . $size . $class . "'" . $newwindow . ">" . $text . $icon . "</a>";
    } else {
        $button_content = "<button class='btn" . $style . $size . $class . "'>" . $text . $icon . "</button>";
    }

    return $button_content;

}

add_shortcode( 'button', 'bs_button_func' );

/* Row: http://twitter.github.com/bootstrap/scaffolding.html */

/* [row class=null id=null] */

function bs_row_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'class' => '',
                'rowid' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " " . $class;
    }

    if ( $rowid != '' ) {
        $rowid = " id='" . $rowid . "'";
    }

    $row_content = "<div class='row" . $class . "'" . $rowid . ">" . do_shortcode($content) . "</div>";

    return $row_content;

}

add_shortcode( 'row', 'bs_row_func' );
add_shortcode( 'inner-row', 'bs_row_func' );

/* Span: http://twitter.github.com/bootstrap/scaffolding.html */

/* [span width=12 offset=0 class=null spanid=null] */

function bs_span_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'width' => 12,
                'offset' => 0,
                'class' => '',
                'spanid' => ''
            ),
            $atts
        )
    );

    $offset != '0' ? $offset = " col-md-offset-" . $offset : $offset = "";

    if ( $class != '' ) {
        $class = " " . $class;
    }

    if ( $spanid != '' ) {
        $spanid = " id='" . $spanid . "'";
    }

    $span_content = "<div class='col-md-" . $width . $offset . $class . "'" . $spanid . ">" . do_shortcode($content) . "</div>";

    return $span_content;

}

add_shortcode( 'span', 'bs_span_func' );
add_shortcode( 'inner-span', 'bs_span_func' );
add_shortcode( 'inner-inner-span', 'bs_span_func' );

/* An actual HTML span */

/* [span class=null spanid=null] */

function bs_realspan_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'class' => '',
                'spanid' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " class='" . $class . "'";
    }

    if ( $spanid != '' ) {
        $spanid = " id='" . $spanid . "'";
    }

    $span_content = "<span" . $class . $spanid . ">" . do_shortcode($content) . "</span>";

    return $span_content;

}

add_shortcode( 'realspan', 'bs_realspan_func' );
add_shortcode( 'realinner-span', 'bs_realspan_func' );

/* Home Button */

/* [homebut class=null color=null bg=null] */

function bs_homebut_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'class' => '',
                'color' => '',
                'bg' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " class='" . $class . "'";
    }

    if ( $color != '' || $bg != '' ) {

        if ( $color == '' && $bg != '' ) {
            $style = " style='background:transparent url(" . $bg . ")'";
        } else {
            $style = '';
        }

    } else {
        $style = '';
    }

    $homebut_content = "<h2" . $class . $style . ">" . do_shortcode($content) . "</h2>";

    return $homebut_content;

}

add_shortcode( 'homebut', 'bs_homebut_func' );

/* Button Group: http://twitter.github.com/bootstrap/components.html#buttonGroups */

/* [btngroup class=null][/btngroup] */

function bs_btngrp_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'class' => ''
            ),
            $atts
        )
    );

    if ( $class != '' ) {
        $class = " " . $class;
    }

    $btngrp_content = "<div class='btn-group" . $class . "'>" . do_shortcode($content) . "</div>";

    return $btngrp_content;

}

add_shortcode( 'btngroup', 'bs_btngrp_func' );

/* Hero: http://twitter.github.com/bootstrap/components.html#typography */

/* [hero][/hero] */

function bs_hero_func($atts, $content = null) {

    $hero_content = "<div class='jumbotron'>" . do_shortcode($content) . "</div>";

    return $hero_content;

}

add_shortcode( 'hero', 'bs_hero_func' );

/* Well: http://twitter.github.com/bootstrap/components.html#misc */

/* [well size=null class=null][/well] */

function bs_well_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'size' => false,
                'class' => ''
            ),
            $atts
        )
    );

    if ( $class !== '' ) {
        $class = " " . $class;
    }

    $size != '' ? $size = " well-" . $size : $size = "";

    $well_content = "<div class='well" . $size . $class . "'>" . do_shortcode($content) . "</div>";

    return $well_content;

}

add_shortcode( 'well', 'bs_well_func' );

/* Icon: http://fortawesome.github.com/Font-Awesome/ */

/* [icon type=null class=null] */

function bs_icon_func($atts) {

    extract(
        shortcode_atts(
            array(
                'type' => '',
                'class' => ''
            ),
            $atts
        )
    );

    if ( $class !== '' ) {
        $class = " " . $class;
    }

    $icon_content = "<i class='icon-" . $type . $class . "'></i>";

    return $icon_content;

}

add_shortcode( 'icon', 'bs_icon_func' );

/* Thumbnails: http://twitter.github.com/bootstrap/components.html#thumbnails */

/* [thumbnails][/thumbnails] */

function bs_thumbnails_func($atts, $content = null) {

    $thumbnails_content = "<ul class='thumbnails'>" . do_shortcode($content) . "</ul>";

    return $thumbnails_content;

}

add_shortcode( 'thumbnails', 'bs_thumbnails_func' );

/* Thumbnail: http://twitter.github.com/bootstrap/components.html#thumbnails */

/* [thumbnail size=4 src=null title=null content=null class=null][/thumbnail] */

function bs_thumbnail_func($atts, $content = null) {

    extract(
        shortcode_atts(
            array(
                'size' => 4,
                'src' => '',
                'title' => '',
                'class' => ''
            ),
            $atts
        )
    );

    $thumbnail_content = '
	<li class="col-md-' . $size . ' ' . $class . '">
		<div class="img-thumbnail">
			<h4>' . $title . '</h4><img src="' . $src. '" alt="' . $title . '">' . do_shortcode($content) . '
		</div>
	</li>';

    return $thumbnail_content;

}

add_shortcode( 'thumbnail', 'bs_thumbnail_func' );

/* Move wpautop() to run after shortcodes */

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 11);
add_filter('widget_text', 'do_shortcode');
