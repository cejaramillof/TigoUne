(function ($) {
    function Carousel(element) {
        var self = this;
        element = $(element);

        var nav = $('#slidepane-nav');
        var nav_items = $('li', nav);

        var container = $(">ul", element);
        var panes = $(">ul>li", element);

        var pane_width = 0;
        var pane_count = panes.length;

        var current_pane = 0;

        /**
         * initial
         */

        this.init = function () {
            setPaneDimensions();
            var c = this;
            $(window).on("load resize orientationchange", function () {
                setPaneDimensions();
                c.showPane(current_pane);
                //updateOffset();
            });
        };

        /**
         * set the pane dimensions and scale the container
         */
        function setPaneDimensions() {
            pane_width = element.width();
            panes.each(function () {
                $(this).css('width', pane_width);
            });
            container.width(pane_width * pane_count);
        }

        /**
         * hightlight current tab
         */

        function currentTab(index) {
            nav_items.removeClass('current');
            nav_items.eq(index).addClass('current');

            var $navLine = $("#nav-line");
            var current = $(".current");

            $navLine
                .width(current.width())
                .data("origLeft", $navLine.position().left)
                .data("origWidth", $navLine.width());


            if (Modernizr.csstransforms3d) {
                $navLine.css("transform", "translate3d(" + current.position().left + "px,0,0) scale3d(1,1,1)");
            }
            else if (Modernizr.csstransforms) {
                $navLine.css("transform", "translate(" + current.position().left + "px,0)");
            }
            else {
                $navLine.css("left", current.position().left + "px");
            }
        }

        /**
         * show pane by index
         */
        this.showPane = function (index, animate) {
            // between the bounds
            index = Math.max(0, Math.min(index, pane_count - 1));
            current_pane = index;

            currentTab(current_pane);

            var offset = -((100 / pane_count) * current_pane);
            setContainerOffset(offset, animate);
        };

        function setContainerOffset(percent, animate) {
            container.removeClass("animate");

            if (animate) {
                container.addClass("animate");
            }

            if (Modernizr.csstransforms3d) {
                container.css("transform", "translate3d(" + percent + "%,0,0) scale3d(1,1,1)");
            }
            else if (Modernizr.csstransforms) {
                container.css("transform", "translate(" + percent + "%,0)");
            }
            else {
                var px = ((pane_width * pane_count) / 100) * percent;
                container.css("left", px + "px");
            }
        }

        this.next = function () {
            return this.showPane(current_pane + 1, true);
        };
        this.prev = function () {
            return this.showPane(current_pane - 1, true);
        };

        function handleHammer(ev) {
            // disable browser scrolling
            ev.gesture.preventDefault();

            switch (ev.type) {
                case 'dragright':
                case 'dragleft':
                    // stick to the finger
                    var pane_offset = -(100 / pane_count) * current_pane;
                    var drag_offset = ((100 / pane_width) * ev.gesture.deltaX) / pane_count;

                    // slow down at the first and last pane
                    if ((current_pane == 0 && ev.gesture.direction == "right") ||
                        (current_pane == pane_count - 1 && ev.gesture.direction == "left")) {
                        drag_offset *= .1;
                    }

                    setContainerOffset(drag_offset + pane_offset);
                    break;

                case 'swipeleft':
                    self.next();
                    ev.gesture.stopDetect();
                    break;

                case 'swiperight':
                    self.prev();
                    ev.gesture.stopDetect();
                    break;

                case 'release':
                    // more then 50% moved, navigate
                    if (Math.abs(ev.gesture.deltaX) > pane_width / 2) {
                        if (ev.gesture.direction == 'right') {
                            self.prev();
                        } else {
                            self.next();
                        }
                    }
                    else {
                        self.showPane(current_pane, true);
                    }
                    break;
            }
        }

        new Hammer(element[0], {dragLockToAxis: true}).on("release dragleft dragright swipeleft swiperight", handleHammer);
    }

    var carousel = new Carousel("#slidepane");
    carousel.init();
    carousel.showPane(0);

    $('.nav-item').on('click', function () {
        carousel.showPane($(this).index(), true);
    });

})(jQuery);