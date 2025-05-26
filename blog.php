<?php include 'includes/header.php'; ?>

    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <h1>Doggy Blog</h1>
            <p>Expert advice on dog care, nutrition, training & product reviews</p>
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
                        <img src="images/blog1.jpg" alt="Dog eating premium food">
                        <span class="blog-category">Nutrition</span>
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">Complete Guide to Balanced Dog Nutrition</a></h3>
                        <p class="blog-excerpt">Learn what your dog really needs in their diet and how to choose the
                            best food for their health.</p>
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
                        <img src="images/blog2.jpg" alt="Dog training with chew toy">
                        <span class="blog-category">Training</span>
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">How to Stop Destructive Chewing</a></h3>
                        <p class="blog-excerpt">Discover the best durable toys for aggressive chewers and training tips
                            to save your furniture.</p>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> May 28, 2025</span>
                            <span><i class="far fa-clock"></i> 4 min read</span>
                        </div>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                <!-- Blog Post 3 -->
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="images/blog3.jpg" alt="Senior dog on orthopedic bed">
                        <span class="blog-category">Health</span>
                    </div>
                    <div class="blog-content">
                        <h3><a href="#">Senior Dog Care: Keeping Them Happy & Healthy</a></h3>
                        <p class="blog-excerpt">Essential tips for aging dogs, including joint care, diet adjustments,
                            and comfort products.</p>
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> May 15, 2025</span>
                            <span><i class="far fa-clock"></i> 6 min read</span>
                        </div>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- All Blog Posts Section -->
    <section class="all-blogs">
        <div class="container">
            <h2 class="section-title">Latest Articles</h2>
            <div class="blog-list">
                <!-- Blog Post 4 -->
                <article class="blog-post">
                    <div class="post-image">
                        <img src="images/blog3.jpg" alt="Dog cooling off in summer">
                    </div>
                    <div class="post-content">
                        <span class="post-category">Seasonal Care</span>
                        <h3><a href="#">Summer Safety Tips: Keeping Your Dog Cool</a></h3>
                        <p class="post-excerpt">Heat can be dangerous for dogs. Learn how to protect your pup with
                            cooling mats, hydration tips, and more.</p>
                        <div class="post-meta">
                            <span><i class="far fa-calendar"></i> June 5, 2025</span>
                            <span><i class="far fa-clock"></i> 5 min read</span>
                        </div>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        <div class="product-cta">
                            <p>Check out our <a href="products.html" class="product-link">cooling mats & summer
                                    accessories</a> to keep your dog comfortable!</p>
                        </div>
                    </div>
                </article>

                <!-- Blog Post 5 -->
                <article class="blog-post">
                    <div class="post-image">
                        <img src="images/blog2.jpg" alt="Dog wearing LED collar">
                    </div>
                    <div class="post-content">
                        <span class="post-category">Product Review</span>
                        <h3><a href="#">LED Collars vs. Reflective Gear: Which Is Safer?</a></h3>
                        <p class="post-excerpt">We compare visibility options for night walks and recommend the best
                            safety gear for your dog.</p>
                        <div class="post-meta">
                            <span><i class="far fa-calendar"></i> May 22, 2025</span>
                            <span><i class="far fa-clock"></i> 4 min read</span>
                        </div>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        <div class="product-cta">
                            <p>Shop our <a href="dog-aaccessories.html" class="product-link">LED collars & reflective
                                    gear</a> for safer walks!</p>
                        </div>
                    </div>
                </article>

                <!-- Blog Post 6 -->
                <article class="blog-post">
                    <div class="post-image">
                        <img src="images/blog1.jpg" alt="Homemade dog treats">
                    </div>
                    <div class="post-content">
                        <span class="post-category">Recipes</span>
                        <h3><a href="#">3 Easy Homemade Dog Treat Recipes</a></h3>
                        <p class="post-excerpt">Whip up healthy, delicious treats using simple ingredients. Your dog
                            will love them!</p>
                        <div class="post-meta">
                            <span><i class="far fa-calendar"></i> May 10, 2025</span>
                            <span><i class="far fa-clock"></i> 3 min read</span>
                        </div>
                        <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        <div class="product-cta">
                            <p>Try our <a href="food&nutritions.html" class="product-link">grain-free treats</a> for
                                store-bought alternatives!</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Newsletter Subscription -->
    <section class="newsletter">
        <div class="container">
            <h3>Stay Updated with Dog Care Tips!</h3>
            <p>Subscribe to our newsletter for exclusive content, product discounts, and more.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>