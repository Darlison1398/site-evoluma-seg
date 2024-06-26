/**
* Template Name: Knight
* Updated: Mar 10 2023 with Bootstrap v5.2.3
* Template URL: https://bootstrapmade.com/knight-free-bootstrap-theme/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function () {
  "use strict";


  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    if (!header.classList.contains('header-scrolled')) {
      offset -= 16
    }

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Header fixed top on scroll
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    let headerOffset = selectHeader.offsetTop
    let nextElement = selectHeader.nextElementSibling
    const headerFixed = () => {
      if ((headerOffset - window.scrollY) <= 0) {
        selectHeader.classList.add('fixed-top')
        nextElement.classList.add('scrolled-offset')
      } else {
        selectHeader.classList.remove('fixed-top')
        nextElement.classList.remove('scrolled-offset')
      }
    }
    window.addEventListener('load', headerFixed)
    onscroll(document, headerFixed)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top', true)
  if (backtotop) {
    backtotop.map(e => {
      const toggleBacktotop = () => {
        if (window.scrollY > 100) {
          e.classList.add('active')
        } else {
          e.classList.remove('active')
        }
      }
      window.addEventListener('load', toggleBacktotop)
      onscroll(document, toggleBacktotop)
    });

  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function (e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function (e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function (e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function (e) {
        e.preventDefault();
        portfolioFilters.forEach(function (el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        portfolioIsotope.on('arrangeComplete', function () {
          AOS.refresh()
        });
      }, true);
    }

  });

  /**
   * Initiate portfolio lightbox 
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

  /**
   * Portfolio details slider
   */

  new Swiper(".carrossel", {
    a11y: {
      prevSlideMessage: 'Próximo',
      nextSlideMessage: 'Anterior',
    },
    loop: true,
    centerInsufficientSlides: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: true
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    // breakpoints: {

    //   1280: {
    //     slidesPerView: 1.5,
    //     spaceBetween: 5
    //   },
    //   1920: {
    //     slidesPerView: 2.5,
    //     spaceBetween: 5
    //   },
    //   2560: {
    //     slidesPerView: 3.5,
    //     spaceBetween: 5
    //   }
    // },
    // on: {
    //   click() {
    //     // console.log('index', this.clickedIndex);
    //     this.slideTo(this.clickedIndex);
    //     this.autoplay.stop();
    //   },
    // },
    // centeredSlides: true,
    // centeredSlidesBounds: true,



  });

  // new Swiper('.portfolio-details-slider', {
  //   // speed: 400,
  //   //height: 300,
  //   loop: true,
  //   centerInsufficientSlides: true,
  //   autoplay: {
  //     delay: 5000,
  //     disableOnInteraction: true
  //   },
  //   // pagination: {
  //   //   el: '.swiper-pagination',
  //   //   type: 'bullets',
  //   //   clickable: true
  //   // },
  //   // a11y: {
  //   //   enabled: true,
  //   //   prevSlideMessage: 'Previous slide',
  //   //   nextSlideMessage: 'Next slide',
  //   // },
  //   navigation: {
  //     nextEl: ".swiper-button-next",
  //     prevEl: ".swiper-button-prev",
  //   },
  //   // zoom: {
  //   //   maxRatio: 5,
  //   // },
  //   //parallax: true,
  //   //effect: 'creative',//'slide', 'fade', 'cube', 'coverflow', 'flip' or 'creative'
  //   // effect: 'flip',
  //   // flipEffect: {
  //   //   slideShadows: false,
  //   // },
  //   // effect: 'coverflow',
  //   // stretch: 300,
  // });

  /**
   * Testimonials slider
   */
  // new Swiper('.testimonials-slider', {
  //   speed: 600,
  //   loop: true,
  //   autoplay: {
  //     delay: 5000,
  //     disableOnInteraction: false
  //   },
  //   slidesPerView: 'auto',
  //   pagination: {
  //     el: '.swiper-pagination',
  //     type: 'bullets',
  //     clickable: true
  //   }
  // });

  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    })

    document.querySelectorAll('.share').forEach(e => {
      e.addEventListener('click', evt => {
        share(e.getAttribute("text"));
      })
    })
  });

  /*adm*/
  (() => {
    let t = select('#adm');
    if (t) t.addEventListener('dblclick', () => { window.open('/evoluma/adm', ''); });
    // t = select('#adm2');
    // if (t) t.addEventListener('dblclick', () => { window.open('../../adm', ''); });
  })();

  function share(text) {
    if (navigator.share !== undefined) {
      navigator.share({
        title: 'Grupo Evoluma',
        text: text.toUpperCase(),
        url: document.location.href,
      })
        // .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing', error));
    }
  }

})()


