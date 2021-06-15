/* Selects or deselects all checkboxes when clicking the Select all or Deselect all elements when viewing the options page. */

define(['jquery'], function($) {
    return {
        init: function () {
            var $selectButton = $('.report-select-all button');
            var $deselectButton = $('.report-deselect-all button');

            var selectAll = function(e) {
                e.preventDefault();
                var $checkboxes = $('input[type="checkbox"]');
                $checkboxes.prop('checked', true);
            };

            var deselectAll = function(e) {
                e.preventDefault();
                var $checkboxes = $('input[type="checkbox"]');
                $checkboxes.prop('checked', false);

            };

            $selectButton.on('click', selectAll);
            $deselectButton.on('click', deselectAll);
        }
    };
});