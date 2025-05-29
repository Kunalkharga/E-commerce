/* Mobile Menu Toggle */
document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
  document.querySelector('.nav-links').classList.toggle('active');
});

/* Close mobile menu when clicking on a link */
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', function () {
    document.querySelector('.nav-links').classList.remove('active');
  });
});

/* Smooth scrolling for anchor links */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

/* Dropdown functionality */
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

  // Toggle mobile menu
  document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
    document.querySelector('.nav-links').classList.toggle('active');
  });

  // Toggle user dropdown on mobile
  document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('click', function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const menu = this.querySelector('.dropdown-menu');
        if (menu) {
          menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
          const icon = this.querySelector('.dropdown-icon');
          if (icon) icon.style.display = menu.style.display === 'block' ? 'inline' : 'none';
        }
      }
    });
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 768) {
      document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (!menu.contains(e.target) && !menu.parentElement.contains(e.target)) {
          menu.style.display = 'none';
          const icon = menu.parentElement.querySelector('.dropdown-icon');
          if (icon) icon.style.display = 'none';
        }
      });
    }
  });

  // Handle window resize
  window.addEventListener('resize', function () {
    if (window.innerWidth > 768) {
      document.querySelectorAll('.dropdown').forEach(item => {
        item.classList.remove('active');
      });
    }
  });
});

/* Search functionality */
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
    setTimeout(() => {
      searchContainer.querySelector('input').focus();
    }, 300);
  });

  // Close search box (if exists)
  if (closeSearch) {
    closeSearch.addEventListener('click', function () {
      document.body.classList.remove('search-active');
      searchContainer.classList.remove('active');
    });
  }

  // Close when clicking outside
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

/* Quantity Selector Functionality */
document.addEventListener('DOMContentLoaded', function () {
  // Quantity controls for product pages
  document.querySelectorAll('.product-card .quantity-btn').forEach(btn => {
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

  // Quantity controls for cart page
  document.querySelectorAll('.cart-table .quantity-btn').forEach(btn => {
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

 // Add to Cart functionality
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productCard = this.closest('.product-card');
        if (!productCard) {
            console.error('Product card not found');
            alert('Error: Product card not found.');
            return;
        }

        const productId = productCard.dataset.productId || '';
        const productNameElement = productCard.querySelector('.product-name');
        const productName = productNameElement ? productNameElement.textContent.trim() : '';
        const productPriceElement = productCard.querySelector('.product-price');
        const productPriceText = productPriceElement ? productPriceElement.textContent.trim() : '$0';
        const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g, '')) || 0;
        const quantityInput = productCard.querySelector('.quantity-input');
        const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 1;
        const productImageElement = productCard.querySelector('.product-image');
        const productImage = productImageElement ? productImageElement.src.split('/').pop() : '';

        // Log data for debugging
        console.log('Adding to cart:', { 
            productId, 
            productName, 
            productPrice, 
            productPriceText, 
            quantity, 
            quantityInputValue: quantityInput ? quantityInput.value : 'undefined', 
            productImage 
        });

        // Validate data before sending
        if (!productId || productId === '') {
            console.error('Invalid product ID:', productId);
            alert('Error: Product ID is missing. Please ensure the product is properly configured.');
            return;
        }
        if (!productName) {
            console.error('Invalid product name:', productName);
            alert('Error: Product name is missing. Please check the product card.');
            return;
        }
        if (productPrice <= 0 || isNaN(productPrice)) {
            console.error('Invalid product price:', productPrice, 'Raw text:', productPriceText);
            alert('Error: Invalid product price. Please check the price format.');
            return;
        }
        if (quantity <= 0 || isNaN(quantity)) {
            console.error('Invalid quantity:', quantity);
            alert('Error: Invalid quantity. Please select a valid quantity.');
            return;
        }

        // AJAX request to add to cart
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${encodeURIComponent(productId)}&name=${encodeURIComponent(productName)}&price=${productPrice}&quantity=${quantity}&image=${encodeURIComponent(productImage)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response:', data);
            if (data.success) {
                const cartCount = document.querySelector('.cart-count');
                if (data.cart_count > 0) {
                    if (!cartCount) {
                        const cartIcon = document.querySelector('.cart-icon');
                        if (cartIcon) {
                            const span = document.createElement('span');
                            span.className = 'cart-count';
                            span.textContent = data.cart_count;
                            cartIcon.appendChild(span);
                        }
                    } else {
                        cartCount.textContent = data.cart_count;
                    }
                } else if (cartCount) {
                    cartCount.remove();
                }
                button.innerHTML = '<i class="fas fa-check"></i> Added!';
                button.style.backgroundColor = '#4CAF50';
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    button.style.backgroundColor = '#F9942A';
                }, 2000);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Failed to add to cart. Please check your connection.');
        });
    });
});

  /* DOG AGE CALCULATOR */
  document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('calculate-btn')) {
      const calculateBtn = document.getElementById('calculate-btn');
      const resultDiv = document.getElementById('result');
      const resultContainer = document.getElementById('result-container');

      calculateBtn.addEventListener('click', function () {
        const dogAge = parseInt(document.getElementById('dog-age').value);
        const dogSize = document.getElementById('dog-size').value;

        if (isNaN(dogAge)) {
          resultDiv.innerHTML = 'Please enter a valid age';
          return;
        }

        if (dogAge < 1 || dogAge > 30) {
          resultDiv.innerHTML = 'Please enter an age between 1 and 30';
          return;
        }

        let humanAge;
        if (dogSize === 'small') {
          humanAge = dogAge <= 2 ? dogAge * 12.5 : 25 + (dogAge - 2) * 4.5;
        } else if (dogSize === 'medium') {
          humanAge = dogAge <= 2 ? dogAge * 10.5 : 21 + (dogAge - 2) * 5;
        } else if (dogSize === 'large') {
          humanAge = dogAge <= 2 ? dogAge * 9 : 18 + (dogAge - 2) * 6;
        } else {
          humanAge = dogAge <= 2 ? dogAge * 8 : 16 + (dogAge - 2) * 7.5;
        }

        humanAge = Math.round(humanAge);

        resultDiv.innerHTML = `
                <p>Your <strong>${dogSize}</strong> dog is <strong>${dogAge}</strong> years old,</p>
                <p>which is about <strong>${humanAge}</strong> in human years!</p>
                <div class="dog-rating">
                    ${getDogIcons(dogAge)}
                </div>
            `;

        setTimeout(() => {
          window.scrollBy({
            top: 225,
            behavior: 'smooth'
          });
        }, 100);
      });

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

  /* About Page Stats Animation */
  document.addEventListener('DOMContentLoaded', function () {
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

  /* Contact Form Validation */
  if (document.getElementById('contactForm')) {
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      e.preventDefault();
      alert('Thank you for your message! We will get back to you soon.');
      this.reset();
    });
  }

  /* FAQ Accordion */
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
});