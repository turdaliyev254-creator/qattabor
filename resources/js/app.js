import './bootstrap';

// Page Transition Effects
document.addEventListener('DOMContentLoaded', function() {
    
    // Add smooth page transitions on link clicks
    const addPageTransition = () => {
        const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"]):not([data-no-transition])');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if it's a special link
                if (!href || href === '#' || href.startsWith('javascript:') || this.hasAttribute('data-no-transition')) {
                    return;
                }
                
                // Prevent default for internal links
                if (href.startsWith('/') || href.includes(window.location.hostname)) {
                    e.preventDefault();
                    
                    // Add fade-out animation
                    document.body.style.opacity = '0';
                    document.body.style.transform = 'translateY(-10px)';
                    document.body.style.transition = 'all 0.3s ease-out';
                    
                    // Navigate after animation
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                }
            });
        });
    };
    
    // Initialize page transitions
    addPageTransition();
    
    // Fade in page on load
    document.body.style.opacity = '1';
    document.body.style.transform = 'translateY(0)';
    
    // Burger menu functionality
    const burger = document.querySelector('.navbar-burger');
    const menu = document.querySelector('.navbar-menu');
    
    if (burger) {
        burger.addEventListener('click', function() {
            burger.classList.toggle('is-active');
            if (menu) {
                menu.classList.toggle('is-active');
            }
        });
    }
    
    // Mobile menu toggle for any burger
    const burgers = document.querySelectorAll('.burger, .menu-toggle, .navbar-burger');
    burgers.forEach(burger => {
        burger.addEventListener('click', function() {
            const target = this.dataset.target;
            const targetMenu = document.getElementById(target) || document.querySelector('.mobile-menu, .navbar-menu');
            
            if (targetMenu) {
                this.classList.toggle('is-active');
                targetMenu.classList.toggle('is-active');
            }
        });
    });
    
    // Theme switcher
    const themeToggles = document.querySelectorAll('[data-theme-toggle]');
    themeToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    });
    
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    // Language switcher dropdown
    const langToggles = document.querySelectorAll('.language-toggle, .lang-toggle');
    langToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling || this.parentElement.querySelector('.dropdown-menu');
            if (dropdown) {
                dropdown.classList.toggle('is-active');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('is-active');
            });
        }
    });
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
