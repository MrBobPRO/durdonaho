// Ajax CSRF-Token initialization
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.onload = function () {
    $('.card-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        navText: ['<span class="material-icons-outlined">arrow_back_ios</span>', '<span class="material-icons-outlined">arrow_forward_ios</span>'],
        items: 1,
        dots: false,
        singleItem : true,
        autoHeight : true,
        transitionStyle:"fade"
    });
}
