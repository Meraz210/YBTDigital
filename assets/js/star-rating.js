// Star Rating System JavaScript

function initializeStarRating(container) {
    const stars = container.querySelectorAll('.star');
    const ratingInput = container.querySelector('input[type="hidden"]');
    
    // Set initial rating from data attribute
    const initialRating = container.getAttribute('data-rating') || 0;
    highlightStars(stars, initialRating);
    
    // Add event listeners to stars
    stars.forEach(star => {
        // Hover effect
        star.addEventListener('mouseover', () => {
            const rating = parseInt(star.getAttribute('data-value'));
            highlightStars(stars, rating);
        });
        
        // Reset on mouse out
        star.addEventListener('mouseout', () => {
            const currentRating = ratingInput ? parseInt(ratingInput.value) : 0;
            highlightStars(stars, currentRating);
        });
        
        // Click to select rating
        star.addEventListener('click', () => {
            const rating = parseInt(star.getAttribute('data-value'));
            if (ratingInput) {
                ratingInput.value = rating;
            }
            highlightStars(stars, rating);
        });
    });
}

function highlightStars(stars, rating) {
    stars.forEach(star => {
        const starValue = parseInt(star.getAttribute('data-value'));
        if (starValue <= rating) {
            star.classList.add('rated');
        } else {
            star.classList.remove('rated');
        }
    });
}

// Function to handle review submission
function handleReviewSubmission(e, form) {
    e.preventDefault();
    
    // Validate rating
    const ratingInput = form.querySelector('input[name="rating"]');
    if (!ratingInput || parseInt(ratingInput.value) <= 0) {
        alert('Please select a rating');
        return;
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Submit via AJAX
    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Review submitted successfully!');
            form.reset();
            // Reset star ratings
            const containers = form.querySelectorAll('.star-rating-container');
            containers.forEach(container => {
                const stars = container.querySelectorAll('.star');
                highlightStars(stars, 0);
                const ratingInput = container.querySelector('input[type="hidden"]');
                if (ratingInput) ratingInput.value = 0;
            });
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your review');
    });
}

// Initialize all star rating containers when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.star-rating-container');
    containers.forEach(container => {
        initializeStarRating(container);
    });
    
    // Add event listener for review forms
    const reviewForms = document.querySelectorAll('#reviewForm');
    reviewForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            handleReviewSubmission(e, form);
        });
    });
});