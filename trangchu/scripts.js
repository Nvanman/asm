document.addEventListener('DOMContentLoaded', function() {
    var myCarousel = document.querySelector('#carouselExampleIndicators');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000,
        ride: 'carousel'
    });
});
