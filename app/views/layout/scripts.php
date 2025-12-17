<script>
// Page Load Animation
window.addEventListener("load", function() {
    setTimeout(function() {
        const loader = document.getElementById("loader");
        const content = document.getElementById("content");
        
        // Start fade out animation
        if (loader) {
            loader.classList.add("fade-out");
        }
        
        if (content) {
            content.classList.remove("opacity-0");
        }
        
        // Remove loader completely after animation
        setTimeout(() => {
            if (loader) {
                loader.style.display = 'none';
            }
        }, 1500);
        
        // Ensure loader is removed promptly and do not stagger-show elements.
        setTimeout(() => {
            const loaderEl = document.getElementById('loader');
            if (loaderEl) {
                // remove from pointer flow immediately so clicks work
                loaderEl.style.pointerEvents = 'none';
                loaderEl.style.display = 'none';
            }
        }, 300);
    }, 1500);
});

// Modal Functions
function openCreateModal() {
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Modal Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
        }
    });
});
</script>