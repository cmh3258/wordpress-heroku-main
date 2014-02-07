<div class="header_style">
    <?php get_header(); ?>
</div>    

<div id="content_side_wrap">
<section id="content" role="main">
    
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!--
    <?php get_template_part('entry'); ?>
    <?php comments_template(); ?>
    -->
    <div id="content_section">
    <h1><?php the_title(); ?></h1>
    <h4>Posted on <?php the_time('F jS, Y') ?></h4>
<p><?php the_content(__('(more...)')); ?></p>
    </div>
<?php endwhile; endif; ?>
    
<?php get_template_part('nav', 'below'); ?>
</section></div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>