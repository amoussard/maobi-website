$(document).ready(function() {
    $('.typed-text').each(function() {
        var text = $(this).data('text');
        $(this).typed({
            strings: [text],
            typeSpeed: -5000,
            showCursor: false
        });
    })
});
