// Job Analyze functionality
(function() {
    'use strict';

    // Loading states for forms
    function showLoading(button) {
        const originalText = button.innerHTML;
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;
        button.disabled = true;
        button.classList.add('opacity-75', 'cursor-not-allowed');
        
        return function hideLoading() {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('opacity-75', 'cursor-not-allowed');
        };
    }

    // Initialize loading states for all forms
    document.addEventListener('DOMContentLoaded', function() {
        // Search form loading state
        const searchForm = document.querySelector('form[action*="job-analyze"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    const hideLoading = showLoading(submitButton);
                    // Re-enable after 3 seconds as fallback
                    setTimeout(hideLoading, 3000);
                }
            });
        }

        // Interview preparation loading state
        const interviewButtons = document.querySelectorAll('a[href*="prepare-interview"]');
        interviewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Preparing...
                `;
                this.classList.add('opacity-75', 'cursor-not-allowed');
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 5000);
            });
        });

        // Analysis detail loading state
        const analysisCards = document.querySelectorAll('.analysis-card');
        analysisCards.forEach(card => {
            const viewButton = card.querySelector('a[href*="job-analyze/"]');
            if (viewButton) {
                viewButton.addEventListener('click', function() {
                    // Add loading overlay to the card
                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg';
                    loadingOverlay.innerHTML = `
                        <div class="text-center">
                            <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">Loading analysis...</p>
                        </div>
                    `;
                    card.style.position = 'relative';
                    card.appendChild(loadingOverlay);
                });
            }
        });

        // Filter dropdown enhancements
        const filterSelects = document.querySelectorAll('select[name="date_range"], select[name="match_score"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Auto-submit form on filter change with delay
                clearTimeout(this.form.dataset.submitTimeout);
                this.form.dataset.submitTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        });

        // Mobile responsive enhancements
        function handleMobileView() {
            const isMobile = window.innerWidth < 768;
            const statCards = document.querySelectorAll('.bg-green-50, .bg-yellow-50, .bg-red-50');
            
            statCards.forEach(card => {
                if (isMobile) {
                    card.classList.add('p-3');
                    card.classList.remove('p-4');
                } else {
                    card.classList.remove('p-3');
                    card.classList.add('p-4');
                }
            });
        }

        // Initial mobile check
        handleMobileView();
        
        // Handle resize
        window.addEventListener('resize', handleMobileView);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced print functionality for interview prep
        const printButton = document.querySelector('button[onclick*="print"]');
        if (printButton) {
            printButton.addEventListener('click', function() {
                // Add print-specific styles
                const printStyles = document.createElement('style');
                printStyles.textContent = `
                    @media print {
                        .bg-blue-50 { background-color: #f0f9ff !important; }
                        .bg-gray-50 { background-color: #f9fafb !important; }
                        .bg-green-50 { background-color: #f0fdf4 !important; }
                        .bg-yellow-50 { background-color: #fefce8 !important; }
                        .bg-red-50 { background-color: #fef2f2 !important; }
                        .shadow-sm { box-shadow: none !important; }
                        .border { border: 1px solid #e5e7eb !important; }
                    }
                `;
                document.head.appendChild(printStyles);
                
                // Print and remove styles after
                setTimeout(() => {
                    window.print();
                    setTimeout(() => {
                        document.head.removeChild(printStyles);
                    }, 100);
                }, 100);
            });
        }
    });

    // Utility functions
    window.JobAnalyze = {
        showLoading: showLoading,
        
        // Analytics tracking (placeholder)
        trackEvent: function(event, data) {
            if (typeof gtag !== 'undefined') {
                gtag('event', event, data);
            }
        },
        
        // Performance monitoring
        measurePerformance: function(label) {
            if (typeof performance !== 'undefined') {
                performance.mark(label + '-start');
                return function() {
                    performance.mark(label + '-end');
                    performance.measure(label, label + '-start', label + '-end');
                };
            }
            return function() {};
        }
    };
})();