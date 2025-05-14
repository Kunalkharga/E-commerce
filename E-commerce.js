// Mobile Menu Toggle
document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
  document.querySelector('.nav-links').classList.toggle('active');
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', function () {
    document.querySelector('.nav-links').classList.remove('active');
  });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Dropdown functionality
document.addEventListener('DOMContentLoaded', function () {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

  // Desktop hover functionality
  if (window.innerWidth > 768) {
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        // e.preventDefault(); // Prevent default only for desktop
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
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
      // Reset all dropdowns when switching to desktop
      document.querySelectorAll('.dropdown').forEach(item => {
        item.classList.remove('active');
      });
    }
  });
});


// Search functionality
document.addEventListener('DOMContentLoaded', function () {
  const searchIcon = document.querySelector('.fa-search').parentElement;
  const searchContainer = document.querySelector('.search-container');
  const closeSearch = document.querySelector('.close-search');
  const navbar = document.querySelector('.navbar');

  // Toggle search box
  searchIcon.addEventListener('click', function (e) {
    e.preventDefault();
    document.body.classList.add('search-active');
    searchContainer.classList.add('active');
    // Focus input field after animation starts
    setTimeout(() => {
      searchContainer.querySelector('input').focus();
    }, 300);
  });

  // Close search box
  closeSearch.addEventListener('click', function () {
    document.body.classList.remove('search-active');
    searchContainer.classList.remove('active');
  });

  // Close when clicking outside (optional)
  document.addEventListener('click', function (e) {
    if (!searchContainer.contains(e.target) && !searchIcon.contains(e.target)) {
      if (searchContainer.classList.contains('active')) {
        document.body.classList.remove('search-active');
        searchContainer.classList.remove('active');
      }
    }
  });

  // Prevent closing when clicking inside search box
  searchContainer.addEventListener('click', function (e) {
    e.stopPropagation();
  });
});


// Quantity Selector Functionality
document.addEventListener('DOMContentLoaded', function () {
  // Quantity controls
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const input = this.parentElement.querySelector('.quantity-input');
      let value = parseInt(input.value);

      if (this.classList.contains('minus')) {
        value = value > 1 ? value - 1 : 1;
      } else if (this.classList.contains('plus')) {
        value = value < 10 ? value + 1 : 10;
      }

      input.value = value;
    });
  });

  // Updated add-to-cart with quantity
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
      const productCard = this.closest('.product-card');
      const productName = productCard.querySelector('.product-name').textContent;
      const productPrice = productCard.querySelector('.product-price').textContent.split(' ')[0];
      const quantity = productCard.querySelector('.quantity-input').value;

      console.log(`Added ${quantity}x ${productName} to cart (Total: $${(parseFloat(productPrice.replace('$', '')) * quantity).toFixed(2)})`);

      // Visual feedback
      this.innerHTML = '<i class="fas fa-check"></i> Added!';
      this.style.backgroundColor = '#4CAF50';

      setTimeout(() => {
        this.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
        this.style.backgroundColor = '#F9942A';
      }, 2000);
    });
  });
});


/***********************
 DOG AGE CALCULATOR 
***********************/
document.addEventListener('DOMContentLoaded', function () {
  // Only run this code on calculator page
  if (document.getElementById('calculate-btn')) {
    const calculateBtn = document.getElementById('calculate-btn');
    const resultDiv = document.getElementById('result');
    const resultContainer = document.getElementById('result-container');

    calculateBtn.addEventListener('click', function () {
      const dogAge = parseInt(document.getElementById('dog-age').value);
      const dogSize = document.getElementById('dog-size').value;

      // Input validation
      if (isNaN(dogAge)) {
        resultDiv.innerHTML = 'Please enter a valid age';
        return;
      }

      if (dogAge < 1 || dogAge > 30) {
        resultDiv.innerHTML = 'Please enter an age between 1 and 30';
        return;
      }

      // Calculate human age
      let humanAge;
      if (dogSize === 'small') {
        humanAge = dogAge <= 2 ? dogAge * 12.5 : 25 + (dogAge - 2) * 4.5;
      } else if (dogSize === 'medium') {
        humanAge = dogAge <= 2 ? dogAge * 10.5 : 21 + (dogAge - 2) * 5;
      } else if (dogSize === 'large') {
        humanAge = dogAge <= 2 ? dogAge * 9 : 18 + (dogAge - 2) * 6;
      } else { // giant
        humanAge = dogAge <= 2 ? dogAge * 8 : 16 + (dogAge - 2) * 7.5;
      }

      humanAge = Math.round(humanAge);

      // Display results
      resultDiv.innerHTML = `
                <p>Your <strong>${dogSize}</strong> dog is <strong>${dogAge}</strong> years old,</p>
                <p>which is about <strong>${humanAge}</strong> in human years!</p>
                <div class="dog-rating">
                    ${getDogIcons(dogAge)}
                </div>
            `;

      // Replace the existing scrollIntoView code with this:
      setTimeout(() => {
        window.scrollBy({
          top: 225, // Adjust this value to control how much to scroll down
          behavior: 'smooth'
        });
      }, 100);
    });

    // Helper function for dog icons
    function getDogIcons(age) {
      const fullDogs = Math.min(5, Math.floor(age / 2));
      let icons = '';

      for (let i = 0; i < fullDogs; i++) {
        icons += '<i class="fas fa-dog" style="color: #F9942A;"></i>';
      }

      if (age % 2 !== 0 && fullDogs < 5) {
        icons += '<i class="fas fa-dog" style="color: #ddd;"></i>';
      }

      return icons;
    }
  }
});


        // About Page-specific JavaScript can go here
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for stats counting
            const stats = document.querySelectorAll('.stat span');
            stats.forEach(stat => {
                const target = +stat.innerText.replace('+', '');
                const increment = target / 30;
                let current = 0;
                
                const updateStat = () => {
                    if (current < target) {
                        stat.innerText = Math.ceil(current) + (stat.innerText.includes('+') ? '+' : '');
                        current += increment;
                        setTimeout(updateStat, 30);
                    } else {
                        stat.innerText = target + (stat.innerText.includes('+') ? '+' : '');
                    }
                };
                
                updateStat();
            });
        });
    





           // Contact form validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Thank you for your message! We will get back to you soon.');
            this.reset();
        });
        
        // FAQ accordion functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('i');
                
                if (answer.style.maxHeight) {
                    answer.style.maxHeight = null;
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });
        
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });