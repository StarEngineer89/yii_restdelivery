//Proceed Button Starts
var lastScrollTop = 0;
$(window).scroll(function () { 
    //You've scrolled this much:
    var windowHeight = jQuery(window).height();
    var scrollPosition = $(window).scrollTop();
    var topDistance = windowHeight + scrollPosition - 335+'px'; //Increase/Decrease values for
    var st = $(this).scrollTop();
    if (st > lastScrollTop){
       // downscroll code
    } else {
      // upscroll code
      topDistance = windowHeight + scrollPosition - 390+'px';
    }
    lastScrollTop = st;
    if((jQuery('#menu-iframe').height() - 598) <= $(window).scrollTop())   {
        $('#menu-iframe').contents().find('body .footer_button_cart').css({
        position: 'fixed',
        bottom: '0',
        top: 'initial',
        });
      }
    else{
          $('#menu-iframe').contents().find('body .footer_button_cart').css({
            position: 'absolute',
            bottom: 'initial',
            top: '0',
            'margin-top': topDistance,
        });
    }
});//Proceed Button Ends

//Iframe Height
$('#menu-iframe').on('load', function() {
    setTimeout(function(){ 
        fix_height(); 
        fix_back_button();
    }, 1000);
});

function fix_height(){
    var iframeContentHeight = jQuery('#menu-iframe').contents().find('.container').eq(1).height() + 200;
        $('#menu-iframe').height(iframeContentHeight+'px');    
}

function fix_back_button(){
        var back_mobile = $('#menu-iframe').contents().find('.back-mobile').attr('href');
        var containe_string = back_mobile.includes('?');
        if(!containe_string){
            var iframe_url = back_mobile.split('?');
            //Add the iframe parameter in last if in case not in Back button
            if(iframe_url.length == 1){
               $('#menu-iframe').contents().find('.back-mobile').attr('href', '/menu-pepperspiripiri?iframe'); 
            }
        }
}