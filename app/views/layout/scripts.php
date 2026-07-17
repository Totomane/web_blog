<script>
// Animition de la nasa d'elon musk
window.addEventListener("load", function() {
    setTimeout(function() {
        const loader = document.getElementById("loader");
        const content = document.getElementById("content");      
        if (loader) {
            loader.classList.add("fade-out");
        }
        
        if (content) {
            content.classList.remove("opacity-0");
        }
        setTimeout(() => {
            if (loader) {
                loader.style.display = 'none';
            }
        }, 1500);
        
        setTimeout(() => {
            const loaderEl = document.getElementById('loader');
            if (loaderEl) {
                loaderEl.style.pointerEvents = 'none';
                loaderEl.style.display = 'none';
            }
        }, 300);
    }, 1500);
});

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
document.addEventListener('DOMContentLoaded', function() { // bah la je veux que le modal s'ouvre quand on clique sur le bouton +
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });
    }
    document.addEventListener('keydown', function(e) { // en gros quand on appuie sur la touche escape il ferme le modal
        if (e.key === 'Escape') {
            closeCreateModal();
        }
    });
});
</script>