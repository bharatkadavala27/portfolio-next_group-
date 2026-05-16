document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-suggestions');
    let searchTimeout = null;

    function showLoading() {
        const loading = searchInput.parentElement.querySelector('.search-loading');
        if (loading) loading.style.display = 'block';
    }

    function hideLoading() {
        const loading = searchInput.parentElement.querySelector('.search-loading');
        if (loading) loading.style.display = 'none';
    }

    function performSearch() {
        const query = searchInput.value.trim();

        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        showLoading();

        fetch(`/search?query=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            searchResults.innerHTML = html;
            searchResults.style.display = 'block';
            hideLoading();
        })
        .catch(error => {
            console.error('Search error:', error);
            searchResults.innerHTML = '<div class="list-group-item text-danger">Error loading results</div>';
            searchResults.style.display = 'block';
            hideLoading();
        });
    }

    // Add loading spinner
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'search-loading';
    searchInput.parentElement.appendChild(loadingDiv);

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300); // Debounce search
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.style.display = 'none';
            searchInput.blur();
        }
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('#search-input') && !event.target.closest('#search-suggestions')) {
            searchResults.style.display = 'none';
        }
    });
});
