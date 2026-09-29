/**
 * Imatutu Modern Corporate - Main JavaScript
 * Vanilla JS implementation for interactive components
 *
 * @package Imatutu
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // -------------------------------------------------------------
    // 1. Sticky Header Scroll Effect
    // -------------------------------------------------------------
    const masthead = document.getElementById('masthead');
    
    function handleHeaderScroll() {
        if (!masthead) return;
        if (window.scrollY > 40) {
            masthead.classList.add('is-scrolled');
        } else {
            masthead.classList.remove('is-scrolled');
        }
    }

    window.addEventListener('scroll', handleHeaderScroll, { passive: true });
    handleHeaderScroll(); // Initialize on page load

    // -------------------------------------------------------------
    // 2. Mobile Navigation Drawer
    // -------------------------------------------------------------
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileDrawer = document.getElementById('mobile-navigation');
    const mobileCloseBtn = document.getElementById('mobile-menu-close');
    const mobileOverlay = document.getElementById('mobile-drawer-overlay');

    function openMobileMenu() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.add('is-active');
        mobileDrawer.setAttribute('aria-hidden', 'false');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('is-active');
        mobileDrawer.setAttribute('aria-hidden', 'true');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', (e) => {
            e.preventDefault();
            openMobileMenu();
        });
    }

    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeMobileMenu();
        });
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileMenu);
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileDrawer && mobileDrawer.classList.contains('is-active')) {
            closeMobileMenu();
        }
    });

    // Close when clicking internal mobile menu links
    const mobileLinks = document.querySelectorAll('.mobile-nav-content a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMobileMenu();
        });
    });

    // -------------------------------------------------------------
    // 3. Smooth Scroll for Anchor Links
    // -------------------------------------------------------------
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const headerOffset = (masthead ? masthead.offsetHeight : 80) + 10;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});
