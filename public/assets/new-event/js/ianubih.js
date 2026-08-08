(function () {
    "use strict";

    var prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;

    function getTarget(hash) {
        if (!hash || hash === "#") {
            return null;
        }

        try {
            return document.querySelector(hash);
        } catch (error) {
            return null;
        }
    }

    function getNavigationOffset() {
        var navbarMain = document.querySelector(".navbar-main");
        return navbarMain ? navbarMain.offsetHeight + 12 : 84;
    }

    function scrollToTarget(target, behavior) {
        var targetTop =
            target.getBoundingClientRect().top +
            window.pageYOffset -
            getNavigationOffset();

        window.scrollTo({
            top: Math.max(targetTop, 0),
            behavior: behavior,
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener("click", function (event) {
                var hash = link.getAttribute("href");
                var target = getTarget(hash);

                if (!target) {
                    return;
                }

                event.preventDefault();
                scrollToTarget(
                    target,
                    prefersReducedMotion ? "auto" : "smooth",
                );

                if (window.location.hash !== hash) {
                    window.history.pushState(null, "", hash);
                }
            });
        });
    });

    window.addEventListener("load", function () {
        var target = getTarget(window.location.hash);

        if (target) {
            scrollToTarget(target, "auto");
        }
    });
})();
