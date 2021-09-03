(function ($) {
    $(document).ready(function() {
        $('.icon').click( function() {
            $(this).find('img').toggle();
            var favorites;
            favorites.push( $('[data-mls]') );
            localStorage.setItem('favorites', JSON.stringify(favorites));

            var favoritesSaved = JSON.parse(localStorage.getItem('favorites'));
        })
    });
})(jQuery);
