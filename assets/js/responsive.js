/**
 * Responsive Helper Functions
 * Enhances mobile experience for the ERP system
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        // Initialize responsive features
        handleSidebarOverlay();
        handleTableResponsive();
        handleWindowResize();
        handleTouchGestures();
        preventZoomOnInputFocus();
    }

    /**
     * Handle sidebar overlay click to close on mobile
     */
    function handleSidebarOverlay() {
        const overlay = document.querySelector('.app-sidebar__overlay');
        if (overlay) {
            overlay.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    document.body.classList.remove('main-sidebar-show');
                    document.body.classList.remove('sidenav-toggled');
                    if (overlay.classList) {
                        overlay.classList.remove('show');
                    }
                }
            });
        }
    }

    /**
     * Make tables horizontally scrollable on mobile
     */
    function handleTableResponsive() {
        const tables = document.querySelectorAll('table:not(.table-responsive)');
        tables.forEach(function(table) {
            // Check if table is wider than viewport
            if (table.scrollWidth > window.innerWidth) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
    }

    /**
     * Handle window resize events
     */
    function handleWindowResize() {
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Re-check table responsiveness
                handleTableResponsive();

                // Close sidebar on mobile when resizing to desktop
                if (window.innerWidth > 991) {
                    document.body.classList.remove('main-sidebar-show');
                    const overlay = document.querySelector('.app-sidebar__overlay');
                    if (overlay && overlay.classList) {
                        overlay.classList.remove('show');
                    }
                }
            }, 250);
        });
    }

    /**
     * Handle touch gestures for better mobile UX
     */
    function handleTouchGestures() {
        let touchStartX = 0;
        let touchEndX = 0;
        const minSwipeDistance = 50;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeDistance = touchEndX - touchStartX;

            // Swipe right to open sidebar (only on mobile)
            if (swipeDistance > minSwipeDistance && window.innerWidth <= 991) {
                const sidebar = document.querySelector('.main-sidebar');
                if (sidebar && !document.body.classList.contains('main-sidebar-show')) {
                    // Only if swiping from left edge
                    if (touchStartX < 50) {
                        document.body.classList.add('main-sidebar-show');
                        const overlay = document.querySelector('.app-sidebar__overlay');
                        if (overlay && overlay.classList) {
                            overlay.classList.add('show');
                        }
                    }
                }
            }

            // Swipe left to close sidebar
            if (swipeDistance < -minSwipeDistance && window.innerWidth <= 991) {
                if (document.body.classList.contains('main-sidebar-show')) {
                    document.body.classList.remove('main-sidebar-show');
                    const overlay = document.querySelector('.app-sidebar__overlay');
                    if (overlay && overlay.classList) {
                        overlay.classList.remove('show');
                    }
                }
            }
        }
    }

    /**
     * Prevent zoom on input focus in iOS (but allow manual zoom)
     * Note: This is handled by CSS font-size: 16px, but we add a fallback
     */
    function preventZoomOnInputFocus() {
        if (/iPhone|iPad|iPod/.test(navigator.userAgent)) {
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                // Ensure font-size is at least 16px to prevent zoom
                const computedStyle = window.getComputedStyle(input);
                const fontSize = parseFloat(computedStyle.fontSize);
                if (fontSize < 16) {
                    input.style.fontSize = '16px';
                }
            });
        }
    }

    /**
     * Utility function to check if device is mobile
     */
    window.isMobileDevice = function() {
        return window.innerWidth <= 991;
    };

    /**
     * Utility function to check if device is tablet
     */
    window.isTabletDevice = function() {
        return window.innerWidth > 576 && window.innerWidth <= 991;
    };

    /**
     * Utility function to check if device is desktop
     */
    window.isDesktopDevice = function() {
        return window.innerWidth > 991;
    };

})();

