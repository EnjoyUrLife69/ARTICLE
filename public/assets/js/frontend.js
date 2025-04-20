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

// SCRIPT BAGIAN 3
document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const articles = document.querySelectorAll('.article-card2');
    const loader = document.querySelector('.loader');
    
    // Fungsi untuk mengecek apakah kategori cocok
    function categoryMatches(articleCategory, selectedCategory) {
        return articleCategory === selectedCategory;
    }
    
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Hapus class active dari semua kategori
            categoryLinks.forEach(l => l.classList.remove('active'));
            
            // Tambahkan class active ke kategori yang diklik
            this.classList.add('active');
            
            // Ambil kategori yang dipilih
            const selectedCategory = this.getAttribute('data-category');
            
            // Tampilkan loader
            loader.classList.add('active');
            
            // Sembunyikan semua artikel dulu
            articles.forEach(article => {
                article.style.display = 'none';
                article.style.opacity = '0';
            });
            
            setTimeout(() => {
                // Sembunyikan loader setelah delay
                loader.classList.remove('active');
                
                // Jika kategori "all" dipilih, tampilkan semua artikel
                if (selectedCategory === "all") {
                    // Konversi NodeList ke Array agar bisa menggunakan slice
                    const allArticles = Array.from(articles);
                    // Ambil hanya 6 artikel pertama
                    const limitedArticles = allArticles.slice(0, 6);
                    
                    limitedArticles.forEach(article => {
                        article.style.display = 'block';
                        setTimeout(() => {
                            article.style.opacity = '1';
                        }, 50);
                    });
                    return;
                }
                
                // Filter artikel berdasarkan kategori yang dipilih
                let filteredArticles = [];
                articles.forEach(article => {
                    // Debug: Log nilai kategori untuk memastikan perbandingan benar
                    console.log('Article Category:', article.getAttribute('data-category'));
                    console.log('Selected Category:', selectedCategory);
                    
                    // Perhatikan kategori disimpan sebagai string, jadi pastikan perbandingan sebagai string
                    if (article.getAttribute('data-category') === selectedCategory) {
                        filteredArticles.push(article);
                    }
                });
                
                console.log('Filtered Articles Count:', filteredArticles.length);
                
                // Jika tidak ada artikel yang cocok, tampilkan pesan
                if (filteredArticles.length === 0) {
                    alert("Tidak ada artikel dalam kategori ini.");
                    return;
                }
                
                // Tampilkan semua artikel yang sesuai dengan kategori
                filteredArticles.forEach(article => {
                    article.style.display = 'block';
                    setTimeout(() => {
                        article.style.opacity = '1';
                    }, 50);
                });
            }, 600);
        });
    });
});
// SCRIPT BAGIAN 3 END


// SCRIPT BAGIAN 5
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.history-articles-scroll');
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    
    if (scrollContainer && leftArrow && rightArrow) {
        // Scroll left
        leftArrow.addEventListener('click', function() {
            scrollContainer.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });
        
        // Scroll right
        rightArrow.addEventListener('click', function() {
            scrollContainer.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });
        
        // Hide arrows based on scroll position
        function updateArrows() {
            const isAtStart = scrollContainer.scrollLeft === 0;
            const isAtEnd = scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer.clientWidth - 5);
            
            leftArrow.style.opacity = isAtStart ? '0.5' : '1';
            leftArrow.style.pointerEvents = isAtStart ? 'none' : 'auto';
            
            rightArrow.style.opacity = isAtEnd ? '0.5' : '1';
            rightArrow.style.pointerEvents = isAtEnd ? 'none' : 'auto';
        }
        
        // Initial check
        updateArrows();
        
        // Update on scroll
        scrollContainer.addEventListener('scroll', updateArrows);
    }
});


