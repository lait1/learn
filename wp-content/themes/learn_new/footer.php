<div class="footer">
            <div class="container">
                <div class="pull-left"></div>
                <div class="pull-right"></div>
            </div>
        </div>
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="" id="trial-classic-form" class="send_mail_form form-horizontal">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button><h5 class="modal-title" id="exampleModalLabel">Запись на дату: <span class="event_date"></span> </h5>
      </div>
      <div class="modal-body">
         
                   <!-- <div class="row"> -->
                            <div class="control-group">
                                <label class="control-label" for="">Представтесь, пожалуйста</label>
                                <div class="controls"><input name="name" type="text" class="form-control"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="">Укажите ваш телефон</label>
                                <div class="controls"><input name="phone" type="text" class="form-control"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="email">Ваш электронный адрес</label>
                                <div class="controls"><input name="email" type="text" class="form-control"></div>
                            </div>
                            <div class="control-group">
                                <label for="">Укажите дополнительную информацию</label>
                                <textarea name="message" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="date-service" value="" id="event-date-service">
                        <!-- </div>       -->

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-1">Связаться со мной</button>
        </div>

               </form>
        </div>
  </div>
</div>

        <script src="<?php bloginfo('template_directory') ?>/js/jquery-2.1.1.min.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/jquery.validate.min.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/libs/waterwheel-carousel/jquery.waterwheelCarousel.min.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/script.js"></script>
        <script src="<?php bloginfo('template_directory') ?>/js/send_mail_js.js"></script>

    </body>
</html>
