import './bootstrap';

// Burger menu functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Burger menu toggle
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
