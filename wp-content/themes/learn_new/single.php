<?php 

get_template_part("header"); ?>   

<div class="container">
 	<div class="wrap-new">
 	 <?php while (have_posts()) : the_post();?>

				<div class="otziv-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-otziv">
                            <h2><?php the_title(); ?></h2>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="otziv-text">
                            <p><?php the_content();?><br></p>
  
                                </div>
                            </div>
                         </div>

                    </div>
               
             
	<?php endwhile;?>
   <div class="pagenavi">
    <?php previous_post_link('%link', 'Предыдущая новость', true); ?>
	<?php next_post_link('%link', 'Следующая новость', true); ?></div>

	</div>	
</div>
    <?php
    wp_reset_query();
    get_template_part("footer");
    wp_footer();?>