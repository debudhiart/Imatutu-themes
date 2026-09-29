/**
 * Imatutu Theme - Builder Frontend Interactivity
 *
 * Implements:
 * 1. Accessible Accordion with smooth slide toggle
 * 2. Animated Counter with IntersectionObserver (Stats & Builder Counters)
 * 3. Modern Responsive Image Lightbox Modal
 *
 * @package Imatutu
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // =============================================================
    // 1. Accessible Accordion with Smooth Sliding
    // =============================================================
    const accordionHeaders = document.querySelectorAll('.builder-accordion-header');

    accordionHeaders.forEach(function(header) {
        header.addEventListener('click', function() {
            const currentItem = this.closest('.builder-accordion-item');
            const currentBody = this.nextElementSibling;
            const currentIcon = this.querySelector('.accordion-icon');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Optional: Close siblings in the same group
            const group = this.closest('.builder-accordion-group');
            if (group) {
                const openSiblings = group.querySelectorAll('.builder-accordion-item.is-open');
                openSiblings.forEach(function(sibling) {
                    if (sibling !== currentItem) {
                        sibling.classList.remove('is-open');
                        const sibHeader = sibling.querySelector('.builder-accordion-header');
                        const sibBody = sibling.querySelector('.builder-accordion-body');
                        const sibIcon = sibling.querySelector('.accordion-icon');
                        if (sibHeader) sibHeader.setAttribute('aria-expanded', 'false');
                        if (sibBody) {
                            sibBody.style.maxHeight = '0px';
                            setTimeout(function() {
                                sibBody.style.display = 'none';
                            }, 250);
                        }
                        if (sibIcon) sibIcon.innerText = '+';
                    }
                });
            }

            if (isExpanded) {
                // Collapse
                currentItem.classList.remove('is-open');
                this.setAttribute('aria-expanded', 'false');
                if (currentIcon) currentIcon.innerText = '+';
                currentBody.style.maxHeight = '0px';
                setTimeout(function() {
                    currentBody.style.display = 'none';
                }, 250);
            } else {
                // Expand
                currentItem.classList.add('is-open');
                this.setAttribute('aria-expanded', 'true');
                if (currentIcon) currentIcon.innerText = '−';
                currentBody.style.display = 'block';
                currentBody.style.maxHeight = currentBody.scrollHeight + 'px';
            }
        });
    });

    // =============================================================
    // 2. Animated Counter Engine (IntersectionObserver)
    // =============================================================
    const counterElements = document.querySelectorAll('.stat-number, .builder-counter-val');

    if ('IntersectionObserver' in window && counterElements.length > 0) {
        const counterObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });

        counterElements.forEach(function(el) {
            counterObserver.observe(el);
        });
    }

    function animateCounter(el) {
        const originalText = el.innerText.trim();
        // Regex parse: optional prefix, digits (with optional decimal), optional suffix
        const match = originalText.match(/^([^0-9]*)([0-9]+(?:\.[0-9]+)?)(.*)$/);
        if (!match) return; // Complex string, preserve as is

        const prefix = match[1] || '';
        const targetValue = parseFloat(match[2]);
        const suffix = match[3] || '';
        const isDecimal = match[2].includes('.');
        const decimalPlaces = isDecimal ? match[2].split('.')[1].length : 0;

        const duration = 1400; // ms
        const startTime = performance.now();

        function updateNumber(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease-out quadratic
            const easeProgress = 1 - (1 - progress) * (1 - progress);
            const currentNum = targetValue * easeProgress;

            const formattedNum = isDecimal ? currentNum.toFixed(decimalPlaces) : Math.floor(currentNum);
            el.innerText = prefix + formattedNum + suffix;

            if (progress < 1) {
                requestAnimationFrame(updateNumber);
            } else {
                el.innerText = originalText;
            }
        }

        requestAnimationFrame(updateNumber);
    }

    // =============================================================
    // 3. Responsive Image Lightbox Modal
    // =============================================================
    const lightboxTriggers = document.querySelectorAll('.builder-lightbox-trigger');

    if (lightboxTriggers.length > 0) {
        let lightboxOverlay = document.getElementById('builder-lightbox-modal');

        if (!lightboxOverlay) {
            lightboxOverlay = document.createElement('div');
            lightboxOverlay.id = 'builder-lightbox-modal';
            lightboxOverlay.className = 'builder-lightbox-overlay';
            lightboxOverlay.setAttribute('role', 'dialog');
            lightboxOverlay.setAttribute('aria-modal', 'true');
            lightboxOverlay.innerHTML = `
                <div class="builder-lightbox-container">
                    <button class="builder-lightbox-close" aria-label="Close Lightbox">&times;</button>
                    <img class="builder-lightbox-image" src="" alt="" />
                    <div class="builder-lightbox-caption"></div>
                </div>
            `;
            document.body.appendChild(lightboxOverlay);

            // Close events
            const closeBtn = lightboxOverlay.querySelector('.builder-lightbox-close');
            function closeLightbox() {
                lightboxOverlay.classList.remove('is-active');
                document.body.style.overflow = '';
            }

            if (closeBtn) closeBtn.addEventListener('click', closeLightbox);

            lightboxOverlay.addEventListener('click', function(e) {
                if (e.target === lightboxOverlay) {
                    closeLightbox();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && lightboxOverlay.classList.contains('is-active')) {
                    closeLightbox();
                }
            });
        }

        const modalImg = lightboxOverlay.querySelector('.builder-lightbox-image');
        const modalCaption = lightboxOverlay.querySelector('.builder-lightbox-caption');

        lightboxTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const imgSrc = this.getAttribute('href');
                const captionText = this.getAttribute('data-caption') || '';

                if (modalImg) {
                    modalImg.src = imgSrc;
                    modalImg.alt = captionText;
                }
                if (modalCaption) {
                    modalCaption.innerText = captionText;
                    modalCaption.style.display = captionText ? 'block' : 'none';
                }

                lightboxOverlay.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            });
        });
    }
});
