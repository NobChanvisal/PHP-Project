function openModal(id) {
    document.getElementById(`modal-${id}`).classList.remove("hidden");
}
function closeModal(id) {
    document.getElementById(`modal-${id}`).classList.add("hidden");
}
function hideElement(elementId, timeout = 4000) {
    const element = document.getElementById(elementId);
    if (element) {
        setTimeout(() => {
            element.style.display = 'none';
        }, timeout);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    hideElement('feedback-success'); 
    hideElement('feedback-error', 5000);
});