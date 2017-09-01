<?php 
get_template_part("header"); ?>   

 <div class="container">

	<div id="primary" class="content-area">
		<main id="1" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
				the_content();

		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
		 </div>
    <?php
    wp_reset_query();
    get_template_part("footer");
    wp_footer();
    ?>