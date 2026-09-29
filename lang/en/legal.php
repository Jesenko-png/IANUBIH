<?php

return [
    'common' => [
        'eyebrow' => 'Legal information',
        'home' => 'Home',
        'document_information' => 'Document information',
        'updated_label' => 'Last updated',
        'updated_date' => '29 September 2026',
        'contact_note' => 'For questions about privacy or use of the website, contact IANUBIH.',
        'contact_eyebrow' => 'Contact',
        'contact_title' => 'Do you have a question about these terms?',
        'contact_text' => 'For requests concerning personal data, cookies or use of content, contact us by email.',
        'cookie_settings' => 'Open cookie settings',
    ],
    'privacy' => [
        'meta' => [
            'title' => 'Privacy Policy | IANUBIH',
            'description' => 'Information on how IANUBIH collects, uses, retains and protects the personal data of website users.',
        ],
        'title' => 'Privacy Policy',
        'intro' => 'This policy explains what data we collect through the website, why we process it and the rights you have in relation to your data.',
        'sections' => [
            [
                'title' => '1. Who controls the data',
                'paragraphs' => [
                    'The data controller is the International Academy of Sciences and Arts in Bosnia and Herzegovina (IANUBIH), Paromlinska 53, 71000 Sarajevo, Bosnia and Herzegovina. The privacy contact address is info@ianubih.ba.',
                ],
            ],
            [
                'title' => '2. Data we may collect',
                'paragraphs' => [
                    'We collect data when you enter it yourself, create a user account or consent to the use of visitor analytics.',
                ],
                'items' => [
                    'User account data: name, email address, encrypted password, assigned role and account creation or modification time.',
                    'Cooperation proposal data: name, email address, organisation if provided, partner type, initiative title, message content and form language.',
                    'Technical and security data: session data, IP address and user agent that may be recorded for sign-in, form protection, abuse prevention and error diagnostics.',
                    'Analytics data after consent: pages visited, approximate location, device and browser type, duration and use of the website. We do not send a user’s name or email address to Google Analytics.',
                ],
            ],
            [
                'title' => '3. Purposes and legal grounds',
                'items' => [
                    'Reviewing cooperation proposals and communicating with the sender, based on consent and steps taken at the sender’s request.',
                    'Creating and administering user accounts and protecting the administration area.',
                    'Publishing and administering news and other public content.',
                    'Maintaining the security, reliability and functionality of the website on the basis of IANUBIH’s legitimate interests.',
                    'Measuring website use through Google Analytics only after the visitor has given consent.',
                ],
            ],
            [
                'title' => '4. Recipients and external services',
                'paragraphs' => [
                    'Data is accessible only to authorised IANUBIH administrators and technical service providers where necessary for hosting, email, maintenance or website security.',
                    'If you accept analytics cookies, data is processed by Google as part of Google Analytics. Google may process data outside Bosnia and Herzegovina or the European Economic Area subject to its contractual and legal data-protection mechanisms.',
                    'We do not sell personal data or use it for automated decision-making.',
                ],
            ],
            [
                'title' => '5. Retention',
                'paragraphs' => [
                    'We retain data only for as long as necessary for the purpose for which it was collected, handling requests, maintaining justified records, system security and compliance with legal obligations. An account is retained while active or until it is justifiably removed. Cooperation proposals are reviewed periodically and deleted when no longer required.',
                    'Analytics cookie durations are listed in the Cookie policy. Retention within Google Analytics is determined by the settings of the GA4 property.',
                ],
            ],
            [
                'title' => '6. Your rights',
                'paragraphs' => [
                    'Subject to applicable data-protection law, you may request access, correction, completion, deletion, restriction or portability of your data and object to certain processing. You may withdraw consent at any time without affecting the lawfulness of processing carried out before withdrawal.',
                    'To exercise your rights, email info@ianubih.ba. You also have the right to lodge a complaint with the Personal Data Protection Agency in Bosnia and Herzegovina and seek judicial protection.',
                ],
            ],
            [
                'title' => '7. Data security',
                'paragraphs' => [
                    'We apply organisational and technical measures appropriate to the nature of the data, including access controls, password hashing, form protection and restricted administration permissions. No method of transmitting or storing data can be considered absolutely secure.',
                ],
            ],
            [
                'title' => '8. Policy changes',
                'paragraphs' => [
                    'We may update this policy when website functions, service providers or legal obligations change. The latest revision date will always appear on this page.',
                ],
            ],
        ],
    ],
    'cookies' => [
        'meta' => [
            'title' => 'Cookie Policy | IANUBIH',
            'description' => 'An overview of essential and analytics cookies used on the IANUBIH website and how consent can be managed.',
        ],
        'title' => 'Cookie Policy',
        'intro' => 'This policy explains which cookies and similar technologies the IANUBIH website uses and how you can accept, refuse or later change your choice.',
        'sections' => [
            [
                'title' => '1. What cookies are',
                'paragraphs' => [
                    'Cookies are small text files stored in a browser. The website also uses browser local storage to remember your analytics choice. Essential technologies support sign-in, security and forms, while analytics technologies are used only with consent.',
                ],
            ],
            [
                'title' => '2. Technologies we use',
                'table' => [
                    'headings' => ['Name', 'Provider', 'Purpose', 'Duration'],
                    'rows' => [
                        ['Website session cookie', 'IANUBIH', 'Maintains user sign-in, session and security.', 'Up to 120 minutes of inactivity, according to session settings.'],
                        ['XSRF-TOKEN', 'IANUBIH', 'Protects forms and requests against unauthorised submission.', 'For the duration of the session.'],
                        ['ianubih_analytics_consent', 'IANUBIH – local storage', 'Remembers whether analytics was accepted or refused.', 'Until you change the choice or clear browser data.'],
                        ['_ga', 'Google Analytics', 'Distinguishes visitors for aggregated statistics.', 'Up to 2 years, only after consent.'],
                        ['_ga_<ID>', 'Google Analytics', 'Persists analytics session state.', 'Up to 2 years, only after consent.'],
                    ],
                ],
            ],
            [
                'title' => '3. Managing consent',
                'paragraphs' => [
                    'On your first visit, you can accept or refuse analytics. Refusal does not limit access to public content. You can later change your choice using the Cookie settings button that remains available on the website.',
                ],
                'show_cookie_settings' => true,
            ],
            [
                'title' => '4. Google Analytics',
                'paragraphs' => [
                    'After consent, Google Analytics 4 loads with measurement ID G-2KJZQ71XQX. The service helps us understand traffic, popular pages, approximate location and technical device characteristics. We do not send names, email addresses or cooperation proposal content to Google Analytics.',
                    'If you refuse analytics, the Google Analytics script is not loaded and analytics cookies are not set.',
                ],
            ],
            [
                'title' => '5. Browser settings',
                'paragraphs' => [
                    'You can inspect and remove cookies through your browser settings. Clearing all website data also removes your saved choice, so the website will ask again. Blocking essential cookies may prevent sign-in and form submission.',
                ],
            ],
            [
                'title' => '6. Changes and contact',
                'paragraphs' => [
                    'We will update this policy when a new technology is introduced or the method of measurement changes. Questions may be sent to info@ianubih.ba.',
                ],
            ],
        ],
    ],
    'terms' => [
        'meta' => [
            'title' => 'Terms of Use | IANUBIH',
            'description' => 'Terms governing access to and use of the IANUBIH website, content, user accounts and forms.',
        ],
        'title' => 'Terms of Use',
        'intro' => 'By using this website, you accept the rules that protect IANUBIH content, users and the secure operation of its digital services.',
        'sections' => [
            [
                'title' => '1. Purpose of the website',
                'paragraphs' => [
                    'The website publishes information about IANUBIH, its fields of activity, projects, events, publications, news and cooperation opportunities. Content is informational and does not constitute legal, medical, financial or other individual professional advice.',
                ],
            ],
            [
                'title' => '2. Accuracy and availability',
                'paragraphs' => [
                    'We seek to publish accurate and current information but do not guarantee that every item will always be complete or error-free. Access may be temporarily restricted for maintenance, security or technical reasons.',
                ],
            ],
            [
                'title' => '3. Copyright and permitted use',
                'paragraphs' => [
                    'Texts, visual identity, photographs, publications and other materials belong to IANUBIH or are published under an appropriate right of use, unless stated otherwise.',
                    'You may quote and share content for personal, educational and non-commercial purposes with clear attribution and without changing its meaning. Commercial use, complete reproduction or adaptation requires prior written permission.',
                ],
            ],
            [
                'title' => '4. User accounts',
                'items' => [
                    'Users are responsible for the accuracy of account data and for keeping their password secure.',
                    'Administration access is granted by the chief administrator and may be removed when no longer required or where there is a security reason.',
                    'Attempts at unauthorised access, disruption, malicious code insertion or form abuse are prohibited.',
                ],
            ],
            [
                'title' => '5. Cooperation proposals',
                'paragraphs' => [
                    'By submitting a proposal, you confirm that you are authorised to provide the entered data and that the content is lawful and does not infringe another person’s rights. Submitting a form does not create a contract, funding commitment, partnership or obligation for IANUBIH to accept the proposal.',
                ],
            ],
            [
                'title' => '6. External links',
                'paragraphs' => [
                    'The website may link to external websites, publications and social networks. IANUBIH does not control those services and is not responsible for their content, availability or privacy practices.',
                ],
            ],
            [
                'title' => '7. Limitation of liability',
                'paragraphs' => [
                    'To the extent permitted by applicable law, IANUBIH is not liable for damage caused solely by reliance on general website information, temporary unavailability or the conduct of external service providers. This does not exclude liability that cannot lawfully be excluded.',
                ],
            ],
            [
                'title' => '8. Governing law and changes',
                'paragraphs' => [
                    'These terms are governed by the laws of Bosnia and Herzegovina. We may amend them to reflect website functions or legal requirements. Questions may be sent to info@ianubih.ba.',
                ],
            ],
        ],
    ],
];
