var car_ul = $('#box');
function scroll_down(){
    $('#box:not(:animated)').animate({'top' : parseInt(car_ul.css('top')) - car_ul.find('li').outerHeight() - 10},500,function(){
        var cars = car_ul.find('li');
        cars.last().before(cars.first());
        car_ul.css({'top' : '0px'});
    });
}
var interval_id = setInterval(function(){scroll_down();},5000);