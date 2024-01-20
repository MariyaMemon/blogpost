// script.js

function openLoginModal() {
    document.getElementById('loginModal').style.display = 'block';
}

// Function to close the login modal
function closeLoginModal() {
    document.getElementById('loginModal').style.display = 'none';
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('loginModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
