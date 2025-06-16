<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const searchModal = $('#search-modal')[0];
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

        // Search input handling
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
                        Type in the search box above to find products
                    </p>
                </div>
            `);
        }

        // Perform search with Axios
        async function performSearchRequest() {
            const query = $searchInput.val().trim();
            const category = $categorySelect.val();

            if (query.length < 1 && category === 'all') {
                resetToDefaultState();
                return;
            }

            try {
                // Using Axios for POST request
                const response = await axios.post('{{ route('frontend.products.search') }}', {
                    q: query,
                    category: category,
                });

                renderSuggestions(response.data, query);
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
                // Remove extra spaces from item names
                const cleanName = item.name.replace(/\s+/g, ' ').trim();
                
                resultsHTML += `
                    <a href="${item.url}" class="card card-side bg-base-200 hover:bg-base-300 transition-colors duration-300">
                        <figure class="p-4">
                            <div class="avatar">
                                <div class="w-16 h-16 rounded-full object-cover">
                                    <img src="${item.image}" alt="${cleanName}" loading="lazy" />
                                </div>
                            </div>
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">${highlightSearchTerm(cleanName, query)}</h3>
                            <div class="badge badge-outline">${item.category}</div>
                            ${item.price ? `<p class="text-success font-bold">${item.price}</p>` : ''}
                        </div>
                    </a>
                `;
            });

            resultsHTML += `</div>`;
            $searchSuggestionsContainer.html(resultsHTML);
        }

        // Highlight search term without spaces
        function highlightSearchTerm(text, term) {
            if (!term || term.trim().length < 1) return text;      
            const cleanTerm = term.replace(/\s+/g, ' ').trim(); 
            const regex = new RegExp(`(${cleanTerm.split(' ').map(word => 
                escapeRegExp(word)).join('|')})`, 'gi');            
            return text.replace(regex, '<span class="text-text-tertiary/50">$1</span>');
        }

        // Escape regex special characters
        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
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