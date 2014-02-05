<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title>
            <?php wp_title( ' | ', true, 'right' ); ?>
        </title>
        
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
        <!--
        <?php
            if ( is_page_template('cover_page.php')) { ?>
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('page-templates'); ?>/home_style.css" />
            <?php } 
        ?>
        
        <?php if ( is_page(6) ) { ?>
            <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/home_style.css" type="text/css" media="screen" />
            <?php } else { ?>
            <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
            <?php } ?>
        
        
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
        <?php if(is_page_template('cover_page.php')) :?>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/home_style.css" media="screen" />
        <?php endif;?>
        -->
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        
        <nav id="menu" role="navigation">
            <!--
            <div id="search">
                <?/*php get_search_form(); */?>
            </div>
            -->
            <p id="test"><?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?></p>
            
        </nav>
        
        <div id="wrapper" class="hfeed">
            <header id="header" role="banner">
                
                <section id="branding">
                    <!--
                    <div id="site-title"><?php if ( ! is_singular() ) { echo '<h1>'; } ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name' ), 'blankslate' ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a><?php if ( ! is_singular() ) { echo '</h1>'; } ?></div>
                    -->
                    <!--<div id="site-description"><?php/* bloginfo( 'description' ); */?></div>-->
                    <a href="http://www.recommenuapp.com/" id="logo_button"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_grey.png" alt="recommenu logo" id="logo_header"/></a>
                    <div id="site-description"><?php bloginfo( 'description' ); ?></div>
                    
                </section>
               
                <!--<img src="<?php bloginfo('stylesheet_directory'); ?>/images/atx1.jpg" alt="whatever"/>-->
                
                <hr></hr>
                <section id="branding">
                    <div id="web">
                        <h3><a href="http://www.recommenuapp.com/">Visit the Product Site</a></h3>
                    </div>
                </section>
            </header>
    <div id="container">