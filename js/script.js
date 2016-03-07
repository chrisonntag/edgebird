/**
* Scrolling header script
*
* @package Edgebird
* @since Edgebird 1.0
*/

jQuery(function($) {


/**
* Hides Header on on scroll down
* 
* @since Edgebird 1.0
*/
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('#header-top').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('#header-top').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll UP
        if(st + $(window).height() < $(document).height()) {
            $('#header-top').removeClass('nav-up').addClass('nav-down');
        }
    }
    
    lastScrollTop = st;
}

/**
* Make the first word on each paragraph <strong>, if Post-Format Chat is selected
*
* @since Edgebird 1.0
*/
 // Select first word of every paragraph in post format chat
  $('.format-chat .entry-content p').each(function(){
    var text_splited = $(this).text().split(":");
    $(this).html("<strong>"+text_splited[0]+"</strong>: "+text_splited[1]);
  });


/**
* Update the .readposition div, which shows how long the article is
*
* @since Edgebird 1.0
*/

var $animation_elements = $('.show_readingposition');
var $window = $(window);
var offset = $animation_elements.offset();

function check_if_in_view() {
  var window_height = $window.height();
  var window_top_position = $window.scrollTop();
  var window_bottom_position = (window_top_position + window_height);
 
  $.each($animation_elements, function() {
    var $element = $(this);
    var element_height = $element.outerHeight();
    var element_top_position = $element.offset().top;
    var element_bottom_position = (element_top_position + element_height);
 
    //check to see if this current container is within viewport
    if ((element_bottom_position >= window_top_position) &&
        (element_top_position <= window_bottom_position)) {

        if($window.scrollTop() >= offset.top) {
            var article_scrolltop = $window.scrollTop()-offset.top;
            var article_height = $('*[data-order="1"]').outerHeight() + $('*[data-order="2"]').outerHeight() + $('.entry-meta').outerHeight();
            var article_percent = (article_scrolltop/article_height)*100;

            if(article_percent <= 100 && article_percent >= 0) {
                $(".readposition").css("width", article_percent+"%");
            }

            if(article_percent > "99") {
                $(".readposition").fadeOut(400);
            }

        }

    } 
  });
}

$window.on('scroll resize', check_if_in_view);
$window.trigger('scroll');

  

}); //DOM ready