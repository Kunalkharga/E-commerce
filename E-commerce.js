// Mobile Menu Toggle
document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
  document.querySelector('.nav-links').classList.toggle('active');
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', function() {
      document.querySelector('.nav-links').classList.remove('active');
  });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
      });
  });
});

// Dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // Desktop hover functionality
    if (window.innerWidth > 768) {
      dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
          e.preventDefault(); // Prevent default only for desktop
        });
      });
    }
    
    // Mobile click functionality
    if (window.innerWidth <= 768) {
      dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
          e.preventDefault();
          const dropdown = toggle.parentElement;
          dropdown.classList.toggle('active');
          
          // Close other open dropdowns
          document.querySelectorAll('.dropdown').forEach(item => {
            if (item !== dropdown) {
              item.classList.remove('active');
            }
          });
        });
      });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        // Reset all dropdowns when switching to desktop
        document.querySelectorAll('.dropdown').forEach(item => {
          item.classList.remove('active');
        });
      }
    });
  });


  // Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.querySelector('.fa-search').parentElement;
    const searchContainer = document.querySelector('.search-container');
    const closeSearch = document.querySelector('.close-search');
    const navbar = document.querySelector('.navbar');
    
    // Toggle search box
    searchIcon.addEventListener('click', function(e) {
      e.preventDefault();
      document.body.classList.add('search-active');
      searchContainer.classList.add('active');
      // Focus input field after animation starts
      setTimeout(() => {
        searchContainer.querySelector('input').focus();
      }, 300);
    });
    
    // Close search box
    closeSearch.addEventListener('click', function() {
      document.body.classList.remove('search-active');
      searchContainer.classList.remove('active');
    });
    
    // Close when clicking outside (optional)
    document.addEventListener('click', function(e) {
      if (!searchContainer.contains(e.target) && !searchIcon.contains(e.target)) {
        if (searchContainer.classList.contains('active')) {
          document.body.classList.remove('search-active');
          searchContainer.classList.remove('active');
        }
      }
    });
    
    // Prevent closing when clicking inside search box
    searchContainer.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });
