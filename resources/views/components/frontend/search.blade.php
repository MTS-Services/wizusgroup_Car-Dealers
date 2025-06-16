<style>
    /* Custom CSS for Search Component */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-track {
        background: #333;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #555;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #777;
    }

    .search-overlay {
        display: flex;
    }

    body.overflow-hidden {
        overflow: hidden !important;
    }

    @media (max-width: 767px) {
        .search-input-group {
            flex-direction: column;
        }

        .category-select {
            width: 100%;
        }

        .search-submit-btn {
            width: 100%;
            margin-top: 1rem;
        }

        .clear-search-btn {
            right: 4rem;
            top: 25%;
        }
    }
</style>
<div class="search-container relative z-50">
    <button
        class="search-toggle-btn p-2 rounded-full flex items-center justify-center transition-all duration-300 ease-linear hover:bg-gray-100 dark:hover:bg-gray-800"
        type="button" aria-label="Open search">
        <i data-lucide="search"
            class="text-2xl text-text-primary dark:text-text-white hover:text-text-tertiary dark:hover:text-text-tertiary"></i>
    </button>

    <div
        class="search-overlay fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm flex items-center justify-center z-[1000] opacity-0 invisible transition-all duration-300 ease-linear">
        <div
            class="search-form-wrapper bg-white dark:bg-gray-900 p-6 rounded-lg shadow-2xl w-[90%] max-w-4xl relative max-h-[90vh] flex flex-col">
            <form class="w-full" action="" method="GET" id="search-form">
                <div class="search-input-group flex flex-col md:flex-row items-center gap-4 mb-4 relative">
                    <input type="search" name="q"
                        placeholder="{{ __('Search for products, brands, categories...') }}"
                        class="search-input input input-lg input-bordered w-full px-4 py-3 text-lg border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-700"
                        autocomplete="off" />

                    <select name="category"
                        class="category-select flex-shrink-0 px-4 py-3 border border-gray-300 rounded-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[150px]">
                        <option value="all">All Categories</option>
                        @foreach (App\Models\Category::all() as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <button type="button"
                        class="clear-search-btn absolute right-24 md:right-16 top-1/2 -translate-y-1/2 p-2 hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors duration-200"
                        aria-label="Clear search input">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                    </button>

                    <button type="submit"
                        class="search-submit-btn flex-shrink-0 bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        aria-label="Perform search">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>

            <div
                class="search-suggestions flex-grow overflow-y-auto mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 custom-scrollbar">
                <p class="text-gray-500 dark:text-gray-400 text-center mb-4">Start typing to see suggestions...</p>
            </div>

            <button
                class="search-close-btn absolute top-4 right-4 p-2 rounded-full flex items-center justify-center transition-all duration-300 ease-linear hover:bg-gray-100 dark:hover:bg-gray-800"
                type="button" aria-label="Close search">
                <i data-lucide="x"
                    class="text-2xl text-text-primary dark:text-text-white hover:text-text-tertiary dark:hover:text-text-tertiary"></i>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Elements
        const searchToggleBtns = $('.search-toggle-btn');
        const searchOverlay = $('.search-overlay');
        const searchCloseBtn = $('.search-close-btn');
        const searchInput = $('.search-input');
        const clearSearchBtn = $('.clear-search-btn');
        const searchSuggestionsContainer = $('.search-suggestions');
        const categorySelect = $('.category-select');
        const searchForm = $('#search-form');

        // Utility functions
        const showElement = (element) => {
            element.removeClass('opacity-0 invisible').addClass('opacity-100 visible');
        };

        const hideElement = (element) => {
            element.removeClass('opacity-100 visible').addClass('opacity-0 invisible');
        };

        // Open search overlay
        const openSearchOverlay = () => {
            showElement(searchOverlay);
            $('body').addClass('overflow-hidden');
            setTimeout(() => searchInput.focus(), 300);
        };

        // Close search overlay
        const closeSearchOverlay = () => {
            hideElement(searchOverlay);
            $('body').removeClass('overflow-hidden');
            searchInput.val('');
            clearSearchBtn.addClass('hidden');
            resetSuggestions();
            categorySelect.val('all');
        };

        // Reset suggestions
        const resetSuggestions = () => {
            searchSuggestionsContainer.html(
                '<p class="text-gray-500 dark:text-gray-400 text-center mb-4">Start typing to see suggestions...</p>'
            );
        };

        // Event listeners
        searchToggleBtns.on('click', openSearchOverlay);
        searchCloseBtn.on('click', closeSearchOverlay);

        searchOverlay.on('click', function(e) {
            if ($(e.target).is(searchOverlay)) {
                closeSearchOverlay();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.hasClass('visible')) {
                closeSearchOverlay();
            }
        });

        searchInput.on('input', function() {
            clearTimeout(window.typingTimer);
            if ($(this).val().length > 0) {
                clearSearchBtn.removeClass('hidden');
                window.typingTimer = setTimeout(performSearchRequest, 300);
            } else {
                clearSearchBtn.addClass('hidden');
                resetSuggestions();
            }
        });

        categorySelect.on('change', function() {
            if (searchInput.val().length > 0 || $(this).val() !== 'all') {
                performSearchRequest();
            } else {
                resetSuggestions();
            }
        });

        clearSearchBtn.on('click', function() {
            searchInput.val('');
            searchInput.focus();
            $(this).addClass('hidden');
            resetSuggestions();
        });

        // Prevent form submission
        searchForm.on('submit', function(e) {
            e.preventDefault();
            performSearchRequest();
        });

        // Perform search request with Axios
        const performSearchRequest = () => {
            const query = searchInput.val();
            const category = categorySelect.val();

            axios.post('{{ route('frontend.products.search') }}', {
                    q: query,
                    category: category
                })
                .then(response => {
                    renderSuggestions(response.data);
                })
                .catch(error => {
                    console.error('Error fetching search suggestions:', error);
                    searchSuggestionsContainer.html(
                        '<p class="text-red-500 dark:text-red-400 text-center mb-4">Error loading suggestions. Please try again.</p>'
                    );
                });
        };

        // Render suggestions
        const renderSuggestions = (suggestions) => {
            searchSuggestionsContainer.empty();

            if (suggestions.length === 0) {
                searchSuggestionsContainer.html(
                    '<p class="text-gray-500 dark:text-gray-400 text-center mb-4">No products found matching your search.</p>'
                );
                return;
            }

            $.each(suggestions, function(index, item) {
                const suggestionHtml = `
                    <a href="${item.url}" class="suggestion-item flex items-center gap-4 p-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 group">
                        <span class="suggestion-number text-blue-600 font-bold text-lg">${String(index + 1).padStart(2, '0')}</span>
                        <img src="${item.image}" alt="${item.name}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <p class="suggestion-text text-gray-800 dark:text-gray-200 text-base flex-grow">
                            ${item.name} <span class="text-gray-500 dark:text-gray-400 text-sm block">in ${item.category}</span>
                        </p>
                        <i data-lucide="arrow-right" class="text-gray-400 dark:text-gray-500 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                `;
                searchSuggestionsContainer.append(suggestionHtml);
            });

            // Initialize Lucide icons
            if (window.lucide && window.lucide.createIcons) {
                lucide.createIcons();
            }
        };
    });
</script>
