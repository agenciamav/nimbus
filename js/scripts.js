
/* formulário */
$(document).ready(function(){ 

    // Obras Slider
    //  ->  http://www.jqueryscript.net/slideshow/Coverflow-Style-Image-Carousel-Plugin-For-jQuery-Carousel-Evolution.html
    $('#obras_slider').carousel({
        carouselWidth: 261,        
        carouselHeight: 436,
        frontWidth: 261,
        // frontHeight: 337,
        directionNav: true,
        reflection: false,
        // shadow: false,
        // buttonNav: false,
        description: false,
        descriptionContainer: $('.legend'),
        autoplay: false,
        autoplayInterval: 3000,
        backZoom: 0.9,
        backOpacity: 0.15,
        slidesPerScroll: 2,
        speed: 700,
        buttonNav: 'none',
    });


    $('#characterLeft').text('140 characters left');

    $('#message').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');            
        }
    });    
});
