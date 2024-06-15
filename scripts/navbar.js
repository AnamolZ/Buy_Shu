document.addEventListener("DOMContentLoaded", function () {
    var navbarToggle = document.getElementById('toggleNavbar');
    var navbarMiddle = document.querySelector('.navbar_middle');
    var navbarRight = document.querySelector('.navbar_right ul');
    var navbarContainer = document.querySelector('.navbar-container');
    var isNavbarVisible = false;

    navbarContainer.addEventListener('click', handleNavbarClick);

    function handleNavbarClick(event) {
        event.preventDefault();

        const target = event.target;
        const href = target.getAttribute('href');

        if (href && href.startsWith('weburl:')) {
            const url = href.replace('weburl:', '');
            window.location.href = url;
        }
    }

    navbarToggle.addEventListener('click', function () {
        navbarRight.classList.toggle('column-layout');
        toggleNavbar();
    });

    function toggleNavbar() {
        if (!isNavbarVisible) {
            navbarMiddle.style.display = "block";
            navbarRight.style.display = "block";
            navbarContainer.style.height = "350px";
        } else {
            navbarMiddle.style.display = "none";
            navbarRight.style.display = "none";
            navbarContainer.style.height = "70px";
        }
        isNavbarVisible = !isNavbarVisible;
    }

    function checkScreenWidth() {
        if (window.innerWidth >= 768) {
            navbarToggle.style.display = "none";
            navbarMiddle.style.display = "block";
            navbarRight.style.display = "block";
            navbarContainer.style.height = "70px";
            isNavbarVisible = true;
        } else {
            navbarToggle.style.display = "block";
            if (!isNavbarVisible) {
                navbarMiddle.style.display = "none";
                navbarRight.style.display = "none";
                navbarContainer.style.height = "70px";
            }
        }
    }

    window.addEventListener('resize', checkScreenWidth);

    function performLogout() {
        localStorage.clear();
        localStorage.removeItem('customer_id');
        localStorage.removeItem('trader_id');
        window.location.href = './';
    }

    const customerId = localStorage.getItem('customer_id');
    const traderId = localStorage.getItem('trader_id');
    const accountDropdown = document.querySelector('.dropbtn');

    if (customerId || traderId) {
        const profileLink = customerId
            ? '../customer_profile/customer_profile.php'
            : '../trader_profile/trader_profile.php';
        const logoutLink = '<a href="weburl:../">Logout</a>';

        accountDropdown.innerHTML = 'Profile';
        accountDropdown.nextElementSibling.innerHTML = logoutLink;
        accountDropdown.nextElementSibling.addEventListener('click', performLogout);

        accountDropdown.addEventListener('click', function () {
            window.location.href = profileLink;
        });
    }
});
