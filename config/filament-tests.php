<?php

return [
    /**
     * The directory where the tests will be generated in.
     */
    'directory_name' => env('FILAMENT_TESTS_DIRECTORY_NAME', 'tests/Feature'),

    /**
     * Whether to separate the tests into folders based on the resource name.
     */
    'separate_tests_into_folders' => env('FILAMENT_TESTS_SEPARATE_TESTS_INTO_FOLDERS', false),

    /**
     * Customize the tests to be generated.
     */
    'generate' => [
        'page' => [
            'auth' => [
                'login' => [
                    'render' => false,
                    'login' => false,
                ],

                'logout' => [
                    'logout' => false,
                ],

                'password_reset' => [
                    'render' => false,
                    'reset' => false,
                ],

                'registration' => [
                    'render' => false,
                    'register' => false,
                ],
            ],
        ],

        'resource' => [
            'page' => [
                'create' => [
                    'render' => false,

                    'action' => [
                        'render' => false,
                    ],

                    'form' => [
                        'field' => [
                            'disabled' => false,
                            'exists' => false,
                            'hidden' => false,
                            'validate' => false,
                        ],

                        'exists' => false,
                        'render' => false,
                        'validate' => false,
                    ],

                    'widget' => [
                        'render_footer_widgets' => false,
                        'render_header_widgets' => false,
                    ],


                ],

                'custom' => [], // TODO: Implement

                'edit' => [
                    'render' => false,

                    'action' => [
                        'render' => false,
                    ],

                    'form' => [
                        'field' => [
                            'disabled' => false,
                            'exists' => false,
                            'hidden' => false,
                            'validate' => false,
                        ],

                        'exists' => false,
                        'fill' => false,
                        'render' => false,
                        'validate' => false,
                    ],

                    'relation_manager' => [
                        'header_action' => [
                            'exist' => false,
                            'hidden' => false,
                            'visible' => false,
                        ],

                        'table' => [
                            'action' => [
                                'delete' => false,
                                'delete_force' => false,
                                'delete_soft' => false,
                                'exist' => false,
                                'hidden' => false,
                                'replicate' => false,
                                'restore' => false,
                                'url' => false,
                                'url_tab' => false,
                                'visible' => false,
                            ],

                            'bulk_action' => [
                                'delete' => false,
                                'delete_force' => false,
                                'delete_soft' => false,
                                'exist' => false,
                                'restore' => false,
                            ],

                            'column' => [
                                'cannot_render' => false,
                                'description_above' => false,
                                'description_below' => false,
                                'exist' => false,
                                'extra_attributes' => false,
                                'render' => false,
                                'search' => false,
                                'search_individually' => false,
                                'select' => false,
                                'sort' => false,
                            ],

                            'filter' => [
                                'exist' => false,
                                'hidden' => false,
                                'visible' => false,
                            ],

                            'summary' => [
                                'average' => false,
                                'count' => false,
                                'count_icon' => false,
                                'date_range' => false,
                                'range' => false,
                                'sum' => false,
                            ],

                            'description' => false,
                            'heading' => false,
                        ],

                        'list_records' => false,
                        'list_records_paginated' => false,
                        'render' => false,
                        'trashed' => false,
                    ],

                    'widget' => [
                        'render_footer_widgets' => false,
                        'render_header_widgets' => false,
                    ],

                ],

                'index' => [
                    'action' => [
                        'exist' => false,
                        'hidden' => false,
                        'visible' => false,
                    ],

                    'table' => [
                        'action' => [
                            'delete' => false,
                            'delete_force' => false,
                            'delete_soft' => false,
                            'exist' => false,
                            'replicate' => false,
                            'restore' => false,
                            'url' => false,
                            'url_tab' => false,
                        ],

                        'bulk_action' => [
                            'delete' => false,
                            'delete_force' => false,
                            'delete_soft' => false,
                            'exist' => false,
                            'restore' => false,
                        ],

                        'column' => [
                            'cannot_render' => false,
                            'description_above' => false,
                            'description_below' => false,
                            'exist' => false,
                            'extra_attributes' => false,
                            'render' => false,
                            'search' => false,
                            'search_individually' => false,
                            'select' => false,
                            'sort' => false,
                        ],

                        'filter' => [
                            'add' => false,
                            'remove' => false,
                            'reset' => false,
                        ],

                        'summary' => [
                            'average' => false,
                            'count' => false,
                            'count_icon' => false,
                            'date_range' => false,
                            'range' => false,
                            'sum' => false,
                        ],

                        'description' => false,
                        'heading' => false,
                    ],

                    'widget' => [
                        'render_footer_widgets' => false,
                        'render_header_widgets' => false,
                    ],

                    'list_records' => false,
                    'list_records_paginated' => false,
                    'render' => false,
                    'trashed' => false,
                ],

                'view' => [
                    'render' => false,

                    'action' => [
                        'render' => false,
                    ],

                    'form' => [
                        'render' => false,
                    ],

                    'infolist' => [
                        'action' => [
                            'exist' => false,
                        ],

                        'entry' => [
                            'render' => false,
                        ],

                        'render' => false,
                    ],

                    'relation_manager' => [
                        'header_action' => [
                            'exist' => false,
                            'hidden' => false,
                            'visible' => false,
                        ],

                        'table' => [
                            'action' => [
                                'delete' => false,
                                'delete_force' => false,
                                'delete_soft' => false,
                                'exist' => false,
                                'hidden' => false,
                                'replicate' => false,
                                'restore' => false,
                                'url' => false,
                                'url_tab' => false,
                                'visible' => false,
                            ],

                            'bulk_action' => [
                                'delete' => false,
                                'delete_force' => false,
                                'delete_soft' => false,
                                'exist' => false,
                                'restore' => false,
                            ],

                            'column' => [
                                'cannot_render' => false,
                                'description_above' => false,
                                'description_below' => false,
                                'exist' => false,
                                'extra_attributes' => false,
                                'render' => false,
                                'search' => false,
                                'search_individually' => false,
                                'select' => false,
                                'sort' => false,
                            ],

                            'filter' => [
                                'add' => false,
                                'remove' => false,
                                'reset' => false,
                            ],

                            'summary' => [
                                'average' => false,
                                'count' => false,
                                'count_icon' => false,
                                'date_range' => false,
                                'range' => false,
                                'sum' => false,
                            ],

                            'description' => false,
                            'heading' => false,
                        ],

                        'list_records' => false,
                        'list_records_paginated' => false,
                        'render' => false,
                        'trashed' => false,
                    ],

                    'widget' => [
                        'render_footer_widgets' => false,
                        'render_header_widgets' => false,
                    ],
                ],
            ],
        ],
    ],
];
