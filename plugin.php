<?php
/*
Plugin Name: Bootstrap Shortcodes for WordPress
Plugin URI: http://logoscreative.co
Description: Add shortcodes allowing common Bootstrap components to be used in the Visual Editor
Version: 1.0.1
Author: Cliff Seal
Author URI: http://logoscreative.co
Author Email: cliff@logos-creative.com
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

class BootstrapShortcodes {

    function __construct() {
        add_shortcode( 'collapse', array( $this, 'bs_collapse_func' ) );
        add_shortcode( 'tabs', array( $this, 'bs_tabs_func' ) );
        add_shortcode( 'tab', array( $this, 'bs_tab_func' ) );
        add_shortcode( 'tabcontent-group', array( $this, 'bs_tab_content_group_func' ) );
        add_shortcode( 'tabcontent', array( $this, 'bs_tab_content_func' ) );
        add_shortcode( 'button', array( $this, 'bs_button_func' ) );
        add_shortcode( 'btngroup', array( $this, 'bs_btngrp_func' ) );
        add_shortcode( 'row', array( $this, 'bs_row_func' ) );
        add_shortcode( 'inner-row', array( $this, 'bs_row_func' ) );
	    add_shortcode( 'inner-inner-row', array( $this, 'bs_row_func' ) );
        add_shortcode( 'col', array( $this, 'bs_span_func' ) );
        add_shortcode( 'inner-col', array( $this, 'bs_span_func' ) );
        add_shortcode( 'inner-inner-col', array( $this, 'bs_span_func' ) );
        add_shortcode( 'jumbotron', array( $this, 'bs_hero_func' ) );
        add_shortcode( 'well', array( $this, 'bs_well_func' ) );
        add_shortcode( 'icon', array( $this, 'bs_icon_func' ) );
        add_shortcode( 'thumbnail', array( $this, 'bs_thumbnail_func' ) );
	    add_shortcode( 'container', array( $this, 'bs_container_func' ) );
	    add_shortcode( 'lead', array( $this, 'bs_lead_func' ) );
        // Deprecated
        add_shortcode( 'hero', array( $this, 'bs_hero_func' ) );
	    add_shortcode( 'thumbnails', array( $this, 'bs_thumbnails_func' ) );
	    add_shortcode( 'span', array( $this, 'bs_span_func' ) );
	    add_shortcode( 'inner-span', array( $this, 'bs_span_func' ) );
	    add_shortcode( 'inner-inner-span', array( $this, 'bs_span_func' ) );
	    // Run this after the shortcodes so we can do stuff
        remove_filter( 'the_content', 'wpautop' );
        add_filter( 'the_content', 'wpautop' , 11 );
        add_filter( 'widget_text', 'do_shortcode' );
    }

    /* Helper public function */

    public function bs_slug($str) {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }

    /* Collapse: http://getbootstrap.com/javascript/#collapse */

    /* [collapse title=null element="h2" open=false][/collapse] */

    public function bs_collapse_func($atts, $content = null) {

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

    /* Tabs: http://getbootstrap.com/javascript/#tabs */

    /* [tabs class=null][/tabs] */

    public function bs_tabs_func($atts, $content = null) {

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

    /* Tab: http://getbootstrap.com/javascript/#tabs */

    /* [tab title="default" active=false class=null icon=null element=null] */

    public function bs_tab_func($atts) {

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

        $tab_content .= "<a href='#" . $this->bs_slug($title) . "' data-toggle='tab'>";

        if ( $icon != '' ) {
            $tab_content .= "<i class='fa fa-" . $icon . " fa-white fa-2x'></i><br />";
        }

        $tab_content .= do_shortcode($title) . "</a>";

        if ( $element != '' ) {
            $tab_content .= "</" . $element . ">";
        }

        $tab_content .= "</li>";

        return $tab_content;

    }

    /* Tab Content Group: http://getbootstrap.com/javascript/#tabs */

    /* [tabcontent-group][/tabcontent-group] */

    public function bs_tab_content_group_func($atts, $content = null) {

        $tab_content_group_content = "<div class='tab-content'>" . do_shortcode($content) . "</div>";

        return $tab_content_group_content;

    }

    /* Tab Content: http://getbootstrap.com/javascript/#tabs */

    /* [tabcontent title=null class=null active=false fade=false][/tabcontent] */

    public function bs_tab_content_func($atts, $content = null) {

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

        $tab_content = "<div class='tab-pane" . $fade . $active . "' id='" . $this->bs_slug($title) . "'>" . do_shortcode($content) . "</div>";

        return $tab_content;

    }

    /* Buttons: http://getbootstrap.com/css/#buttons */

    /* [button text=null link=null style=null size=null icon=null iconwhite=false class=null newwindow=false] */

    public function bs_button_func($atts) {

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

        $iconwhite == true ? $iconclr = " fa-white" : $iconclr = "";

        if ( $icon != '' ) {
            $icon = " <i class='fa fa-" . $icon . $iconclr . "'></i>";
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

    /* Button Group: http://getbootstrap.com/components/#btn-groups */

    /* [btngroup class=null][/btngroup] */

    public function bs_btngrp_func($atts, $content = null) {

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

    /* Row: http://getbootstrap.com/css/#grid */

    /* [row class=null rowid=null] */

    public function bs_row_func($atts, $content = null) {

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

    /* Col: http://getbootstrap.com/css/#grid */

    /* [col width=12 offset=0 class=null spanid=null] */

    public function bs_span_func($atts, $content = null) {

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

    /* Jumbotron: http://getbootstrap.com/components/#jumbotron */

    /* [jumbotron][/jumbotron] */

    public function bs_hero_func($atts, $content = null) {

        extract(
            shortcode_atts(
                array(
                    'class' => ''
                ),
                $atts
            )
        );

        if ( $class !== '' ) {
            $class = " " . $class;
        }

        $hero_content = "<div class='jumbotron" . $class . "'>" . do_shortcode($content) . "</div>";

        return $hero_content;

    }

    /* Well: http://getbootstrap.com/components/#wells */

    /* [well size=null class=null][/well] */

    public function bs_well_func($atts, $content = null) {

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

    /* Icon: http://fortawesome.github.com/Font-Awesome/ */

    /* [icon type=null class=null] */

    public function bs_icon_func($atts) {

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

        $icon_content = "<i class='fa fa-" . $type . $class . "'></i>";

        return $icon_content;

    }

    /* There's no reason for a thumbnail wrapper now. */

    public function bs_thumbnails_func($atts, $content = null) {

        return do_shortcode($content);

    }

    /* Thumbnail: http://getbootstrap.com/components/#thumbnails */

    /* [thumbnail size=4 src=null title=null content=null class=null][/thumbnail] */

    public function bs_thumbnail_func($atts, $content = null) {

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
        <div class="col-md-' . $size . ' ' . $class . '"><div class="thumbnail"><img src="' . $src. '" alt="' . $title . '"><div class="caption"><h3>' . $title . '</h3>' . do_shortcode($content) . '</div></div></div>';

        return $thumbnail_content;

    }

	/* Container: http://getbootstrap.com/css/#overview-container */

	/* [container class=null fluid=false][/container] */

	public function bs_container_func($atts, $content = null) {

		extract(
			shortcode_atts(
				array(
					'class' => '',
					'fluid' => false
				),
				$atts
			)
		);

		if ( $fluid === true ) {
			$divclass = "-fluid";
		} else {
			$divclass = "";
		}

		if ( $class !== '' ) {
			$divclass = " " . $class;
		}

		$container_content = "<div class='container" . $divclass . "'>" . do_shortcode($content) . "</div>";

		return $container_content;

	}

	/* Lead: http://twitter.github.com/bootstrap/components.html#typography */

    /* [lead][/lead] */

    public function bs_lead_func($atts, $content = null) {

        extract(
            shortcode_atts(
                array(
                    'class' => ''
                ),
                $atts
            )
        );

        if ( $class !== '' ) {
            $class = " " . $class;
        }

        $lead_content = "<span class='lead" . $class . "'>" . do_shortcode($content) . "</span>";

        return $lead_content;

    }
}


$bsshortcodes = New BootstrapShortcodes();
