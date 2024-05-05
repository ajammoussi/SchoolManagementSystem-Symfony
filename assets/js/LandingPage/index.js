var swiper = new Swiper(".swiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 100,
      modifier: 3,
      slideShadows: true
    },
    keyboard: {
      enabled: true
    },
    mousewheel: {
      thresholdDelta: 70
    },
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    autoplay: {
        delay: 4000, 
        disableOnInteraction: false, 
    },
    breakpoints: {
      640: {
        slidesPerView: 2
      },
      768: {
        slidesPerView: 1
      },
      1024: {
        slidesPerView: 2
      },
      1560: {
        slidesPerView: 3
      }
    }
  });

  // this function is for the animation when the eleents are in view
  document.addEventListener("DOMContentLoaded", function() {
    var elements1 = Array.from(document.querySelectorAll('.swiper'));
    var elements2 = Array.from(document.querySelectorAll('.discover-fields-of-study'));
    var elements = elements1.concat(elements2);
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target);
        }
      });
    });
    elements.forEach(function(element) {
      observer.observe(element);
    });
  });