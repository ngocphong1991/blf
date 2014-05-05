<!--sidebar2-->
<div id="sidebar2">
    <ul>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) : ?>
		<?php wp_list_bookmarks(); ?>
    <?php endif; // end of sidebar1 ?>  
    </ul>

</div><!--sidebar2-end--> 