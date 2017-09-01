var carousel, timeout, carouselCopy = $('#carousel').clone();

$(document).ready(function(){
    makeCarousel();
    
});
$(window).resize(function(){
    clearTimeout(timeout);
    timeout = setTimeout(makeCarousel, 500);
});

function makeCarousel(){
    $('#carousel').remove();
    var copy = carouselCopy.clone();
    $('.sertificat-slider').append(copy);
    
    carousel = $("#carousel").waterwheelCarousel({
          flankingItems: 3,
          movingToCenter: function ($item) {
            $('#callback-output').prepend('movingToCenter: ' + $item.attr('id') + '<br/>');
          },
          movedToCenter: function ($item) {
            $('#callback-output').prepend('movedToCenter: ' + $item.attr('id') + '<br/>');
          },
          movingFromCenter: function ($item) {
            $('#callback-output').prepend('movingFromCenter: ' + $item.attr('id') + '<br/>');
          },
          movedFromCenter: function ($item) {
            $('#callback-output').prepend('movedFromCenter: ' + $item.attr('id') + '<br/>');
          },
          clickedCenter: function ($item) {
            $('#callback-output').prepend('clickedCenter: ' + $item.attr('id') + '<br/>');
          }
    });

    $('#prev').bind('click', function () {
      carousel.prev();
      return false
    });

    $('#next').bind('click', function () {
      carousel.next();
      return false;
    });

    $('#reload').bind('click', function () {
      newOptions = eval("(" + $('#newoptions').val() + ")");
      carousel.reload(newOptions);
      return false;
    });
}

// $('#myNavbar a[href^="/' + location.pathname.split("/")[1] + '"]').each(function () {
//     $(this).parent().addClass('active');
        
// });
// var link = window.location.pathname;
// $('#myNavbar ul li a[href="'+link+'"]').parent().addClass('active');

$('ul.nav li').each(function () {if (this.getElementsByTagName("a")[0].href == location.href) this.className = "active";});

$('.tribe-events-thismonth').bind('click', function () {
     if ( $(this).hasClass("tribe-events-has-events")) {
          alert("На этот день нет записей!!!");
        }else{
           $('#exampleModal').modal();
           var dataday = $(this).attr("data-day");
           $(".event_date").text(dataday);
           $("#event-date-service").attr("value", dataday)
        } 
    });
$('.tribe-events-month-event-title a').attr("href", '#');

$('.btn-lg').on('click', function(){
      $('html, body').animate({ scrollTop: $('#trial-classic-form').offset().top }, 800);
    });