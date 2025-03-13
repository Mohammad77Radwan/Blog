// This script will handle form validation or any JS functionality you wish to add in the future
document.addEventListener("DOMContentLoaded", function() {
    // Example: Validate form inputs
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const title = document.querySelector('[name="title"]');
        const content = document.querySelector('[name="content"]');
        
        if (!title.value || !content.value) {
            alert("Please fill in both the title and content.");
            e.preventDefault();
        }
    });
});


document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.querySelector(".logout-btn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", (event) => {
            if (!confirm("Voulez-vous vraiment vous déconnecter ?")) {
                event.preventDefault();
            }
        });
    }
});
