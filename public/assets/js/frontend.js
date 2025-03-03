// SCRIPT BAGIAN 1 (SLIDESHOW)
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeSlideshow();
    });

    function initializeSlideshow() {
            // Get all elements
        const slideshowContainer = document.querySelector('.slideshow-container');
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        const prevButton = document.querySelector('.slide-nav .prev-btn');
        const nextButton = document.querySelector('.slide-nav .next-btn');
        const currentSlideElement = document.querySelector('.current-slide');
        const totalSlidesElement = document.querySelector('.total-slides');

            // Set up variables
            let currentSlideIndex = 0;
            const totalSlides = slides.length;
            let autoplayTimer = null;

            // Debug info
            console.log('Total slides found:', totalSlides);

            // Initialize slide counter
            if (totalSlidesElement) {
                totalSlidesElement.textContent = '/ ' + totalSlides;
            }

            // Set up navigation buttons
            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    goToSlide(currentSlideIndex - 1);
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    goToSlide(currentSlideIndex + 1);
                });
            }

            // Set up indicators
            indicators.forEach(function(indicator, index) {
                indicator.addEventListener('click', function() {
                    goToSlide(index);
                });
            });

            // Set up touch events for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            if (slideshowContainer) {
                slideshowContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                });

                slideshowContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;

                    // Determine if swipe
                    if (touchEndX < touchStartX - 50) {
                        // Swipe left - go to next slide
                        goToSlide(currentSlideIndex + 1);
                    } else if (touchEndX > touchStartX + 50) {
                        // Swipe right - go to previous slide
                        goToSlide(currentSlideIndex - 1);
                    }
                });

                // Pause autoplay on hover
                slideshowContainer.addEventListener('mouseenter', function() {
                    stopAutoplay();
                });

                slideshowContainer.addEventListener('mouseleave', function() {
                    startAutoplay();
                });
            }

            // Function to go to a specific slide
            function goToSlide(index) {
                // Handle wrap-around
                if (index < 0) {
                    index = totalSlides - 1;
                } else if (index >= totalSlides) {
                    index = 0;
                }

                // If it's the same slide, do nothing
                if (index === currentSlideIndex) return;

                // Remove active class from current slide and indicator
                slides[currentSlideIndex].classList.remove('active');
                indicators[currentSlideIndex].classList.remove('active');

                // Update current slide index
                currentSlideIndex = index;

                // Add active class to new slide and indicator
                slides[currentSlideIndex].classList.add('active');
                indicators[currentSlideIndex].classList.add('active');

                // Update counter
                if (currentSlideElement) {
                    currentSlideElement.textContent = currentSlideIndex + 1;
                }

                console.log('Changed to slide:', currentSlideIndex);

                // Reset autoplay
                resetAutoplay();
            }

            // Start autoplay
            function startAutoplay() {
                if (!autoplayTimer) {
                    autoplayTimer = setInterval(function() {
                        goToSlide(currentSlideIndex + 1);
                    }, 5000);
                }
            }

            // Stop autoplay
            function stopAutoplay() {
                if (autoplayTimer) {
                    clearInterval(autoplayTimer);
                    autoplayTimer = null;
                }
            }

            // Reset autoplay
            function resetAutoplay() {
                stopAutoplay();
                startAutoplay();
            }

            // Start the slideshow
            startAutoplay();
    }
// SCRIPT BAGIAN 1 (SLIDESHOW) END

// SCRIPT BAGIAN 3 (NAVBAR)
    const categoryLinks = document.querySelectorAll('.category-link');
    const articles = document.querySelectorAll('.article-card2');
    const loader = document.querySelector('.loader');

    categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                categoryLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');

                // Show loader
                loader.classList.add('active');

                // Hide articles
                articles.forEach(article => {
                    article.style.opacity = '0';
                });

                // Simulate loading
                setTimeout(() => {
                    // Hide loader
                    loader.classList.remove('active');

                    // Show articles with animation
                    articles.forEach(article => {
                        article.style.opacity = '1';
                        article.classList.remove('reload-animation');
                        void article.offsetWidth; // Trigger reflow
                        article.classList.add('reload-animation');
                    });
                }, 500);
            });
    });
// SCRIPT BAGIAN 3 (NAVBAR) END
