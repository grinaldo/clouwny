
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./materialize');
require('./init');
require('./slick')

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$('.hamburger').click(function() {
    $(this).toggleClass('open');
    $('.side-nav').toggleClass('side-nav--open');
    $('.brand-logo img').toggleClass('brand-logo__close');
    $('.user-actions').toggleClass('user-actions__close');
    $('.overlay').toggle();
});

$('.close-dialog').click(function() {
    $($('.close-dialog').data('target')).fadeOut();
});

$('.favorite-btn').click(function(e) {
    e.preventDefault();
    var csrf = $('meta[name=csrf-token]').attr("content");
    var product = $(this).data('product');
    $.ajax({
        /* the route pointing to the post function */
        url: '/wishlists/add',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {_token: csrf, product: product},
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function success(data) {
            if (data.type == 'success') {
                $('<div class=\"alert-box\"><div class="alert alert-success">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            } else if (data.type == 'warning' || data.type == 'info') {
                $('<div class=\"alert-box\"><div class="alert alert-info">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            } else {
                $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            }
        },
        error: function error(data) {
            $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
        }
    });
});

$('.cart-btn').click(function(e) {
    e.preventDefault();
    var csrf = $('meta[name=csrf-token]').attr("content");
    var product = $(this).data('product');
    $.ajax({
        /* the route pointing to the post function */
        url: '/cart/add',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {_token: csrf, product: product},
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function success(data) {
            if (data.type == 'success') {
                $('<div class=\"alert-box\"><div class="alert alert-success">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            } else if (data.type == 'warning' || data.type == 'info') {
                $('<div class=\"alert-box\"><div class="alert alert-info">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            } else {
                $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            }
        },
        error: function error(data) {
            $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
        }
    });
});

$('.rm-cart-btn').click(function(e) {
    e.preventDefault();
    var csrf = $('meta[name=csrf-token]').attr("content");
    var product = $(this).data('product');
    var target = $(this).data('target');
    if (confirm('Are you sure?')) {
        $.ajax({
            /* the route pointing to the post function */
            url: '/cart/remove',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: csrf, product: product, target: target},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) { 
                // $(".writeinfo").append(data.msg); 
                $(data.target).fadeOut("normal", function() { $(this).remove(); } );
                $('<div class=\"alert-box\"><div class="alert alert-success">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            }
        });
    } 
    return false;
});

$('.rm-wishlist-btn').click(function(e) {
    e.preventDefault();
    var csrf = $('meta[name=csrf-token]').attr("content");
    var product = $(this).data('product');
    var target = $(this).data('target');
    if (confirm('Are you sure?')) {
        $.ajax({
            /* the route pointing to the post function */
            url: '/wishlists/remove',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: csrf, product: product, target: target},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) { 
                // $(".writeinfo").append(data.msg); 
                $(data.target).fadeOut("normal", function() { $(this).remove(); } );
                $('<div class=\"alert-box\"><div class="alert alert-success">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
            }
        });
    } 
    return false;
});

var initProvinceSelect = function() {
    if ($('#receiver_province').length) {
        $('#receiver_province').change(function() {
            var csrf = $('meta[name=csrf-token]').attr("content");
            var province = $(this).val();
            $('#receiver_city').parent().remove();
            $.ajax({
                /* the route pointing to the post function */
                url: '/cart/get-city',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: csrf, province: province},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function success(data) {
                    if (data.type == 'success') {
                        var select = '<select id="receiver_city" name="receiver_city">';
                        $.each(data.data, function (key, value) {
                            select += '<option value="' + value.name + '">' + value.name + '</option>';
                        });
                        select += '</select>';
                        $(select).insertAfter('#receiver_city_label');
                        $('#receiver_city').material_select();
                        initCitySelect();
                    }
                },
                error: function error(data) {
                    $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
                }
            });
        });
    }
}

var initCitySelect = function () {
    if ($('#receiver_city').length) {
        $('#receiver_city').change(function() {
            var csrf = $('meta[name=csrf-token]').attr("content");
            var city = $(this).val();
            $('#receiver_district').parent().remove();
            $.ajax({
                /* the route pointing to the post function */
                url: '/cart/get-district',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: csrf, city: city},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function success(data) {
                    if (data.type == 'success') {
                        var select = '<select id="receiver_district" name="receiver_district">';
                        $.each(data.data, function (key, value) {
                            select += '<option value="' + value.code + '">' + value.name + '</option>';
                        });
                        select += '</select>';
                        $(select).insertAfter('#receiver_district_label');
                        $('#receiver_district').material_select();
                        initGetTariff();
                        initGetTariffShipper();
                    }
                },
                error: function error(data) {
                    $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
                }
            });
        });
    }
}

var initGetTariff = function () {
    if ($('#receiver_district').length) {
        $('#receiver_district').change(function() {
            var csrf     = $('meta[name=csrf-token]').attr("content");
            var code     = $(this).val();
            var weight   = $('#totalweight').data('weight');
            var delivery = $('#delivery_company').val();
            $('#shipping_fee').parent().remove();
            $.ajax({
                /* the route pointing to the post function */
                url: '/cart/get-tariff',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: csrf, code: code, weight: weight, delivery: delivery},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function success(data) {
                    if (data.type == 'success') {
                        var select = '<select id="shipping_fee" name="shipping_fee">';
                        $.each(data.data, function (key, value) {
                            select += '<option value="' + value + '">' + value + '</option>';
                        });
                        select += '</select>';
                        $(select).insertAfter('#shipping_fee_label');
                        $('#shipping_fee').material_select();
                    }
                },
                error: function error(data) {
                    $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
                }
            });
        });
    }
}

var initGetTariffShipper = function () {
    if ($('#delivery_company').length) {
        $('#delivery_company').change(function() {
            var csrf     = $('meta[name=csrf-token]').attr("content");
            var code     = $('receiver_district').val();
            var weight   = $('#totalweight').data('weight');
            var delivery = $(this).val();
            $('#shipping_fee').parent().remove();
            $.ajax({
                /* the route pointing to the post function */
                url: '/cart/get-tariff',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: csrf, code: code, weight: weight, delivery: delivery},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function success(data) {
                    if (data.type == 'success') {
                        var select = '<select id="shipping_fee" name="shipping_fee">';
                        $.each(data.data, function (key, value) {
                            select += '<option value="' + value + '">' + value + '</option>';
                        });
                        select += '</select>';
                        $(select).insertAfter('#shipping_fee_label');
                        $('#shipping_fee').material_select();
                    }
                },
                error: function error(data) {
                    $('<div class=\"alert-box\"><div class="alert alert-danger">' + data.message + '<span class="close" onclick="$(this).parent().fadeOut();">&times;</span> </div></div>').insertAfter('#app');
                }
            });
        });
    }
}


$(window).scroll(function(){
    var scroll = $(window).scrollTop(),
        brand  = $('.brand-logo img');

    if (scroll >= 50) {
        brand.addClass('img-sm');
    } else {
        brand.removeClass('img-sm');
    }
});

$(document).ready(function(){
    var artistSlider = $('.artist_slider__slider'),
        homeSlider = $('.home_hero__slider');
    var mode = {
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        fade: true,
        cssEase: 'linear',
        dots: false,
        prevArrow: false,
        nextArrow: false
    };
    if (artistSlider.length) {
        artistSlider.slick(mode);
    }
    if (homeSlider.length) {
        homeSlider.slick(mode);
    }

    $('ul.tabs').tabs();
    $('select').material_select();
    initProvinceSelect();
    initCitySelect();
});      
