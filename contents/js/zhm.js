function initAccordian() {
    $(document).ready(function() {
        var allPanels = $('.accordian > div.accordian-content');
        allPanels.hide();

        var accordianHeaders = $('.accordian-header');
        accordianHeaders.click(function() {
            $('.accordian-header').removeClass('accordian-header-selected');
            var accordianContent = $(this).next().next();

            if (accordianContent.is(":visible")) {
                accordianContent.slideUp();
            } else {
                allPanels.slideUp();
                accordianContent.slideDown();
                $(this).addClass('accordian-header-selected');
            }

            unsqueezeObjektePanel();
            triggerResizeMap();
            return false;
        });

        openObjekte();

        $('.more-button-panel').click(function() {
            unsqueezeObjektePanel();
        });

    });
}

function triggerResizeMap() {
    google.maps.event.trigger(map, "resize");
}

function openObjekte() {
    $('#objekte-header').addClass('accordian-header-selected').next().next().slideDown();
}

function unsqueezeObjektePanel() {
    $('#objekte-content').removeClass('objekte-squeezed');
    $('.more-button-panel').remove();
}

function updateColors() {
    var allPanels = $('.accordian-header');

    allPanels.each(function(index) {
        var accordianContent = $(this).next().next();

        var visible = accordianContent.is(':visible');
        $(this).toggleClass('accordian-header-selected', visible);

        alert($(this).html() + visible);
    });
}