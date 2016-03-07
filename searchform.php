<?php
/**
 * The template for styling the search form.
 *
 * @package Edgebird
 * @since Edgebird 1.0
 */
 ?>

<div id="searchbutton">
	<a href="?s=waitaminute"><i class="fa fa-search"></i></a>
</div>
 <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
    <div class="input-group">
    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
    	<input type="text" placeholder="Search <?php bloginfo('name'); ?>" class="form-input form-auto" value="<?php the_search_query(); ?>" name="s" id="s" />
    </div>
    <div class="input-group">
    	<input type="submit" class="btn-outline form-auto" id="searchsubmit" value="<?php _e('GO'); ?>" />
    </div>
</form>