<?php include 'includes/header.php'; ?>

<!-- Blog Hero Section -->
<section class="blog-hero">
    <div class="container">
        <h1>Doggy Blog</h1>
        <p>Your go-to source for dog care tips, nutrition advice, and product insights</p>
        <a href="#latest-blogs" class="hero-cta">Explore Articles</a>
    </div>
</section>

<!-- Featured Blog Posts -->
<section class="featured-blogs">
    <div class="container">
        <h2 class="section-title">Featured Articles</h2>
        <div class="blog-grid">
            <!-- Blog Post 1 -->
            <article class="blog-card">
                <div class="blog-image">
                    <img src="assets/images/blog1.jpg" alt="Dog eating premium food">
                    <span class="blog-category">Nutrition</span>
                </div>
                <div class="blog-content">
                    <h3><a href="#">Guide to Balanced Dog Nutrition</a></h3>
                    <p class="blog-excerpt">Discover the best diet for your dog’s health with expert tips on choosing quality food.</p>
                    <div class="blog-meta">
                        <span><i class="far fa-calendar"></i> June 10, 2025</span>
                        <span><i class="far fa-clock"></i> 5 min read</span>
                    </div>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
            <!-- Blog Post 2 -->
            <article class="blog-card">
                <div class="blog-image">
                    <img src="assets/images/blog2.jpg" alt="Dog training with chew toy">
                    <span class="blog-category">Training</span>
                </div>
                <div class="blog-content">
                    <h3><a href="#">Stop Destructive Chewing</a></h3>
                    <p class="blog-excerpt">Learn training tips and find durable toys to protect your furniture.</p>
                    <div class="blog-meta">
                        <span><i class="far fa-calendar"></i> May 28, 2025</span>
                        <span><i class="far fa-clock"></i> 4 min read</span>
                    </div>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Latest Blog -->
<section class="latest-blogs" id="latest-blogs">
    <div class="container">
        <h2 class="section-title">Latest Articles</h2>
        <div class="blog-grid">
            <!-- Blog Post 3 -->
            <article class="blog-card">
                <div class="blog-image">
                    <img src="assets/images/blog3.jpg" alt="Dog cooling off in summer">
                    <span class="blog-category">Seasonal Care</span>
                </div>
                <div class="blog-content">
                    <h3><a href="#">Summer Safety for Dogs</a></h3>
                    <p class="blog-excerpt">Keep your pup cool with hydration tips and cooling accessories.</p>
                    <div class="blog-meta">
                        <span><i class="far fa-calendar"></i> June 5, 2025</span>
                        <span><i class="far fa-clock"></i> 5 min read</span>
                    </div>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    <div class="product-cta">
                        <p>Shop our <a href="products.php" class="product-link">cooling mats & summer gear</a>!</p>
                    </div>
                </div>
            </article>
            <!-- Blog Post 4 -->
            <article class="blog-card">
                <div class="blog-image">
                    <img src="assets/images/blog4.jpg" alt="Dog wearing LED collar">
                    <span class="blog-category">Product Review</span>
                </div>
                <div class="blog-content">
                    <h3><a href="#">LED Collars vs. Reflective Gear</a></h3>
                    <p class="blog-excerpt">Compare safety gear for night walks and choose the best for your dog.</p>
                    <div class="blog-meta">
                        <span><i class="far fa-calendar"></i> May 22, 2025</span>
                        <span><i class="far fa-clock"></i> 4 min read</span>
                    </div>
                    <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    <div class="product-cta">
                        <p>Shop our <a href="dog-accessories.php" class="product-link">LED collars & reflective gear</a>!</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Newsletter Subscription -->
<section class="newsletter">
    <div class="container">
        <h2 class="section-title">Stay in the Loop!</h2>
        <p>Get exclusive dog care tips, product updates, and discounts.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Enter your email address" required>
            <button type="submit">Subscribe Now</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>