<?php /* Template Name: Описание */ ?><?php
if($GLOBALS['front']!=true){
    header('Location: /');
    exit;
}
?>
<div class="block description" id="DIF">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <?php the_content() ?>
            </div>
        </div>
    </div>
</div>
