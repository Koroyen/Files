document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchProfileUploads');
    const tableRows = document.querySelectorAll('#filesData tr');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();

            tableRows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(searchValue) ? '' : 'none';
            });
        });
    }
});
