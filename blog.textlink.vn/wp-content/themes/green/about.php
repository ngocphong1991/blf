    <!--about-->  
  	<div id="about">
    <?php query_posts("page_id=5"); ?>
 
    
    <?php while (have_posts()) : the_post(); ?>   
    <h3>About Me</h3>
  	<a href="<?php the_permalink() ?>"><?php echo get_avatar( get_the_author_id(), '80', ''); ?></a><span><?php ob_start(); the_excerpt(); echo ld_clean(ob_get_clean()); ?></span>
  	</div><!--about-end-->      
	
	<?php endwhile; ?>
