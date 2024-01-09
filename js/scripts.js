/*!
* Start Bootstrap - Grayscale v7.0.5 (https://startbootstrap.com/theme/grayscale)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-grayscale/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 74,
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

function filterCupons(filterType) {
    let cupons = document.getElementsByClassName("cupon");
    let id = 0;
    do {
        document.getElementById(id).className = 'dropdown-item';
        id++;
    } while (document.getElementById(id) != null);

    for (let i = 0; i < cupons.length; i++) {

        if (filterType == 0 || cupons[i].getAttribute('value') == filterType) {
            cupons[i].style.display = "block";
            cupons[i].classList.add("d-flex");
        } else {
            cupons[i].classList.remove("d-flex");
            cupons[i].style.display = "none";
        }
    }
    document.getElementById(filterType).className += ' active';
}

function onReedemCupon(cupon_id) {
    $.ajax({
		url: "insert.php",
		type: "POST",
		data: {
			id: cupon_id	
		}
	});
    
    Swal.fire({
        title: 'Gutschein eingelöst',
        html: '',
        icon: 'success',
        confirmButtonText: 'Weiter',
    });

    console.log(cupon_id);
}

function onNotReedemCupon() {
    Swal.fire({
        title: 'Gutschein nicht gültig!',
        html: '',
        icon: 'error',
        confirmButtonText: 'Weiter',
    });
}