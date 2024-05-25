$(document).ready(function () {
    $.pjax.defaults.scrollTo = false;
    
    if (localStorage.getItem("index-quote-scroll") != null) {
        $(window).scrollTo(localStorage.getItem("index-quote-scroll"));
    }

    $(window).on("scroll", function () {
        localStorage.setItem("index-quote-scroll", $(window).scrollTop());
    });
    listView.setScrollContainer(false);
});