
<aside id="sidebar" role="complementary">
    <?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
        <div id="primary" class="widget-area">
            <?php _e('Previous Posts:'); ?>
            <ul class="xoxo">
                
                <!--<?php dynamic_sidebar( 'primary-widget-area' ); ?>-->
                <?php wp_get_archives('type=postbypost&limit=15'); ?>
            </ul>
        </div>
    <?php endif; ?>
    <!--
    
  <?php _e('Archives:'); ?>
     <ul>
<?php wp_get_archives('type=monthly'); ?>
     </ul>
    <?php wp_get_archives('type=postbypost&limit=15'); ?>
        -->
</aside>