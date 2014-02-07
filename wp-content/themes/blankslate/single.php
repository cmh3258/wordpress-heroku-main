
<div class="header_style">
    <?php get_header(); ?>
</div>    
<div id="content_side_wrap">
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
    <div id="content_section">
    
    <?php get_template_part( 'entry' ); ?>
    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    </div>
<?php endwhile; endif; ?>
    <!--
<footer class="footer">
<?php get_template_part( 'nav', 'below-single' ); ?>
</footer>
    -->
</section></div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

    


    