<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Elements
        const searchModal = $('#search-modal')[0]; // Get the DOM element for showModal/close
        const $searchToggleBtn = $('.search-container button');
        const $searchInput = $('.search-input');
        const $clearSearchBtn = $('.clear-search-btn');
        const $searchForm = $('#search-form');
        const $searchSuggestionsContainer = $('.search-suggestions');
        const $categorySelect = $('.category-select');

        // Open modal
        $searchToggleBtn.on('click', function() {
            searchModal.showModal();
            setTimeout(() => $searchInput.focus(), 100);
        });

        // Close modal
        $(searchModal).on('close', function() {
            $searchInput.val('');
            resetToDefaultState();
        });

        // Search input handling (on-change based)
        $searchInput.on('input', function() {
            const query = $(this).val().trim();

            if (query.length > 0) {
                $clearSearchBtn.removeClass('hidden');

                if (query.length > 1) {
                    showLoadingState();
                    performSearchRequest();
                } else {
                    resetToDefaultState();
                }
            } else {
                $clearSearchBtn.addClass('hidden');
                resetToDefaultState();
            }
        });

        // Clear search
        $clearSearchBtn.on('click', function() {
            $searchInput.val('');
            $searchInput.focus();
            $clearSearchBtn.addClass('hidden');
            resetToDefaultState();
        });

        // Category select change handling
        $categorySelect.on('change', function() {
            const query = $searchInput.val().trim();
            if (query.length > 1 || $(this).val() !== 'all') { // Trigger search if there's a query or category changes
                showLoadingState();
                performSearchRequest();
            } else {
                resetToDefaultState();
            }
        });

        // Show loading state
        function showLoadingState() {
            $searchSuggestionsContainer.html(`
                <div class="py-8">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center gap-3">
                            <span class="loading loading-spinner text-primary"></span>
                            <span>Searching...</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        ${Array.from({length: 3}, () => `<div class="skeleton w-full h-24 rounded-xl"></div>`).join('')}
                    </div>
                </div>
            `);
        }

        // Reset to default state
        function resetToDefaultState() {
            $searchSuggestionsContainer.html(`
                <div class="text-center py-12">
                    <div class="mb-6 mx-auto w-16 h-16 text-base-content/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">
                        Start Your Search
                    </h3>
                    <p class="text-base-content/70">
                        Type in the search box above to find products, brands, and categories
                    </p>
                </div>
            `);
        }

        // Perform search
        async function performSearchRequest() {
            const query = $searchInput.val().trim();
            const category = $categorySelect.val();

            if (query.length < 1 && category === 'all') {
                resetToDefaultState();
                return;
            }

            try {
                // Using $.ajax for POST request with jQuery
                const response = await $.ajax({
                    url: '{{ route('frontend.products.search') }}',
                    type: 'POST',
                    data: {
                        q: query,
                        category: category,
                        _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                    }
                });

                renderSuggestions(response, query);
            } catch (error) {
                console.error('Search error:', error);
                showErrorState();
            }
        }

        // Render suggestions
        function renderSuggestions(suggestions, query) {
            if (suggestions.length === 0) {
                $searchSuggestionsContainer.html(`
                    <div class="text-center py-12">
                        <div class="mb-6 mx-auto w-16 h-16 text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">
                            No Results Found
                        </h3>
                        <p class="text-base-content/70 mb-4">
                            We couldn't find any products matching "<strong>${query}</strong>"
                        </p>
                    </div>
                `);
                return;
            }

            let resultsHTML = `
                <div class="alert alert-info mb-4">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span>Found ${suggestions.length} result${suggestions.length !== 1 ? 's' : ''} for "${query}"</span>
                    </div>
                </div>
                <div class="grid gap-4">
            `;

            suggestions.forEach((item) => {
                resultsHTML += `
                    <a href="${item.url}" class="card card-side bg-base-200 hover:bg-base-300 transition-colors duration-300">
                        <figure class="p-4">
                            <div class="avatar">
                                <div class="w-16 h-16 rounded-full object-cover">
                                    <img src="${item.image}" alt="${item.name}" loading="lazy" />
                                </div>
                            </div>
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">${highlightSearchTerm(item.name, query)}</h3>
                            ${item.price ? `<p class="text-success font-bold">${item.price}</p>` : ''}
                        </div>
                    </a>
                `;
            });

            resultsHTML += `</div>`;
            $searchSuggestionsContainer.html(resultsHTML);
        }

        // Highlight search term
        function highlightSearchTerm(text, term) {
            if (!term || term.length < 1) return text;
            const regex = new RegExp(`(${term})`, 'gi');
            return text.replace(regex, '<span class="bg-warning/50">$&</span>'); // Use $& to insert the matched substring
        }

        // Show error state
        function showErrorState() {
            $searchSuggestionsContainer.html(`
                <div class="text-center py-12">
                    <div class="mb-6 mx-auto w-16 h-16 text-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">
                        Search Error
                    </h3>
                    <p class="text-base-content/70 mb-4">
                        Unable to fetch results. Please try again.
                    </p>
                    <button class="btn btn-primary" onclick="performSearchRequest()">
                        Retry Search
                    </button>
                </div>
            `);
        }

        // Keyboard shortcuts
        $(document).on('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchModal.showModal();
                setTimeout(() => $searchInput.focus(), 100);
            }

            if (e.key === 'Escape' && searchModal.open) {
                searchModal.close();
            }
        });
    });
</script>