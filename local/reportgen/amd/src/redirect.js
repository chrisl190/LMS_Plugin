/* This redirects the user to a new page which automatically downloads the PDF. */

define(['jquery', 'core/config'], function($, config) {
    return {
        init: function () {
            setTimeout(function() {
                window.location = config.wwwroot +  "/local/reportgen/generate.php?download=1";
                }, 2000);
        }
    };
});


