/* Mobile Menu Toggle */
document.addEventListener('DOMContentLoaded', function () {
 // Toggle mobile menu
document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
    document.querySelector('.nav-links').classList.toggle('active');
});

/* Smooth scrolling for anchor links */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

/* Dropdown functionality */
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

// Mobile click functionality
if (window.innerWidth <= 768) {
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Prevent event from bubbling up
            const dropdown = toggle.parentElement;
            dropdown.classList.toggle('active');

            // Close other dropdowns (optional - remove if you want multiple dropdowns open)
            document.querySelectorAll('.dropdown').forEach(item => {
                if (item !== dropdown) {
                    item.classList.remove('active');
                }
            });
        });
    });

    // Prevent clicks inside dropdown from closing parent menus
    document.querySelectorAll('.dropdown-menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event from bubbling up
            // Keep the mobile menu open by not removing the 'active' class
        });
    });
}

// Toggle user dropdown on mobile
document.querySelector('.user-toggle')?.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.closest('.mobile-user-dropdown').classList.toggle('active');
});

// Close when clicking outside (modified to keep nav-links open)
document.addEventListener('click', function(e) {
    // Only handle dropdown closures, not nav-links
    if (!e.target.closest('.dropdown') && !e.target.closest('.mobile-user-dropdown')) {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
        document.querySelectorAll('.mobile-user-dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    // Only close nav-links when clicking outside the entire navigation area
    if (!e.target.closest('.nav-links') && !e.target.closest('.mobile-menu-btn')) {
        document.querySelector('.nav-links').classList.remove('active');
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

  /* Quantity Selector Functionality */
  // Product card quantity controls
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

  // Cart page quantity controls
  document.querySelectorAll('.cart-table .cart-quantity-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const input = this.parentElement.querySelector('.cart-quantity-input');
      let value = parseInt(input.value);
      if (this.classList.contains('cart-minus')) {
        value = value > 1 ? value - 1 : 1;
      } else if (this.classList.contains('cart-plus')) {
        value = value < 10 ? value + 1 : 10;
      }
      input.value = value;
      // Update subtotal dynamically
      const row = this.closest('tr');
      const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', ''));
      row.querySelector('td:nth-child(4)').textContent = '$' + (price * value).toFixed(2);
      // Update total summary (client-side only)
      updateCartTotal();
    });
  });

  function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('.cart-table tbody tr').forEach(row => {
      const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('$', ''));
      const quantity = parseInt(row.querySelector('.cart-quantity-input').value);
      total += price * quantity;
    });
    document.querySelector('.cart-summary p:last-child').textContent = 'Total Price: $' + total.toFixed(2);
  }

  // Initialize total on page load
  if (document.querySelector('.cart-table')) {
    updateCartTotal();
  }

  // Add to Cart functionality
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
      const productCard = this.closest('.product-card');
      if (!productCard) {
        console.error('Product card not found');
        alert('Error: Product card not found.');
        return;
      }
      console.log('Product Card:', productCard);
      const productId = productCard.dataset.productId || '';
      console.log('Product ID:', productId);
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
      console.log('Sending to add_to_cart.php:', {
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

  /* Contact Form Validation */
  if (document.getElementById('contactForm')) {
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      e.preventDefault();
      alert('Thank you for your message! We will get back to you soon.');
      this.reset();
    });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');
      faqItems.forEach(i => i.classList.remove('active'));
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
});
