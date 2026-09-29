/**
 * Imatutu Theme - Builder Frontend Interactivity
 *
 * @package Imatutu
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // -------------------------------------------------------------
    // Accordion / FAQ Toggle Handler
    // -------------------------------------------------------------
    const accordionHeaders = document.querySelectorAll('.builder-accordion-header');

    accordionHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            const body = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                body.style.display = 'none';
                this.setAttribute('aria-expanded', 'false');
                if (icon) icon.innerText = '+';
            } else {
                body.style.display = 'block';
                this.setAttribute('aria-expanded', 'true');
                if (icon) icon.innerText = '−';
            }
        });
    });
});
