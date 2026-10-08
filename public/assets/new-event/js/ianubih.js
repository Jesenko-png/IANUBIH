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

    function playBackgroundVideo(video) {
        var source = video.querySelector("source[data-src]");

        if (source) {
            source.src = source.getAttribute("data-src");
            source.removeAttribute("data-src");
            video.load();
        }

        video.muted = true;
        var playback = video.play();

        if (playback && typeof playback.catch === "function") {
            playback.catch(function () {});
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        var backgroundVideos = document.querySelectorAll(".section-background-video");

        if (!prefersReducedMotion && backgroundVideos.length) {
            if ("IntersectionObserver" in window) {
                var videoObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            playBackgroundVideo(entry.target);
                        } else {
                            entry.target.pause();
                        }
                    });
                }, { rootMargin: "150px 0px", threshold: 0 });

                backgroundVideos.forEach(function (video) {
                    videoObserver.observe(video);
                });
            } else {
                backgroundVideos.forEach(playBackgroundVideo);
            }
        }

        var publications = document.querySelector(".publications-section");
        var publicationLineTrigger = document.querySelector(".publication-line-trigger");

        if (
            publications &&
            publicationLineTrigger &&
            !prefersReducedMotion &&
            "IntersectionObserver" in window
        ) {
            publications.classList.add("line-ready");

            var lineObserver = new IntersectionObserver(
                function (entries, observer) {
                    if (entries.some(function (entry) { return entry.isIntersecting; })) {
                        publications.classList.add("line-filled");
                        observer.disconnect();
                    }
                },
                { rootMargin: "0px 0px -10% 0px", threshold: 0 },
            );

            lineObserver.observe(publicationLineTrigger);
        }

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
