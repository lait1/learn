<?php /* Template Name: Новости */?>
<?php get_template_part("header"); ?>   
<?php	query_posts('cat=2'); ?>
 <div class="container">
    <div class="wrap-new">
        <?php while (have_posts()) : the_post();?>

                <div class="otziv-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-otziv">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                
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
     <div class="pagenavi"><p><?php posts_nav_link(); ?></p></div>   </div>
</div>
 	<?php
    wp_reset_query();
    get_template_part("footer");
    wp_footer();
	?>