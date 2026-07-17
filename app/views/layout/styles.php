<style>

.fade-out {
    animation: fadeOut 1.5s forwards;
}
@keyframes fadeOut {
    0% { opacity: 1; }
    100% { opacity: 0; visibility: hidden; }
}
.fade-in {
    opacity: 1 !important;
    transform: none !important;
    transition: none !important;
}

.fade-in.show {
    opacity: 1 !important;
    transform: none !important;
}
.modal-backdrop {
    backdrop-filter: blur(4px);
}
</style>