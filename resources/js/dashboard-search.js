document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('ajaxSearch');
    const tableBody = document.getElementById('filesData');
    const paginationWrapper = document.getElementById('paginationWrapper');

    if (!searchInput || !tableBody) return;

    searchInput.addEventListener('keyup', () => {
        performSearch();
    });

    window.performSearch = function () {
        const search = searchInput.value.trim();

        if (search === '') {
            // Restore original view with pagination
            window.location.reload();
            return;
        }

        fetch(`/search-files?search=${encodeURIComponent(search)}`)
            .then(res => res.text())
            .then(html => {
                tableBody.innerHTML = html;

                if (paginationWrapper) {
                    paginationWrapper.style.display = 'none';
                }

                // Re-initialize Bootstrap tooltips or modals if needed
                if (typeof bootstrap !== 'undefined') {
                    document.querySelectorAll('.modal').forEach(el => new bootstrap.Modal(el));
                }
            })
            .catch(error => {
                console.error('Search error:', error);
            });
    };
});
