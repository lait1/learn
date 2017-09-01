<?php /* Template Name: Комментарии v2 */?>
<?php get_template_part("header"); ?>    

<?php	query_posts('cat=3'); ?>
<div class="b-comments">
    <div class="container">
        <div class="b-comments__h1">ОТЗЫВЫ О ЗАНЯТИЯХ ХИМИЕЙ И БИОЛОГИИ</div>
            <div class="b-comments__h2">Я - профессионал своего дела и поддерживаю высокое качество своей работы, чтобы получать еще больше положительных отзывов от своих клиентов.
            </div>
               
    </div>
</div>
<div class="comments-wrap">
    <div class="container">
        <div class="row">
                <?php while (have_posts()) : the_post();?>

            <div class="col-sm-4">
                <div class="comments-item">
                    <div class="comments-item_name"><?php the_title();?> <br> <?php the_field('school_class');?> КЛ.</div>
                    <div class="comments-item_title">« <?php the_field('comment_description');?> »</div>
                    <div class="comments-item_separator"></div>
                    <div class="comments-item_content"><?php  the_content();?></div>
                    <div class="comments-item_footer"><?php the_field('comment_parents');?></div>
                </div>
            </div>

            <?php endwhile;?>

        </div>
    </div> 
</div>  


    <?php
    wp_reset_query();
    get_template_part("footer");
    wp_footer();?>
