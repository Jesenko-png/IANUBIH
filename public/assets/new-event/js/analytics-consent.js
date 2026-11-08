(function () {
    'use strict';

    var measurementId = 'G-2KJZQ71XQX';
    var storageKey = 'iasabih_analytics_consent';
    var isEnglish = (document.documentElement.lang || '').toLowerCase().indexOf('en') === 0;
    var copy = isEnglish
        ? {
            label: 'Analytics cookies',
            message: 'We use Google Analytics to understand how the website is used. Analytics cookies are enabled only with your consent.',
            accept: 'Accept analytics',
            reject: 'Reject',
            settings: 'Cookie settings'
        }
        : {
            label: 'Analitički kolačići',
            message: 'Koristimo Google Analytics kako bismo razumjeli korištenje stranice. Analitički kolačići uključuju se samo uz vašu saglasnost.',
            accept: 'Prihvati analitiku',
            reject: 'Odbij',
            settings: 'Postavke kolačića'
        };

    function readConsent() {
        try {
            return window.localStorage.getItem(storageKey);
        } catch (error) {
            return null;
        }
    }

    function saveConsent(value) {
        try {
            window.localStorage.setItem(storageKey, value);
        } catch (error) {
            // If storage is unavailable, the choice applies only to this page.
        }
    }

    function loadAnalytics() {
        if (window.__iasabihAnalyticsLoaded) {
            return;
        }

        window.__iasabihAnalyticsLoaded = true;
        window.dataLayer = window.dataLayer || [];
        window.gtag = window.gtag || function () {
            window.dataLayer.push(arguments);
        };

        window.gtag('consent', 'default', {
            ad_storage: 'denied',
            ad_user_data: 'denied',
            ad_personalization: 'denied',
            analytics_storage: 'denied'
        });
        window.gtag('consent', 'update', {
            analytics_storage: 'granted'
        });
        window.gtag('js', new Date());
        window.gtag('config', measurementId);

        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId);
        document.head.appendChild(script);
    }

    function removeAnalyticsCookies() {
        document.cookie.split(';').forEach(function (cookie) {
            var name = cookie.split('=')[0].trim();

            if (name === '_ga' || name.indexOf('_ga_') === 0 || name === '_gid' || name === '_gat') {
                document.cookie = name + '=; Max-Age=0; path=/';
                document.cookie = name + '=; Max-Age=0; path=/; domain=' + window.location.hostname;
                document.cookie = name + '=; Max-Age=0; path=/; domain=.' + window.location.hostname;
            }
        });
    }

    function createInterface() {
        var style = document.createElement('style');
        style.textContent = [
            '.iasabih-cookie-banner{position:fixed;z-index:99999;left:20px;right:20px;bottom:20px;max-width:760px;margin:0 auto;padding:20px;background:#10273f;color:#fff;border:1px solid rgba(255,255,255,.2);box-shadow:0 14px 40px rgba(0,0,0,.3);font-family:Inter,Arial,sans-serif}',
            '.iasabih-cookie-banner[hidden],.iasabih-cookie-settings[hidden]{display:none!important}',
            '.iasabih-cookie-banner strong{display:block;margin-bottom:7px;font-size:16px}',
            '.iasabih-cookie-banner p{margin:0;color:rgba(255,255,255,.86);font-size:14px;line-height:1.55}',
            '.iasabih-cookie-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:16px}',
            '.iasabih-cookie-actions button,.iasabih-cookie-settings{border:0;cursor:pointer;font:600 13px Inter,Arial,sans-serif}',
            '.iasabih-cookie-accept{padding:10px 15px;background:#24b7b0;color:#071b2e}',
            '.iasabih-cookie-reject{padding:10px 15px;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.5)!important}',
            '.iasabih-cookie-settings{position:fixed;z-index:99998;left:14px;bottom:14px;padding:8px 11px;background:#10273f;color:#fff;box-shadow:0 5px 18px rgba(0,0,0,.22)}',
            '@media(max-width:600px){.iasabih-cookie-banner{left:10px;right:10px;bottom:10px;padding:17px}.iasabih-cookie-actions button{flex:1 1 140px}}'
        ].join('');
        document.head.appendChild(style);

        var banner = document.createElement('section');
        banner.className = 'iasabih-cookie-banner';
        banner.hidden = true;
        banner.setAttribute('role', 'dialog');
        banner.setAttribute('aria-label', copy.label);
        banner.innerHTML =
            '<strong>' + copy.label + '</strong>' +
            '<p>' + copy.message + '</p>' +
            '<div class="iasabih-cookie-actions">' +
                '<button type="button" class="iasabih-cookie-accept">' + copy.accept + '</button>' +
                '<button type="button" class="iasabih-cookie-reject">' + copy.reject + '</button>' +
            '</div>';

        var settings = document.createElement('button');
        settings.type = 'button';
        settings.className = 'iasabih-cookie-settings';
        settings.hidden = true;
        settings.textContent = copy.settings;

        document.body.appendChild(banner);
        document.body.appendChild(settings);

        var acceptButton = banner.querySelector('.iasabih-cookie-accept');
        var rejectButton = banner.querySelector('.iasabih-cookie-reject');

        function showSettings() {
            settings.hidden = false;
        }

        acceptButton.addEventListener('click', function () {
            saveConsent('granted');
            banner.hidden = true;
            showSettings();
            loadAnalytics();
        });

        rejectButton.addEventListener('click', function () {
            var wasGranted = readConsent() === 'granted';
            saveConsent('denied');
            removeAnalyticsCookies();
            banner.hidden = true;
            showSettings();

            if (wasGranted) {
                window.location.reload();
            }
        });

        settings.addEventListener('click', function () {
            settings.hidden = true;
            banner.hidden = false;
            acceptButton.focus();
        });

        var consent = readConsent();

        if (consent === 'granted') {
            showSettings();
            loadAnalytics();
        } else if (consent === 'denied') {
            showSettings();
        } else {
            banner.hidden = false;
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', createInterface);
    } else {
        createInterface();
    }
}());
