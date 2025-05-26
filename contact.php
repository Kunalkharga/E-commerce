<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1>We'd Love to Hear From You</h1>
            <p>Have questions about our products or need advice for your pup? Reach out anytime!</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="container">
        <div class="contact-container">
            <div class="contact-info">
                <h2 class="section-title">Get In Touch</h2>
                <p>Our customer care team is available 7 days a week to assist you with any questions about our products
                    or your order.</p>

                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Visit Us</h3>
                        <p>123 Pet Street, Kathmandu, Nepal</p>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <h3>Call Us</h3>
                        <p>+977 9845617820</p>
                        <p>Mon-Sun: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email Us</h3>
                        <p>info@Doggy.com</p>
                        <p>Orders: orders@Doggy.com</p>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Store Hours</h3>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                        <p>Saturday - Sunday: 10:00 AM - 4:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h2 class="section-title">Send Us a Message</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number (Optional)</label>
                        <input type="tel" id="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" class="form-control" required>
                            <option value="">Select a subject</option>
                            <option value="order">Order Inquiry</option>
                            <option value="product">Product Question</option>
                            <option value="shipping">Shipping Information</option>
                            <option value="returns">Returns & Exchanges</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>

        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.456175836576!2d85.31626931506203!3d27.70504038279397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1908434cb3c9%3A0x44a7f5c0b4f4b3a1!2sKathmandu%2044600%2C%20Nepal!5e0!3m2!1sen!2snp!4v1620000000000!5m2!1sen!2snp"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container" style="margin: 60px auto;">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-item">
            <button class="faq-question">How long does shipping take? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>We typically process orders within 1-2 business days. Delivery times vary by location but generally
                    take 3-5 business days within Nepal.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">What is your return policy? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>We accept returns within 14 days of delivery for unused, unopened products in their original
                    packaging. Please contact our customer service to initiate a return.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question">Do you offer international shipping? <i
                    class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Currently, we only ship within Nepal. We're working to expand our shipping options in the future.</p>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>