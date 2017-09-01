<?php /* Template Name: Галерея */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
$custom = get_post_custom();
?>
<div class="block photos" id="KOROB">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h3 class="block_header">Прикоснись к игре</h3>
            </div>
        </div>
    </div>
    <div class="gallery"><!-- this empty div is used to display images-->
        <?php
        //the small function to output the images...
        $images = json_decode($custom['fx_gallery_img'][0]);
        /*$images = array(
            get_bloginfo('template_directory').'/images/gallery/fon1.jpg', //full path to image
            get_bloginfo('template_directory').'/images/gallery/fon2.jpg',
            get_bloginfo('template_directory').'/images/gallery/fon3.jpg',
            get_bloginfo('template_directory').'/images/gallery/fon4.jpg',
            get_bloginfo('template_directory').'/images/gallery/fon5.jpg',
            get_bloginfo('template_directory').'/images/gallery/fon6.jpg',
        );*/
        $i=1;
        foreach($images as $image){
            echo '<div class="gallery_image" id="gallery_image_'.$i.'" style="background-image: url('.$image.'); ';
            if($i==1) echo 'display:block; ';
            echo '"></div>';
            $i++;
        }
        ?>

        <div class="container jcarousel_container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8 col-sm-offset-0 col-sm-12">
                    <div class="jcarousel_wrap">
                        <div class="jcarousel">
                            <ul>
                                <?php $i=1;
                                foreach($images as $image){
                                    echo '<li class="carousel-link" data-image="'.$i.'" style="background-image:url('.$image.')"><a href="#"></a></li>';
                                    /*
                                    echo '<li><a href="#" class="carousel-link" data-image="'.$i.'">';
                                    the_php_thumb($image, 126, 68);
                                    echo '</a></li>';

                                    */
                                    $i++;
                                }
                                ?>
                            </ul>
                        </div>
                        <a href="#" class="jcarousel-next jcarousel_ctrl right"><img src="<?php bloginfo('template_directory') ?>/images/right.png" ></a>
                        <a href="#" class="jcarousel-prev jcarousel_ctrl left"><img src="<?php bloginfo('template_directory') ?>/images/left.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>