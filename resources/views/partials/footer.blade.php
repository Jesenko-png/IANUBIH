<footer id="contact" class="site-footer">
    <div class="container">
        <div class="footer-contact row">
            <div class="col-md-5">
                <span class="section-eyebrow section-eyebrow-light">{{ __('home.contact.eyebrow') }}</span>
                <h2>{{ __('home.contact.title') }}</h2>
                <p>{{ __('home.contact.text') }}</p>
            </div>
            <div class="col-md-7">
                <div class="contact-list">
                    <a href="mailto:info@ianubih.ba" class="contact-item">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <span><small>{{ __('home.contact.email_label') }}</small>info@ianubih.ba</span>
                    </a>
                    <a href="tel:+38761914913" class="contact-item">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <span><small>{{ __('home.contact.phone_label') }}</small>+387 61 914 913</span>
                    </a>
                    <div class="contact-item contact-item-wide">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span><small>{{ __('home.contact.address_label') }}</small>{{ __('home.contact.address') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="row footer-main">
            <div class="col-md-5 col-sm-6 footer-brand-block">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="footer-brand">
                    <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH logo">
                    <span>IANUBIH</span>
                </a>
                <p>{{ __('home.footer.description') }}</p>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>{{ __('home.footer.quick_links') }}</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('about', ['locale' => app()->getLocale()]) }}">{{ __('navigation.about') }}</a></li>
                    <li><a href="{{ route('fields', ['locale' => app()->getLocale()]) }}">{{ __('navigation.areas') }}</a></li>
                    <li><a href="{{ route('publications', ['locale' => app()->getLocale()]) }}">{{ __('navigation.publications') }}</a></li>
                    <li><a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}">{{ __('navigation.cooperation') }}</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-3">
                <h3>{{ __('home.footer.follow') }}</h3>
                <a href="https://www.facebook.com/IANUBIH/" class="footer-social" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    Facebook
                </a>
                <div class="footer-legal">
                    <span>{{ __('home.footer.privacy') }}</span>
                    <span>{{ __('home.footer.cookies') }}</span>
                    <span>{{ __('home.footer.terms') }}</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} IANUBIH. {{ __('home.footer.rights') }}</span>
            <span>Design: <a rel="nofollow" href="https://templatemo.com/tm-486-new-event" target="_blank">TemplateMo</a></span>
        </div>
    </div>
</footer>
