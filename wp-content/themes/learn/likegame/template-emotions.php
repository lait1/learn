<?php /* Template Name: Эмоции */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block emotions" id="EMO">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10"><?php $custom = get_post_custom() ?>
                <h3 class="block_header"><?php /*the_post();*/ the_title() ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <!--video-->

                <?php the_content(); ?>

                <div id="player" class="player1 player-container"
                     style="background-size: contain;
                         background-repeat: no-repeat;
                         background-position: center;
                        background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0] ?>');
                        position: relative;
                        height: 400px;
                        ">
                    <div class="play_stop"></div>
                </div>
            </div>
            <script>
                // 2. This code loads the IFrame Player API code asynchronously.
                var tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                function onPlayerReady(event) {
                    event.target.playVideo();
                }
                $('.play_stop').click(function(){
                    // 2. This code loads the IFrame Player API code asynchronously.
                    var tag = document.createElement('script');

                    tag.src = "https://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                    // 3. This function creates an <iframe> (and YouTube player)
                    //    after the API code downloads.
                    var player;

                        player = new YT.Player('player', {
                            height: '400',
                            width: $(".play_stop").width(),
                            videoId: '<?php echo $custom['fx_video_id'][0] ?>',
                            events: {
                                'onReady': onPlayerReady,
                            }
                        });

                    $(this).hide();
                    // 4. The API will call this function when the video player is ready.


                });

            </script>
            <div class="col-md-2 emotions_subblock">

            </div>
        </div>
    </div>
</div>
<a id="fixed_button" style="display: none" href="#" class=" yellow_button order_vertical" data-toggle="modal" data-target="#Modalform"><?php echo $custom['fx_btn_label'][0] ?></a>
