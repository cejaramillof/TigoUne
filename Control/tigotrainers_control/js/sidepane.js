
(function ($) {
    var body = $('body');
    var html = $('html');

    $(document).on('click', '.fullscreen-pane-close', function (e) {
        e.preventDefault();
        closeFullScreenPane($(this));
    });

    window.renderFullScreenPane = function () {

        var paneHtml = '<div class="fullscreen-pane-dimming"></div><div class="fullscreen-pane"><div class="fullscreen-pane-header"><a href="#" class="fullscreen-pane-close ttr-icon-close-round"></a></div><div class="fullscreen-pane-content"></div></div>';
        var pane = getLastSidePane();

        var windowScroll = body.scrollTop();

        if (!pane.length) {
            body.prepend(paneHtml);
        } else {
            pane.after(paneHtml);
        }
        pane = getLastSidePane();

        var paneDim = pane.prev();

        pane.css('top', windowScroll);
        html.css('overflow', 'hidden');

        setTimeout(function () {
            pane.addClass('open');
            paneDim.addClass('open');
        }, 20);

        return pane;
    };

    window.closeFullScreenPane = function (a) {
        var pane = a.closest('.fullscreen-pane');
        var paneDim = pane.prev();

        pane.removeClass('open');
        paneDim.removeClass('open');

        setTimeout(function () {
            html.css('overflow-y', 'auto');
            paneDim.remove();
            pane.remove();
        }, 400);
    };

    function getLastSidePane() {
        return $('.fullscreen-pane').last()
    }
})(jQuery);

(function ($) {
    var body = $('body');
    var html = $('html');

    $(document).on('click', '.modalbox-close', function (e) {
        e.preventDefault();
        closeModalBox($(this));
    });

    window.renderModalBox = function (title, content) {
        var modalHtml = '<div class="modalbox-container"><div class="modal-dimming"></div><div class="modalbox"><div class="modalbox-header"><span class="modalbox-header-title">'+title+'</span><a href="#" class="modalbox-close ttr-icon-close-round"></a></div><div class="modalbox-content">'+content+'</div></div></div>';
        body.prepend(modalHtml);

        var modalBox = $('.modalbox');
        var modalDim = modalBox.prev();
        html.css('overflow', 'hidden');

        setTimeout(function () {
            modalBox.addClass('open');
            modalDim.addClass('open');
        }, 20);

        return modalBox;
    };

    window.closeModalBox = function (a) {
        var modalBox = a.closest('.modalbox');
        var modalDim = modalBox.prev();

        modalBox.removeClass('open');
        modalDim.removeClass('open');

        setTimeout(function () {
            html.css('overflow-y', 'auto');
            modalDim.remove();
            modalBox.remove();
        }, 400);
    };
})(jQuery);