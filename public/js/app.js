// Ajax CSRF-Token initialization
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


//card carousel
window.onload = function () {
    $('.card-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        navText: ['<span class="material-icons-outlined">arrow_back_ios</span>', '<span class="material-icons-outlined">arrow_forward_ios</span>'],
        items: 1,
        dots: false,
        singleItem : true,
        autoHeight : true,
        transitionStyle:"fade"
    });
}


//dropdown
document.querySelectorAll('.dropdown__button').forEach(item => {
    item.addEventListener('click', event => {
        item.closest('.dropdown').classList.add('dropdown--opened');
    })
})

document.querySelectorAll('.dropdown__background').forEach(item => {
    item.addEventListener('click', event => {
        item.closest('.dropdown').classList.remove('dropdown--opened');
    })
})