<?php /* template name: Видео */ ?><?php
fx_redirect();
?>
<?php $custom = get_post_custom(); ?>
<div class="video-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php the_title() ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="video-wrap">
                    <div id="player" class="player1 player-container" style="background-size:cover; background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0] ?>')">
                        <div class="play_stop"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="submit-button video_btn green_btn" data-toggle="modal" data-target="#get-video"><?php echo $custom['fx_btn_label'][0] ?></div>
            </div>
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
        $('.play_stop').click(function() {
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
                videoId: '<?php echo $custom['fx_video_id'][0]  ?>',
                events: {
                    'onReady': onPlayerReady,
                }
            });

            $(this).hide();
            // 4. The API will call this function when the video player is ready.


        });
    </script>
</div>