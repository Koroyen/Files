document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tableSearch');
    const tableBody = document.getElementById('fileTableBody');

    if (searchInput) {
        searchInput.addEventListener('input', performSearch);
    }

    function performSearch() {
        const search = searchInput.value;

        fetch(`/search-files?search=${encodeURIComponent(search)}`)
            .then(res => res.json())
            .then(files => {
                tableBody.innerHTML = '';

                if (files.length > 0) {
                    files.forEach(file => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${file.title}</td>
                                <td>${file.document_number}</td>
                                <td>${file.type}</td>
                                <td>${file.uuid}</td>
                            </tr>`;
                    });
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">No matching results found.</td>
                        </tr>`;
                }
            })
            .catch(error => console.error('Search error:', error));
    }
});
