document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("darkModeToggle");
    const body = document.body;
    const icon = darkModeToggle?.querySelector("i");
    const sidebar = document.querySelector(".sidebar");
    const navbar = document.querySelector(".navbar");
    const statCards = document.querySelectorAll(".stat-card, .card");

    document.querySelectorAll(".card").forEach((card) => {
        card.addEventListener("mouseover", function () {
            this.classList.add("shadow-lg");
            this.style.transform = "scale(1.05)";
            this.style.transition = "0.3s";
        });

        card.addEventListener("mouseout", function () {
            this.classList.remove("shadow-lg");
            this.style.transform = "scale(1)";
        });
    });

    if (localStorage.getItem("darkMode") === "enabled") {
        enableDarkMode();
    }

    darkModeToggle?.addEventListener("click", function () {
        body.classList.contains("dark-mode") ? disableDarkMode() : enableDarkMode();
    });

    function enableDarkMode() {
        body.classList.add("dark-mode");
        sidebar?.classList.add("dark-mode");
        navbar?.classList.add("dark-mode");
        statCards.forEach(el => el.classList.add("dark-mode"));
        localStorage.setItem("darkMode", "enabled");

        if (icon) {
            icon.classList.replace("fa-moon", "fa-sun");
        }
    }

    function disableDarkMode() {
        body.classList.remove("dark-mode");
        sidebar?.classList.remove("dark-mode");
        navbar?.classList.remove("dark-mode");
        statCards.forEach(el => el.classList.remove("dark-mode"));
        localStorage.setItem("darkMode", "disabled");

        if (icon) {
            icon.classList.replace("fa-sun", "fa-moon");
        }
    }
});