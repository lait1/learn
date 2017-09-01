<?php /* Template Name: Комментарии */?>
<?php get_template_part("header"); ?>    

<?php	query_posts('cat=3'); ?>

<div class="container">
<?php while (have_posts()) : the_post();?>
 <!-- <div class="wrap-new"> -->
<div class="otziv-item comment-item">
                    <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                            <div class="title-otziv">
                                <span class="username"><?php the_title(); ?></span>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                        <img src="<?php  the_field('img_comments'); ?> " class="colorbox-manual comment-img">
                        
                        </div>

                        <div class="col-xs-9">
                            <div class="otziv-text">
                            <p><?php the_content();?><br></p>
  
                                </div>
                            </div>
                         </div>
                    </div>
               
    <?php endwhile;?>
    <div class="pagenavi"><p><?php posts_nav_link(); ?></p></div>
     </div>
     <!-- </div> -->
    <?php
    wp_reset_query();
    get_template_part("footer");
    wp_footer();?>