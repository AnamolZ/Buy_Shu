document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        if(formData){
            alert("Thank You For Your Message!, We'll Contact You Soon");
            window.location.href = "/";
        }
    });
});
