// Ajax CSRF-Token initialization
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


//debounce
function debounce (callback, timeoutDelay = 500) {
    let timeoutId;

    return (...rest) => {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => callback.apply(this, rest), timeoutDelay);
    };
}


//card carousels
let cardCarousels = $('.card-carousel');
cardCarousels.owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        navText: ['<span class="material-icons-outlined">arrow_back_ios</span>', '<span class="material-icons-outlined">arrow_forward_ios</span>'],
        items: 1,
        dots: false,
        singleItem: true,
        autoHeight: true,
        transitionStyle: "fade"
});

//change carousel counter on carousel item change
cardCarousels.on('translated.owl.carousel', function(event) {
    let carouselSection = event.target.closest('.carousel-section');
    let counter = carouselSection.getElementsByClassName('carousel-section__counter-active');

    let activeItem = event.target.querySelector('.owl-item.active');
    let activeItemCard = activeItem.querySelector('.owl-carousel__item');

    counter[0].innerHTML = activeItemCard.dataset.carouselItemIndex;
})


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


//modals
document.querySelectorAll('[data-action="show-modal"]').forEach(item => {
    item.addEventListener('click', event => {
        document.getElementById(item.dataset.targetId).classList.add('modal--visible');
        document.body.style.overflowY = "hidden";
    });
});
//hide modals
document.querySelectorAll('[data-action="hide-modal"]').forEach(item => {
    item.addEventListener('click', event => {
        document.body.style.overflowY = "auto";
        document.getElementById(item.dataset.targetId).classList.remove('modal--visible');
    });
});
//Login Modals Register button
document.getElementById('login-modal-register-button').addEventListener('click', event => {
    document.getElementById('register-modal').classList.add('modal--visible');
    document.getElementById('login-modal').classList.remove('modal--visible');
})
// Login Modals Forgot Password button
document.getElementById('login-modal-forgot-password').addEventListener('click', event => {
    document.getElementById('forgot-password-modal').classList.add('modal--visible');
    document.getElementById('login-modal').classList.remove('modal--visible');
})


let spinner = document.getElementById('spinner');

//Ajax Register
let registerForm = document.getElementById('register-form');
if (registerForm) {
    registerForm.addEventListener('submit', event => {
        event.preventDefault();
        spinner.classList.add('spinner--show');

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/register',
            data: new FormData(registerForm),
            processData: false,
            contentType: false,
            success: function (response) {
                //reload page on success
                if (response.validation == 'success') {
                    window.location.reload();
                } else if (response.validation == 'failed') {
                    //else display error messages
                    let errorsList = registerForm.getElementsByClassName('modal-form-errors')[0];
                    errorsList.innerHTML = '';
                    for (let message of response.errorMessages) {
                        errorsList.innerHTML += `<li>${message}</li>`
                    };

                    //unhighlight all previous failed inputs
                    let failedInputs = registerForm.getElementsByClassName('modal-input--error');
                    for (let failedInput of failedInputs) {
                        failedInput.classList.remove('modal-input--error');
                    }
                    //highlight failed inputs
                    for (let failedInput of response.failedInputs) {
                        registerForm.querySelector(`[name="${failedInput}"]`).classList.add('modal-input--error');
                    }
                }

                spinner.classList.remove('spinner--show');
            },
            error: function () {
                spinner.classList.remove('spinner--show');
                console.log('Ajax register failed !');
            }
        });
    });
};


//Ajax Login
let loginForm = document.getElementById('login-form');
if (loginForm) {
    loginForm.addEventListener('submit', event => {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/login',
            data: new FormData(loginForm),
            processData: false,
            contentType: false,
            success: function (response) {
                //reload page on success
                if (response == 'success') {
                    window.location.reload();
                } else if (response == 'failed') {
                    //else display error messages
                    let errorsList = loginForm.getElementsByClassName('modal-form-errors')[0];
                    errorsList.innerHTML = '<li>Неверный логин или пароль</li>';
                }
            },
            error: function () {
                console.log('Ajax login failed !');
            }
        });

    });
};


//Ajax Verification Resend Email
let verificationResendForm = document.getElementById('verification-resend-email-form');
if (verificationResendForm) {
    verificationResendForm.addEventListener('submit', event => {
        event.preventDefault();
        spinner.classList.add('spinner--show');

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/resend-email',
            data: new FormData(verificationResendForm),
            processData: false,
            contentType: false,
            success: function () {
                window.location.reload();
                spinner.classList.remove('spinner--show');
            },
            error: function () {
                spinner.classList.remove('spinner--show');
                console.log('Ajax Verification Resend Email failed !');
            }
        });

    });
};


//Ajax Forgot Password
let forgotPasswordForm = document.getElementById('forgot-password-form');
if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', event => {
        event.preventDefault();
        spinner.classList.add('spinner--show');

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/forgot-password',
            data: new FormData(forgotPasswordForm),
            processData: false,
            contentType: false,
            success: function (response) {
                //reload page on success
                if (response == 'success') {
                    window.location.reload();
                } else if (response == 'failed') {
                    //else display error messages
                    let errorsList = forgotPasswordForm.getElementsByClassName('modal-form-errors')[0];
                    errorsList.innerHTML = '<li>Пользователь с такой электронной почтой не существует!</li>';
                }

                spinner.classList.remove('spinner--show');
            },
            error: function () {
                spinner.classList.remove('spinner--show');
                console.log('Ajax forgot password failed !');
            }
        });

    });
};


//Aside categories search
let asideSearchInput = document.getElementById('aside-search-input');
if (asideSearchInput) {
    let categoryEls = document.querySelectorAll('.aside-categories__item');

    asideSearchInput.addEventListener('input', debounce((evt) => {
        categoryEls.forEach(item => {
            item.children[0].textContent.toLowerCase().includes(evt.target.value.toLowerCase()) ? item.style.display = '' : item.style.display = 'none';
        });
    }));
}


//--------------- Categories Filter & search start---------------
//run AJAX function to update quotes or authors list on any filters checkbox change
document.querySelectorAll('.categories-filter__checkbox').forEach(item => {
    item.addEventListener('change', event => {
        let filterForm = document.getElementById('categories-filter-form');
        let allCategoriesChb = document.getElementById('all-categories-checkbox');

        // on show hidden categories click
        if (item.id == 'show-hidden-categories-checkbox') {
            let checkboxes = document.getElementsByClassName('categories-filter__checkbox--hidden');

            for (chb of checkboxes) {
                chb.classList.remove('categories-filter__checkbox--hidden');
            }

            item.classList.add('categories-filter__checkbox--hidden');
        }

        // on any category click
        else if (item.id != 'all-categories-checkbox') {
            let checkedChbs = filterForm.querySelectorAll('input[name=category_id]:checked');
            // check or uncheck all categories checkbox
            if (checkedChbs.length) {
                allCategoriesChb.checked = false;
            } else {
                allCategoriesChb.checked = true;
            }
        }

        // on All categories click
        else if (item.id == 'all-categories-checkbox') {
            // disable checked false statement while clicking on checked statement
            let checkboxes = filterForm.querySelectorAll('input[name=category_id]:checked');
            item.checked = true;
            // uncheck all other checked categories
            for (chb of checkboxes) {
                if (chb.id != 'show-hidden-categories-checkbox') {
                    chb.checked = false;                    
                }
            }
        }

        //run AJAX function to update items list
        let model = filterForm.dataset.model;

        if (model == 'quote') {
            getQuotes();
        } else if (model == 'author') {
            getAuthors();
        }
    });
});

//run AJAX function to update quotes or authors list on search input value change
let catSearchInput = document.getElementById('categories-filter-search-input');
if (catSearchInput) {
    catSearchInput.addEventListener('input', debounce(event => {
        let filterForm = document.getElementById('categories-filter-form');
        let model = filterForm.dataset.model;

        if (model == 'quote') {
            getQuotes();
        } else if (model == 'author') {
            getAuthors();
        }
    }));
}


//AJAX Quotes list update function (on categories filter or search values change)
let quotesList = document.getElementById('quotes-list');
function getQuotes() {
    let filterForm = document.getElementById('categories-filter-form');
    let formData = new FormData(filterForm);

    //append joined arrays into FormData because FormData doesnt support arrays   
    let categoryIds = formData.getAll('category_id');
    let joinedIds = categoryIds.join('-');
    formData.append('category_id', joinedIds);

    $.ajax({
        type: "POST",
        enctype: "multipart/form-data",
        url: filterForm.action,
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            quotesList.innerHTML = response;

            //reinitialize yandex share buttons
            quotesList.querySelectorAll('.ya-share2').forEach(item => {
                Ya.share2(item, {});
            })
        },

        error: function () {
            console.log("Quotes ajax filter error!");
        }
    });
}


//AJAX Authors list update function (on categories filter or search values change)
let authorsList = document.getElementById('authors-list');
function getAuthors() {
    let filterForm = document.getElementById('categories-filter-form');
    let formData = new FormData(filterForm);

    //append joined arrays into FormData because FormData doesnt support arrays   
    let categoryIds = formData.getAll('category_id');
    let joinedIds = categoryIds.join('-');
    formData.append('category_id', joinedIds);

    $.ajax({
        type: "POST",
        enctype: "multipart/form-data",
        url: filterForm.action,
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            authorsList.innerHTML = response;

            //reinitialize yandex share buttons
            authorsList.querySelectorAll('.ya-share2').forEach(item => {
                Ya.share2(item, {});
            })
        },

        error: function () {
            console.log("Authors ajax filter error!");
        }

    });
}
//--------------- Categories Filter & search start---------------


//------------- Like and Favorite actions-------------
document.body.addEventListener('click', function (evt) {
    if (evt.target.dataset.action == 'like') {
        like(evt.target);
    } else if (evt.target.dataset.action == 'favorite') {
        favorite(evt.target);
    }
});

function like(target) {
    $.ajax({
        type: 'POST',
        url: '/like',
        data: {quote_id: target.dataset.quoteId, author_id: target.dataset.authorId},

        success: function (response) {
            //change like button for all of the identic cards
            let parentCard = target.closest('.card');

            document.querySelectorAll('[data-card-id="' + parentCard.dataset.cardId + '"]').forEach(item => {
                let likeIcon = item.getElementsByClassName('card__actions-like-icon')[0];
                let likesCount = item.getElementsByClassName('card__actions-like-counter')[0];
    
                likesCount.innerHTML = response.likesCount;
                if (response.status == 'liked') {
                    likeIcon.innerHTML = 'favorite';
                } else if (response.status == 'unliked') {
                    likeIcon.innerHTML = 'favorite_border';
                }
            });
        },

        error: function () {
            console.log("Ajax like error!");
        }

    });
}

function favorite(target) {
    $.ajax({
        type: 'POST',
        url: '/favorite',
        data: {quote_id: target.dataset.quoteId, author_id: target.dataset.authorId},

        success: function (response) {
            //change favorite button for all of the identic cards
            let parentCard = target.closest('.card');

            document.querySelectorAll('[data-card-id="' + parentCard.dataset.cardId + '"]').forEach(item => {
                let favoriteIcon = item.getElementsByClassName('card__actions-favorite-icon')[0];

                if (response.status == 'added-into-favorites') {
                    favoriteIcon.classList = 'material-icons card__actions-favorite-icon';
                } else if (response.status == 'removed-from-favorites') {
                    favoriteIcon.classList = 'material-icons-outlined card__actions-favorite-icon';
                }
            });
        },

        error: function () {
            console.log("Ajax favorite error!");
        }

    });
}
//------------- Like and Favorite actions-------------