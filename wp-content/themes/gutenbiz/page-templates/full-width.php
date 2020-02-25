<?php
/*
 Template Name: Gutenbiz Full Width
*/

 get_header(); ?>

 <div id="content">
	<?php
		if ( have_posts() ) {
		 	// Load posts loop.
		 	while ( have_posts() ){
		 		the_post(); 
		 		the_content();
		 	}
		 }
	?>
 </div>
 <?php get_footer();