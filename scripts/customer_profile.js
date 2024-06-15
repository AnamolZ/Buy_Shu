document.addEventListener('DOMContentLoaded', function() {
    const cartLinkSection = document.getElementById('cart-link-section');
    cartLinkSection.style.display = 'none';

    const toggleSections = (recent, profile, cart, wish) => {
        document.getElementById('recent-link-pur').style.display = recent;
        document.getElementById('profile-section').style.display = profile;
        cartLinkSection.style.display = cart;
    };

    document.getElementById('cart-link').addEventListener('click', () => toggleSections('none', 'none', 'block', 'none'));
    document.getElementById('edit-link').addEventListener('click', () => toggleSections('block', 'block', 'none', 'none'));
    document.getElementById('recent-link').addEventListener('click', () => toggleSections('block', 'block', 'none', 'none'));
});