<?php include 'includes/header.php'; ?>

<section class="calculator-section">
    <div class="calculator-container">
        <div class="calculator-header">
            <img src="assets/images/dog-calculator.png" alt="Cute Dog" class="calculator-dog">
            <h2>Dog Age Calculator</h2>
            <p>Find out how old your dog is in human years!</p>
        </div>
        
        <div class="calculator-form">
            <div class="form-group">
                <label for="dog-age">Dog's Age:</label>
                <input type="number" id="dog-age" min="1" max="30" placeholder="Enter age in years">
            </div>
            
            <div class="form-group">
                <label for="dog-size">Dog Size:</label>
                <select id="dog-size">
                    <option value="small">Small (0-20 lbs)</option>
                    <option value="medium">Medium (21-50 lbs)</option>
                    <option value="large">Large (51-90 lbs)</option>
                    <option value="giant">Giant (90+ lbs)</option>
                </select>
            </div>
            
            <button id="calculate-btn" class="calculator-btn">Calculate Age</button>
            
            <div class="result-container" id="result-container">
                <div id="result" class="result-box"></div>
            </div>
        </div>
    </div>
    <div class="back-to-home">
    <a href="index.php" class="btn">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
</div>
</section>



<?php include 'includes/footer.php'; ?>