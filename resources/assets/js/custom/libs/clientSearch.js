/**
 * Created by Antony on 3/31/2015.
 * Allows a user to search for a product
 */

(function ($) {

    "use strict";

    var btn = $('#s');
    var searchInputField = $("#searchInput");
    var form = $('#suggestiveSearch');

    // reject empty search queries
    btn.click(function (e) {
        if (!searchInputField.val().trim()) {
            searchInputField.focus();
            e.preventDefault();
        }
    });

    // show suggestions to the user as they type in the search box
    searchInputField.devbridgeAutocomplete({
        serviceUrl: form.attr('action'),
        paramName: 'q',
        minChars: 2,
        showNoSuggestionNotice: true,
        noSuggestionNotice: "No results were found",
        onSelect: function (suggestion) {
            searchInputField.innerHTML = suggestion.name;
            window.location.href = suggestion.redirect;
        }
    })

})(jQuery);