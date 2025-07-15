document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('deleteAllBtn');

    if (!deleteBtn) return;

    deleteBtn.addEventListener('click', function () {
        if (!confirm('Are you sure you want to permanently delete all your deleted files?')) return;

        fetch("/files/force-delete-all", {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json",
                "Content-Type": "application/json",
            },
        })
        .then((res) => res.json())
        .then((data) => {
            const msgBox = document.getElementById("deleteAllMsg");
            msgBox.classList.remove("d-none");

            if (data.success) {
                msgBox.className = "alert alert-success mt-3";
                msgBox.textContent = data.message;
                setTimeout(() => location.reload(), 1000);
            } else {
                msgBox.className = "alert alert-warning mt-3";
                msgBox.textContent = data.message;
            }
        })
        .catch((err) => {
            console.error(err);
            const msgBox = document.getElementById("deleteAllMsg");
            msgBox.classList.remove("d-none");
            msgBox.className = "alert alert-danger mt-3";
            msgBox.textContent = "Something went wrong while deleting.";
        });
    });
});




