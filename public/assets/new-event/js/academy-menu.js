(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var navigation = document.querySelector('#main-navigation .academy-nav');

        if (!navigation) {
            return;
        }

        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        var animations = new WeakMap();
        var requests = new WeakMap();

        function panelFor(group) {
            return Array.from(group.children).find(function (child) {
                return child.classList.contains('academy-menu-panel');
            });
        }

        function stopAnimation(group) {
            var running = animations.get(group);

            if (running) {
                running.animation.cancel();
            }
        }

        function closeDescendants(group) {
            group.querySelectorAll('details.academy-menu-group').forEach(function (child) {
                stopAnimation(child);
                child.open = false;
                child.classList.remove('is-closing');
            });
        }

        function closeGroup(group) {
            if (!group.open) {
                return Promise.resolve();
            }

            var running = animations.get(group);

            if (running && running.direction === 'close') {
                return running.promise;
            }

            var panel = panelFor(group);

            if (!panel || reducedMotion.matches || !panel.animate) {
                stopAnimation(group);
                group.open = false;
                closeDescendants(group);
                return Promise.resolve();
            }

            var currentHeight = panel.getBoundingClientRect().height;
            stopAnimation(group);
            panel.style.overflow = 'hidden';
            group.classList.add('is-closing');

            var resolveClose;
            var promise = new Promise(function (resolve) {
                resolveClose = resolve;
            });
            var animation = panel.animate([
                { height: currentHeight + 'px', opacity: 1 },
                { height: '0px', opacity: 0 }
            ], {
                duration: 180,
                easing: 'cubic-bezier(.4, 0, .2, 1)'
            });
            var record = { animation: animation, direction: 'close', promise: promise };
            animations.set(group, record);

            animation.onfinish = function () {
                if (animations.get(group) === record) {
                    animations.delete(group);
                    panel.style.overflow = '';
                    group.classList.remove('is-closing');
                    group.open = false;
                    closeDescendants(group);
                }

                resolveClose();
            };
            animation.oncancel = function () {
                if (animations.get(group) === record) {
                    animations.delete(group);
                    panel.style.overflow = '';
                    group.classList.remove('is-closing');
                }

                resolveClose();
            };

            return promise;
        }

        function openGroup(group) {
            var panel = panelFor(group);
            var wasOpen = group.open;
            var currentHeight = wasOpen && panel ? panel.getBoundingClientRect().height : 0;
            stopAnimation(group);
            group.classList.remove('is-closing');
            group.open = true;

            if (!panel || reducedMotion.matches || !panel.animate) {
                return;
            }

            var fullHeight = panel.getBoundingClientRect().height;
            panel.style.overflow = 'hidden';
            var animation = panel.animate([
                { height: currentHeight + 'px', opacity: wasOpen ? 1 : 0 },
                { height: fullHeight + 'px', opacity: 1 }
            ], {
                duration: 230,
                easing: 'cubic-bezier(.2, .8, .2, 1)'
            });
            var record = { animation: animation, direction: 'open' };
            animations.set(group, record);

            function finish() {
                if (animations.get(group) === record) {
                    animations.delete(group);
                    panel.style.overflow = '';
                }
            }

            animation.onfinish = finish;
            animation.oncancel = finish;
        }

        function siblingGroups(group) {
            var list = group.parentElement.parentElement;

            return Array.from(list.children).map(function (item) {
                return Array.from(item.children).find(function (child) {
                    return child.tagName === 'DETAILS';
                });
            }).filter(function (sibling) {
                return sibling && sibling !== group;
            });
        }

        function topGroups() {
            return Array.from(navigation.children).map(function (item) {
                return Array.from(item.children).find(function (child) {
                    return child.tagName === 'DETAILS';
                });
            }).filter(function (group) {
                return group && group.open;
            });
        }

        function cancelPendingOpens() {
            [navigation].concat(Array.from(navigation.querySelectorAll('ul.academy-menu-panel'))).forEach(function (list) {
                requests.set(list, (requests.get(list) || 0) + 1);
            });
        }

        async function activate(group) {
            var list = group.parentElement.parentElement;
            var request = (requests.get(list) || 0) + 1;
            requests.set(list, request);

            var running = animations.get(group);

            if (group.open && (!running || running.direction !== 'close')) {
                await closeGroup(group);
                return;
            }

            await Promise.all(siblingGroups(group).map(closeGroup));

            if (requests.get(list) === request) {
                openGroup(group);
            }
        }

        navigation.addEventListener('click', function (event) {
            var trigger = event.target.closest('summary.academy-menu-trigger');

            if (!trigger || !navigation.contains(trigger)) {
                return;
            }

            event.preventDefault();
            activate(trigger.parentElement);
        });

        document.addEventListener('click', function (event) {
            if (navigation.contains(event.target)) {
                return;
            }

            cancelPendingOpens();
            topGroups().forEach(closeGroup);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            var focusedGroup = document.activeElement.closest('details.academy-menu-group');
            var topGroup = focusedGroup;

            while (topGroup && topGroup.parentElement.parentElement !== navigation) {
                topGroup = topGroup.parentElement.parentElement.closest('details.academy-menu-group');
            }

            cancelPendingOpens();
            topGroups().forEach(closeGroup);

            if (topGroup && navigation.contains(topGroup)) {
                topGroup.querySelector('summary.academy-menu-trigger').focus();
            }
        });
    });
}());
