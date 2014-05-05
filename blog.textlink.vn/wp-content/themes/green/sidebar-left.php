<!--sidebar1-->
<div id="sidebar1">
    <ul>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?>
		<?php wp_list_categories('title_li=<h2>Categories</h2>'); ?>
    <?php endif; // end of sidebar1 ?>    
    </ul>
</div><!--sidebar1-end-->