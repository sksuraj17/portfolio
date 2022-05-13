jQuery(document).ready(function ($) {
    "use strict";

    $('.arrival-parallax').jarallax({
        speed: 0.2
    });

    /**
    * Back to top button
    */
    $('.scroll-top-top').hide();
    var offset = 250;
    var duration = 300;
    $(window).scroll(function () {
        if ($(this).scrollTop() > offset) {
            $('.scroll-top-top').fadeIn(duration);
        } else {
            $('.scroll-top-top').fadeOut(duration);
        }
    });
    $('body').on('click', '.scroll-top-top', function (event) {
        event.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, duration);
        return false;
    });

    /**
    * One page navigation
    *
    */
    var enableOnepageMenu = arrival_loc_script.onepagenav;

    if( 'yes' == enableOnepageMenu ){
        $(".site-header .main-navigation,.plx-nav").onePageNav({
            currentClass: 'current',
            changeHash: false,
            scrollSpeed: 850,
            scrollThreshold: 0.5,
            
        });
    }
    

    

    /*
    * Toggle search
    */
    $('body').on('click', '.header-last-item .search-wrap', function () {
        $('.arrival-search-form-wrapp').addClass('active');
    });

    $(document).on('click', '.arrival-search-form-wrapp .close', function () {
        $('.arrival-search-form-wrapp').removeClass('active');
    });

/**
* Mobile navigation scripts
*
*/   
 $('body').on('click keypress','.toggle-wrapp', function(e){
    e.preventDefault();
     
    $('.site-header').toggleClass('toggled-on');
    $('body').toggleClass('toggled-modal');

    if( $(this).hasClass('close-wrapp') ){
        arrivalElFocus('.mob-outer-wrapp .toggle-wrapp');
    }else{
        arrivalElFocus('.toggle.close-wrapp.toggle-wrapp');
    }
   
 });



$('.mob-nav-wrapp ul li ul').slideUp();



$('body').on('vclick touchstart keypress','.mob-nav-wrapp .sub-toggle', function()  {
  
  $(this).next().next('ul.sub-menu').slideToggle(400);
  $(this).parent('li').toggleClass('mob-menu-toggle');
});

$('body').on('click touchstart keypress','.mob-nav-wrapp .sub-toggle-children',function() {
  $(this).next().next('ul.sub-menu').slideToggle(400);
    
});

/**
* Close the menu by clicking the link if parallax scrolling menu is enabled
*
* @since1.3.5
*
*/
if( 'yes' == enableOnepageMenu ){

    
     $('body').on('vclick touchstart keypress','.mob-nav-wrapp nav ul li', function()  {
    setTimeout(function(){
        $('.site-header').toggleClass('toggled-on');
        $('body').toggleClass('toggled-modal');
  }, 500);
    });

    
    
}


$(".post-thumb").fitVids({
     customSelector: "iframe[src^='https://w.soundcloud.com']"
});
$(".list-layout .fluid-width-video-wrapper").css("padding-top", "101%");

//gallery post slider
$('.gallery-post-format').slick({
    arrows: true
});

var smoothScrollEnable = arrival_loc_script.smoothscroll;
if( 'yes' == smoothScrollEnable ){
    SmoothScroll({
         animationTime    : 1000, // [ms]
         stepSize         : 100, // [px]
      })
}


// Elements to focus after modals are closed.
function arrivalElFocus(focusElement){
     var _doc = document;
     setTimeout( function() {

    focusElement = _doc.querySelector( focusElement );
    focusElement.focus();

    }, 200 );
}


arrivalFocusTab();
function arrivalFocusTab(){
        var _doc = document;

        _doc.addEventListener( 'keydown', function( event ) {
            var toggleTarget, modal, selectors, elements, menuType, bottomMenu, activeEl, lastEl, firstEl, tabKey, shiftKey;
                
            if ( _doc.body.classList.contains( 'toggled-modal' ) ) {
                toggleTarget = '.mob-nav-wrapp';//mobile menu wrapper
                selectors = 'input, a, button';
                modal = _doc.querySelector( toggleTarget );

                elements = modal.querySelectorAll( selectors );
                elements = Array.prototype.slice.call( elements );

                if ( '.menu-modal' === toggleTarget ) {
                    menuType = window.matchMedia( '(min-width: 1000px)' ).matches;
                    menuType = menuType ? '.expanded-menu' : '.mobile-menu';

                    elements = elements.filter( function( element ) {
                        return null !== element.closest( menuType ) && null !== element.offsetParent;
                    } );

                    elements.unshift( _doc.querySelector( '.mob-outer-wrapp .toggle-wrapp' ) ); //mobile toggle

                    bottomMenu = _doc.querySelector( '.mob-outer-wrapp .menu-last' );//mobile menu last div

                    if ( bottomMenu ) {
                        bottomMenu.querySelectorAll( selectors ).forEach( function( element ) {
                            elements.push( element );
                        } );
                    }
                }

                lastEl = elements[ elements.length - 1 ];
                firstEl = elements[0];
                activeEl = _doc.activeElement;
                tabKey = event.keyCode === 9;
                shiftKey = event.shiftKey;

                if ( ! shiftKey && tabKey && lastEl === activeEl ) {
                    event.preventDefault();
                    firstEl.focus();
                }

                if ( shiftKey && tabKey && firstEl === activeEl ) {
                    event.preventDefault();
                    lastEl.focus();
                }
            }
        } );
}


});