<?php

return [
    [
        'label' => 'navigation.about',
        'active' => ['about', 'academy.*'],
        'children' => [
            ['label' => 'navigation.overview', 'route' => 'about'],
            ['label' => 'sections.pages.academy.mission-vision.title', 'route' => 'academy.topic', 'params' => ['topic' => 'mission-vision']],
            ['label' => 'sections.pages.academy.presidents-message.title', 'route' => 'academy.topic', 'params' => ['topic' => 'presidents-message']],
            ['label' => 'sections.pages.academy.regulations.title', 'route' => 'academy.topic', 'params' => ['topic' => 'regulations']],
            ['label' => 'sections.pages.academy.statute.title', 'route' => 'academy.topic', 'params' => ['topic' => 'statute']],
            ['label' => 'sections.pages.academy.reports.title', 'route' => 'academy.topic', 'params' => ['topic' => 'reports']],
            ['label' => 'sections.pages.academy.work-plans.title', 'route' => 'academy.topic', 'params' => ['topic' => 'work-plans']],
            ['label' => 'sections.pages.academy.history.title', 'route' => 'academy.topic', 'params' => ['topic' => 'history']],
        ],
    ],
    [
        'label' => 'navigation.members',
        'active' => ['people', 'people.show', 'members.*'],
        'children' => [
            ['label' => 'navigation.overview', 'route' => 'people'],
            ['label' => 'sections.pages.members.regular.title', 'route' => 'members.topic', 'params' => ['topic' => 'regular']],
            ['label' => 'sections.pages.members.associate.title', 'route' => 'members.topic', 'params' => ['topic' => 'associate']],
            ['label' => 'sections.pages.members.honorary.title', 'route' => 'members.topic', 'params' => ['topic' => 'honorary']],
            ['label' => 'sections.pages.members.by-division.title', 'route' => 'members.topic', 'params' => ['topic' => 'by-division']],
        ],
    ],
    [
        'label' => 'navigation.organization',
        'active' => ['organization', 'organization.*'],
        'children' => [
            ['label' => 'navigation.overview', 'route' => 'organization'],
            ['label' => 'sections.pages.organization.board.title', 'route' => 'organization.topic', 'params' => ['topic' => 'board']],
            ['label' => 'sections.pages.organization.presidency.title', 'route' => 'organization.topic', 'params' => ['topic' => 'presidency']],
            ['label' => 'sections.pages.organization.assembly.title', 'route' => 'organization.topic', 'params' => ['topic' => 'assembly']],
            [
                'label' => 'sections.pages.organization.divisions.title',
                'children' => [
                    ['label' => 'navigation.overview', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions']],
                    ['label' => 'sections.pages.organization.divisions.children.social-sciences', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'social-sciences']],
                    ['label' => 'sections.pages.organization.divisions.children.humanities', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'humanities']],
                    ['label' => 'sections.pages.organization.divisions.children.medical-sciences', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'medical-sciences']],
                    ['label' => 'sections.pages.organization.divisions.children.sustainable-development', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'sustainable-development']],
                    ['label' => 'sections.pages.organization.divisions.children.natural-mathematical-sciences', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'natural-mathematical-sciences']],
                    ['label' => 'sections.pages.organization.divisions.children.religion', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'religion']],
                    ['label' => 'sections.pages.organization.divisions.children.technical-sciences', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'technical-sciences']],
                    ['label' => 'sections.pages.organization.divisions.children.arts', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'arts']],
                    ['label' => 'sections.pages.organization.divisions.children.diaspora', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'diaspora']],
                    ['label' => 'sections.pages.organization.divisions.children.young-scientists', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'young-scientists']],
                    ['label' => 'sections.pages.organization.divisions.children.international-members', 'route' => 'organization.topic', 'params' => ['topic' => 'divisions', 'item' => 'international-members']],
                ],
            ],
            [
                'label' => 'sections.pages.organization.branches.title',
                'children' => [
                    ['label' => 'navigation.overview', 'route' => 'organization.topic', 'params' => ['topic' => 'branches']],
                    ['label' => 'sections.pages.organization.branches.children.sarajevo', 'route' => 'organization.topic', 'params' => ['topic' => 'branches', 'item' => 'sarajevo']],
                    ['label' => 'sections.pages.organization.branches.children.mostar', 'route' => 'organization.topic', 'params' => ['topic' => 'branches', 'item' => 'mostar']],
                ],
            ],
            ['label' => 'sections.pages.organization.committees.title', 'route' => 'organization.topic', 'params' => ['topic' => 'committees']],
            ['label' => 'sections.pages.organization.professional-services.title', 'route' => 'organization.topic', 'params' => ['topic' => 'professional-services']],
        ],
    ],
    ['label' => 'navigation.projects', 'route' => 'projects', 'active' => ['projects']],
    [
        'label' => 'navigation.publications',
        'active' => ['publications', 'publications.*'],
        'children' => [
            ['label' => 'navigation.overview', 'route' => 'publications'],
            ['label' => 'sections.pages.publications.sar.title', 'route' => 'publications.topic', 'params' => ['topic' => 'sar']],
            ['label' => 'sections.pages.publications.publishing.title', 'route' => 'publications.topic', 'params' => ['topic' => 'publishing']],
        ],
    ],
    [
        'label' => 'navigation.cooperation',
        'active' => ['cooperation', 'cooperation.*'],
        'children' => [
            ['label' => 'navigation.overview', 'route' => 'cooperation'],
            ['label' => 'sections.pages.cooperation.international.title', 'route' => 'cooperation.topic', 'params' => ['topic' => 'international']],
            ['label' => 'sections.pages.cooperation.domestic.title', 'route' => 'cooperation.topic', 'params' => ['topic' => 'domestic']],
        ],
    ],
    ['label' => 'navigation.news', 'route' => 'news', 'active' => ['news', 'news.show']],
    ['label' => 'navigation.awards', 'route' => 'awards', 'active' => ['awards']],
];
