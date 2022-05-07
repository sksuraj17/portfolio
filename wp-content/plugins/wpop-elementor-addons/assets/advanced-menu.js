(function($) {

    PPAdvancedMenu = function($scope) {

        this.node = $scope;
        this.wrap = $scope.find('.wpopea-advanced-menu__container');
        this.menu = $scope.find('.wpopea-advanced-menu');
        this.dropdownMenu = $scope.find('.wpopea-advanced-menu__container.wpopea-advanced-menu--dropdown');
        this.menuToggle = $scope.find('.wpopea-menu-toggle'); // hamburger icon
        this.settings = $scope.find('.wpopea-advanced-menu__container').data('settings');
        this.menuId = this.settings.menu_id;
        this.menuType = this.settings.menu_type;
        this.duration = 400;

        this.init();
    };

    PPAdvancedMenu.prototype = {
        stretchElement: null,

        init: function() {

            if (!this.menu.length) {
                return;
            }

            if (jQuery.fn.smartmenus) {
                // Override the default stupid detection
                jQuery.SmartMenus.prototype.isCSSOn = function() {
                    return true;
                };

                if (elementorFrontend.config.is_rtl) {
                    jQuery.fn.smartmenus.defaults.rightToLeftSubMenus = true;
                }
            }

            if ('undefined' !== typeof $.fn.smartmenus) {
                this.menu.smartmenus({
                    subIndicatorsText: '',
                    subIndicatorsPos: 'append',
                    subMenusMaxWidth: '1000px'
                });
            }

            if ('default' === this.menuType) {
                this.initStretchElement();
                this.stretchMenu();
            }

            if ('off-canvas' === this.menuType) {
                this.initOffCanvas();
            }

            if ('full-screen' === this.menuType) {
                this.initFullScreen();
            }

            this.bindEvents();
        },

        getElementSettings: function(setting) {
            if ('undefined' !== typeof this.settings[setting]) {
                return this.settings[setting];
            }

            return false;
        },

        bindEvents: function() {
            var self = this;

            if (!this.menu.length) {
                return;
            }

            this.menuToggle.on('click', $.proxy(this.toggleMenu, this));

            if ('default' === this.menuType) {
                elementorFrontend.addListenerOnce(this.node.data('model-cid'), 'resize', $.proxy(this.stretchMenu, this));
            }

            //self.panelUpdate();

            this.closeMenuESC();
        },

        panelUpdate: function() {
            var self = this;

            if ('undefined' !== typeof elementor && $('body').hasClass('elementor-editor-active')) {
                elementor.hooks.addAction('panel/open_editor/widget/wpopea-advanced-menu', function(panel, model, view) {
                    panel.$el.find('select[data-setting="dropdown"]').on('change', function() {
                        if (model.attributes.id === self.menuId) {
                            if ($(this).val() === 'all') {
                                self.node.find('.wpopea-advanced-menu--main').hide();
                            }
                            if ($(this).val() !== 'all') {
                                self.node.find('.wpopea-advanced-menu--main').show();
                            }
                        }
                    });

                    if (model.attributes.id === self.menuId && 'all' === self.settings.breakpoint) {
                        self.toggleMenu();
                    }
                });
            }
        },

        initStretchElement: function() {
            this.stretchElement = new elementorFrontend.modules.StretchElement({
                element: this.dropdownMenu
            });
        },

        stretchMenu: function() {
            if (this.getElementSettings('full_width')) {
                this.stretchElement.stretch();

                this.dropdownMenu.css('top', this.menuToggle.outerHeight());
            } else {
                this.stretchElement.reset();
            }
        },

        initOffCanvas: function() {
            $('.wpopea-menu-' + this.settings.menu_id).each(function(id, el) {
                if ($(el).parent().is('body')) {
                    $(el).remove();
                }
            });

            $('.wpopea-menu-clear').remove();

            $('body').prepend(this.node.find('.wpopea-menu-' + this.settings.menu_id));
            $('.wpopea-menu-' + this.settings.menu_id).css('height', window.innerHeight + 'px');
            $('.wpopea-menu-' + this.settings.menu_id).find('.wpopea-menu-close').on('click', $.proxy(this.closeMenu, this));
        },

        initFullScreen: function() {
            $('body').addClass('wpopea-menu--full-screen');
            $('.wpopea-menu-' + this.settings.menu_id).css('height', window.innerHeight + 'px');
            $('.wpopea-menu-' + this.settings.menu_id).find('.wpopea-menu-close').on('click', $.proxy(this.closeMenu, this));
        },

        toggleMenu: function() {
            this.menuToggle.toggleClass('wpopea-active');

            var menuType = this.getElementSettings('menu_type');
            var isActive = this.menuToggle.hasClass('wpopea-active');

            if ('default' === menuType) {
                var $dropdownMenu = this.dropdownMenu;

                if (isActive) {
                    $dropdownMenu.hide().slideDown(250, function() {
                        $dropdownMenu.css('display', '');
                    });

                    this.stretchMenu();
                } else {
                    $dropdownMenu.show().slideUp(250, function() {
                        $dropdownMenu.css('display', '');
                    });
                }
            }

            if ('off-canvas' === menuType) {
                this.toggleOffCanvas();
            }
            if ('full-screen' === menuType) {
                this.toggleFullScreen();
            }
        },

        toggleOffCanvas: function() {
            var isActive = this.menuToggle.hasClass('wpopea-active'),
                element = $('body').find('.wpopea-menu-' + this.menuId),
                time = this.duration,
                self = this;

            $('html').removeClass('wpopea-menu-toggle-open');

            if (isActive) {
                $('body').addClass('wpopea-menu--off-canvas');
                $('html').addClass('wpopea-menu-toggle-open');
                time = 0;
            } else {
                time = this.duration;
            }

            $('.wpopea-menu-open').removeClass('wpopea-menu-open');
            $('.wpopea-advanced-menu--toggle .wpopea-menu-toggle').not(this.menuToggle).removeClass('wpopea-active');

            setTimeout(function() {
                $('.wpopea-menu-off-canvas').removeAttr('style');

                if (isActive) {
                    $('body').addClass('wpopea-menu-open');
                    element.addClass('wpopea-menu-open').css('z-index', '999999');
                    if ($('.wpopea-menu-clear').length === 0) {
                        $('body').append('<div class="wpopea-menu-clear"></div>');
                    }
                    $('.wpopea-menu-clear').off('click').on('click', $.proxy(self.closeMenu, self));
                    $('.wpopea-menu-clear').fadeIn();
                } else {
                    $('.wpopea-menu-open').removeClass('wpopea-menu-open');
                    $('body').removeClass('wpopea-menu--off-canvas');
                    $('html').removeClass('wpopea-menu-toggle-open');
                    $('.wpopea-menu-clear').fadeOut();
                }
            }, time);
        },

        toggleFullScreen: function() {
            var isActive = this.menuToggle.hasClass('wpopea-active'),
                element = $('body').find('.wpopea-menu-' + this.menuId);

            $('html').removeClass('wpopea-menu-toggle-open');

            if (isActive) {
                $('html').addClass('wpopea-menu-toggle-open');
                this.node.find('.wpopea-menu-full-screen').addClass('wpopea-menu-open');
                this.node.find('.wpopea-menu-full-screen').attr('data-scroll', $(window).scrollTop());
                $(window).scrollTop(0);
            }
        },

        closeMenu: function() {
            if ('default' !== this.menuType) {
                $('.wpopea-menu-open').removeClass('wpopea-menu-open');
                this.menuToggle.removeClass('wpopea-active');

                $('html').removeClass('wpopea-menu-toggle-open');

                if ('full-screen' === this.menuType) {
                    var scrollTop = this.node.find('.wpopea-menu-full-screen').data('scroll');
                    $(window).scrollTop(scrollTop);
                }

                $('.wpopea-menu-clear').fadeOut();
            }
        },

        closeMenuESC: function() {
            var self = this;

            // menu close on ESC key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27) { // ESC
                    self.closeMenu();
                }
            });
        }

    };

})(jQuery);