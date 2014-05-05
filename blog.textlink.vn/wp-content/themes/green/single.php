<?php get_header(); ?>

	<!--content-->
	<div id="content">
    
		<!--left-col-->   
		<div id="left-col">

	<!--post-->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<div class="post-info">
		<?php echo get_avatar( get_the_author_id(), '85', ''); ?>
		<em><?php the_time('F jS, Y') ?></em>
		<span class="post-tag"><?php the_tags('', ' . ', ''); ?></span>
		</div>

		<div class="entry">
        <div class="cat">Categorized under: <?php the_category(', '); ?></div>
		<h2><?php the_title(); ?></h2>
        
		<?php the_content(); ?>
		</div>
        
		<p class="metadata">
        You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

        <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
            // Both Comments and Pings are open ?>

        <?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
            // Only Pings are Open ?>
            Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

        <?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
            // Comments are open, Pings are not ?>
            You can skip to the end and leave a response. Pinging is currently not allowed.

        <?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
            // Neither Comments, nor Pings are open ?>
            Both comments and pings are currently closed.

        <?php } edit_post_link('<br />Edit this entry.','',''); ?>
		</p>
        


	<?php comments_template(); ?>
    
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('%link', 'Previous Post') ?></div>
			<div class="alignright"><?php next_post_link('%link', 'Next Post') ?></div>
		</div>
        

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
	</div><!--post-end-->       
</div><!--left-col-end-->      
<?php get_sidebar(); ?>
</div><!--content-end-->

</div><!--wrapper-end-->

<?php get_footer(); ?>
