/**
 * Gastrototem — Main JS
 */
(function () {
  'use strict';

  // Reveal on scroll
  var reveals = document.querySelectorAll('.reveal');
  if (reveals.length) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    reveals.forEach(function (el) { observer.observe(el); });
  }

  // FAQ accordion
  document.querySelectorAll('.faq-item__q').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.parentElement;
      var isOpen = item.classList.contains('open');

      document.querySelectorAll('.faq-item').forEach(function (i) { i.classList.remove('open'); });
      document.querySelectorAll('.faq-item__q').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });

      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  // Mobile nav toggle
  var navToggle = document.querySelector('.nav-toggle');
  var nav = document.querySelector('.site-nav');

  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var isOpen = nav.classList.toggle('open');
      navToggle.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        nav.classList.remove('open');
        navToggle.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }

  // Header shadow on scroll
  var header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.style.boxShadow = window.scrollY > 100
        ? '0 1px 0 rgba(255,255,255,0.05)'
        : 'none';
    }, { passive: true });
  }
})();
