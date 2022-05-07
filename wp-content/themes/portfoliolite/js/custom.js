(function ($) {
    var PortfoliolineLib = {
        init: function (){
            this.bindEvents();
        },
         bindEvents: function (){
            var $this = this;
                $this.Loader();
                $this.DefaultMenu();
                $this.MainMenu();
                $this.FrontMenu();
                $this.MobileMenuFunction();
                $this.backtoTop();
                $this.smoothScroll();
                $this.stickyHeader();
                $this.headerVisibility();
            
         },
Loader: function(){
    if ($("#loader-wrapper").length){
     $(".loader").fadeOut("slow");
     $("#loader-wrapper,#loader").delay(1000).fadeOut("slow");
    }
},
DefaultMenu: function(){
                 $("#portfolio-menu").portfolioResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });
        },
MainMenu : function(){
                $("#portfolio-main-menu").portfolioResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            });
        },
FrontMenu : function(){
                $("#portfolio-front-menu").portfolioResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            });
        },

 MobileMenuFunction : function(){
                 // close-button-active
                   
                        jQuery('body').find('.sider').prepend('<div class="menu-close"><span class="menu-close-btn"></span></div>');
                        $('.menu-close-btn').removeAttr("href");
                        //Menu close
                        $('.menu-close-btn,.portfolio-menu li a span.portfolio-menu-link').click(function(){
                        $('body').removeClass('mobile-menu-active');
                        
                        });
                        $('.menu-close-btn,.portfolio-menu li a span.portfolio-menu-link').keypress(function(){
                        $('body').removeClass('mobile-menu-active');
                        
                        });
                        
                        // Esc key close menu
                      document.addEventListener( 'keydown', function( event ) {
                      if ( event.keyCode === 27 ) {
                        event.preventDefault();
                        document.querySelectorAll( '.mobile-menu-active' ).forEach( function( element ) {
                          jQuery('body').removeClass('mobile-menu-active');
                        }.bind( this ) );
                      
                      }
                    }.bind( this ) );
                 
                    //ToggleBtn main menu Click
                    $('#menu-btn').click(function (e){
                       e.preventDefault();
                       $('body').addClass('mobile-menu-active');
                       $('.portfolio-menu').removeClass('hide-menu');  
                       portfoliolitemenu.modalMenu.init(); 
                    });
                    $('#menu-btn').keypress(function (e){
                       e.preventDefault();
                       $('body').addClass('mobile-menu-active');
                       $('.portfolio-menu').removeClass('hide-menu');   
                       portfoliolitemenu.modalMenu.init();
                    });

                   
        },
            
// Scroll down header
scrollDownHeader: function(){
                    jQuery(window).scroll(function(){
                        var scroll = jQuery(window).scrollTop();
                        if (scroll >= 100) {
                            jQuery(".header").addClass('smaller');
                        } else {
                            jQuery(".header").removeClass("smaller");
                        }
                    });
},
backtoTop: function(){
    (function(jquery) {
    jquery(window).load(function() {
        if (jquery('#back-to-top').length) {
            var scrollTrigger = 100, // px
                backToTop = function() {
                    var scrollTop = jquery(window).scrollTop();
                    if (scrollTop > scrollTrigger) {
                        jquery('#back-to-top').addClass('show');
                    } else {
                        jquery('#back-to-top').removeClass('show');
                    }
                };
            backToTop();
            jquery(window).on('scroll', function() {
                backToTop();
            });
            jquery('#back-to-top').on('click', function(e) {
                e.preventDefault();
                jquery('html,body').animate({
                    scrollTop: 0
                }, 700);
            });

            jquery('#arrow-down').on('click', function(e){
                e.preventDefault();
                var nextAnchor = this.hash.replace("#", "");
                var gotoPoint = jquery("#" + nextAnchor).position();
                jquery('html,body').animate({
                    scrollTop: gotoPoint
                }, 'slow');
            });
          
        }
    });
})(jQuery);
}, //backtoTop End

// smooth scroll and active Link
smoothScroll: function(){
function validUrlCheck(url){
var url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
 return url_validate;
};
jQuery( window ).on(
        'scroll', function (){
          if ( jQuery( 'body' ).hasClass( 'home' ) ){
              var almaira_shop_headerHt = jQuery("header").height();
              var almaira_shop_scrollTop = jQuery( window ).scrollTop(); // cursor position
              var headerHeight = jQuery( '.portfolio-menu' ).outerHeight(); // header height
              var isInOneSection = 'no'; // used for checking if the cursor is in one section or not
              // for all sections check if the cursor is inside a section
              jQuery( 'section' ).each(
                function(){
                  var thisID = '#' + jQuery( this ).attr( 'id' ); // section id
                  var almaira_shop_offset = jQuery( this ).offset().top; // distance between top and our section
                  var thisHeight = jQuery( this ).outerHeight(); // section height
                  var thisBegin = almaira_shop_offset - headerHeight; // where the section begins
                  var thisEnd = almaira_shop_offset + thisHeight - headerHeight; // where the section ends
                  // if position of the cursor is inside of the this section
                  if( almaira_shop_scrollTop + almaira_shop_headerHt + 30 >= thisBegin &&
                    almaira_shop_scrollTop + almaira_shop_headerHt + 30 <= thisEnd ){
                    isInOneSection = 'yes';
                    jQuery( 'nav .active' ).removeClass( 'active' );
                    jQuery( 'nav a[href$="' + thisID + '"]' ).parent( 'li' ).addClass( 'active' ); // find the menu button with the same ID section
                    return false;
                  }
                  if( isInOneSection === 'no' ){
                   jQuery( 'nav .active' ).removeClass( 'active' );
                  }
                }
              );
           }
        }
    );
jQuery('a.page-scroll').bind('click', function(event) {
            var $anchor = jQuery(this);
            var url = $anchor.attr('href');
            var url_validate = validUrlCheck(url);
            var hgt = jQuery('.header').height();
            if(!url_validate.test(url)){
              if ( jQuery( url ).length ) {
            jQuery('html, body').stop().animate({
            scrollTop: jQuery(url).offset().top - 50
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
       }
      }
    });
},
stickyHeader: function(){
if(jQuery(".header.sticky").length!=''){
jQuery(document).on("scroll", function(){
var $headerBar = jQuery('.header.sticky').height(); 
var $totalheaderBar = $headerBar + 20;
  if(jQuery(document).scrollTop() > $totalheaderBar){
      jQuery(".header.sticky").addClass("shrink");
      jQuery('.page-wrapper').css('margin-top',$totalheaderBar +'px'); 
    }else{
      jQuery(".header.sticky").removeClass("shrink");
      jQuery('.page-wrapper').css('margin-top',0+'px');

  } 
});
}
},
headerVisibility:function(){
jQuery(document).on("scroll", function(){
  if(jQuery(document).scrollTop() > 100){
      jQuery(".home #header.hide").addClass("visible");
    }else{
      jQuery(".home #header.hide").removeClass("visible");

  } 
});
},

}

/* -----------------------------------------------------------------------------------------------
  Modal Menu
--------------------------------------------------------------------------------------------------- */
var portfoliolitemenu = portfoliolitemenu || {};
portfoliolitemenu.modalMenu = {
  init: function() {
   
    this.keepFocusInModal();
  },
  keepFocusInModal: function(){
    var _doc = document;
    _doc.addEventListener( 'keydown', function( event ){
      var toggleTarget, modal, selectors, elements, menuType, bottomMenu, activeEl, lastEl, firstEl, tabKey, shiftKey,
        toggleTarget = '.sider';
        if(jQuery('.mobile-menu-active').length!=''){   
        selectors = 'a,.arrow';
        modal = _doc.querySelector( toggleTarget );
        elements = modal.querySelectorAll( selectors );
        elements = Array.prototype.slice.call( elements );
        if ( '.sider' === toggleTarget ){
          menuType = window.matchMedia( '(min-width: 1024px)' ).matches;
          menuType = menuType ? '.expanded-menu' : '.portfolio-menu';
          elements = elements.filter( function( element ) {
            return null !== element.closest( menuType ) && null !== element.offsetParent;
          } );
          elements.unshift( _doc.querySelector( '.menu-close-btn' ) );
           $('.portfolio-menu a,.menu-close-btn,.arrow').attr('tabindex',0); 
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
}; // portfoliolitemenu.modalMenu
PortfoliolineLib.init();
$(".menu-close").click(function(){
    // focus and select
   $('#menu-btn').focus().select();
   $('.portfolio-menu a,.menu-close-btn,.arrow').attr('tabindex',-1);
});
$(".menu-close").keypress(function(){
    // focus and select
   $('#menu-btn').focus().select();
   $('.portfolio-menu a,.menu-close-btn,.arrow').attr('tabindex',-1);
});
})(jQuery);