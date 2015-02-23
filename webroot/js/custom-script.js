jQuery(document).ready(function($){
    $(".admin-menu .link").click(function(event){
    	event.preventDefault();
        $('.sub-links').slideToggle();
    });
});