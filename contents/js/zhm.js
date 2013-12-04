function initAccordian() {
    $(document).ready(function() {
        var allPanels = $('.accordian > div.accordian-content');
        allPanels.hide();

        var accordianHeaders = $('.accordian-header');
        accordianHeaders.click(function() {
            var accordianContent = $(this).next().next();

            if (accordianContent.is(":visible")) {
                accordianContent.slideUp();
            } else {
                allPanels.slideUp();
                accordianContent.slideDown();
            }
            return false;
        });
    });
}