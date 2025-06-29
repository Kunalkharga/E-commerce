document.addEventListener('DOMContentLoaded', function () {
  // Toggle mobile menu
  document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
    document.querySelector('.nav-links').classList.toggle('active');
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
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

  // Mobile click functionality
  if (window.innerWidth <= 768) {
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const dropdown = toggle.parentElement;
        const icon = toggle.querySelector('i.fa-chevron-down');

        // Toggle current dropdown
        dropdown.classList.toggle('active');

        //Rotate icon based on dropdown state
        if (icon) {
          icon.style.transform = dropdown.classList.contains('active')
            ? 'rotate(180deg)'
            : 'rotate(0deg)';
        }

        // Close other dropdowns
        document.querySelectorAll('.dropdown').forEach(item => {
          if (item !== dropdown) {
            item.classList.remove('active');
            const otherIcon = item.querySelector('i.fa-chevron-down');
            if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
          }
        });
      });
    });

    // Prevent clicks inside dropdown from closing parent menus
    document.querySelectorAll('.dropdown-menu a').forEach(link => {
      link.addEventListener('click', function (e) {
        e.stopPropagation(); 
      });
    });
  }

  // Toggle user dropdown on mobile
  document.querySelector('.user-toggle')?.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    this.closest('.mobile-user-dropdown').classList.toggle('active');
  });

  // Close when clicking outside
  document.addEventListener('click', function (e) {
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
      row.querySelector('td:nth-child(4)').textContent = 'Rs.' + (price * value).toFixed(2);
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
    document.querySelector('.cart-summary p:last-child').textContent = 'Total Price: Rs.' + total.toFixed(2);
  }

  // Initialize total on page load
  if (document.querySelector('.cart-table')) {
    updateCartTotal();
  }

  // Add to Cart functionality
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productCard = this.closest('.product-card');
        if (!productCard) {
            alert('Error: Product card not found.');
            return;
        }

        // Get product data
        const productId = productCard.dataset.productId || '';
        const productName = productCard.querySelector('.product-name')?.textContent.trim() || '';
        const productPriceText = productCard.querySelector('.product-price')?.textContent.trim() || '$0';
        const productPrice = parseFloat(productPriceText.replace(/[^0-9.]/g, '')) || 0;
        const quantity = parseInt(productCard.querySelector('.quantity-input')?.value, 10) || 1;
        const productImage = productCard.querySelector('.product-image')?.src.split('/').pop() || '';

        // Validate data
        if (!productId || isNaN(productId)) {
            alert('Error: Invalid product ID.');
            return;
        }
        if (productPrice <= 0) {
            alert('Error: Invalid product price.');
            return;
        }
        if (quantity <= 0) {
            alert('Error: Invalid quantity.');
            return;
        }

        // Show loading state
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        button.disabled = true;

        // AJAX request with proper data format
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                product_id: productId,
                name: productName,
                price: productPrice,
                quantity: quantity,
                image: productImage
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Failed to add to cart');
            }
            
            // Update cart count display
            updateCartCount(data.cart_count);
            
            // Show success state
            button.innerHTML = '<i class="fas fa-check"></i> Added!';
            button.style.backgroundColor = '#4CAF50';
            
            setTimeout(() => {
                button.innerHTML = originalHtml;
                button.style.backgroundColor = '#F9942A';
                button.disabled = false;
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            button.innerHTML = originalHtml;
            button.disabled = false;
            alert(error.message || 'Failed to add to cart. Please try again.');
        });
    });
});

function updateCartCount(count) {
    // Target both desktop and mobile cart icons
    const cartIcons = document.querySelectorAll('.cart-icon, .mobile-icon.cart-icon');
    
    cartIcons.forEach(cartIcon => {
        let cartCount = cartIcon.querySelector('.cart-count');
        
        if (count > 0) {
            if (!cartCount) {
                cartCount = document.createElement('span');
                cartCount.className = 'cart-count';
                cartIcon.appendChild(cartCount);
            }
            cartCount.textContent = count;
            cartCount.style.display = 'flex';
        } else if (cartCount) {
            cartCount.remove();
        }
    });
}

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


