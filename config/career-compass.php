<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Status Thresholds
    |--------------------------------------------------------------------------
    */
    'status_thresholds' => [
        'exceptional' => 81,
        'thriving' => 61,
        'growing' => 41,
        'struggling' => 21,
        'critical' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Variables
    |--------------------------------------------------------------------------
    */
    'environment_variables' => [
        'manager' => [
            'label' => 'Manager',
            'question' => 'How would you rate your relationship with your direct manager?',
            'icon' => 'user',
            'why_matters' => 'Your manager is the most important variable. A great manager can improve most other factors, while a poor manager can make even good situations difficult.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Toxic relationship, no support, poor communication, blocks your growth'],
                [0.75, 1, 'Below Average', 'Basic working relationship, minimal support, occasional communication issues'],
                [1, 1.25, 'Average', 'Decent relationship, provides basic support, room for improvement'],
                [1.5, 1.75, 'Good', 'Strong relationship, good mentor, clear communication, advocates for you'],
                [1.75, 2, 'Excellent', 'Outstanding mentor, empowers you, fights for resources, accelerates your growth'],
            ],
        ],
        'resources' => [
            'label' => 'Resources',
            'question' => 'How adequate are your team size, budget, and tools?',
            'icon' => 'cube',
            'why_matters' => 'Without proper resources, even the best ideas can\'t be executed effectively. This affects your ability to have impact.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Severely understaffed, no budget, lacking critical tools, constant firefighting'],
                [0.75, 1, 'Below Average', 'Minimal resources, frequent resource constraints, some tools missing'],
                [1, 1.25, 'Average', 'Adequate resources for current work, occasional constraints'],
                [1.5, 1.75, 'Good', 'Well-resourced, rarely constrained, good tools available'],
                [1.75, 2, 'Excellent', 'Abundant resources, best-in-class tools, can execute any idea'],
            ],
        ],
        'team' => [
            'label' => 'Team',
            'question' => 'How skilled and collaborative are your team members?',
            'icon' => 'users',
            'why_matters' => 'Your team\'s skills directly affect velocity and quality. A great team multiplies your impact.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Major skill gaps, poor collaboration, high turnover, frequent conflicts'],
                [0.75, 1, 'Below Average', 'Some skill gaps, inconsistent collaboration, moderate turnover'],
                [1, 1.25, 'Average', 'Competent team, decent collaboration, acceptable retention'],
                [1.5, 1.75, 'Good', 'Highly skilled team, strong collaboration, low turnover'],
                [1.75, 2, 'Excellent', 'World-class team, exceptional collaboration, everyone wants to stay'],
            ],
        ],
        'scope' => [
            'label' => 'Scope',
            'question' => 'Is your scope of responsibility appropriate for your level?',
            'icon' => 'arrows-expand',
            'why_matters' => 'Too little scope limits your growth. Too much scope leads to burnout. The right scope drives impact.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Either too narrow (boring/no growth) or overwhelming (burnout risk)'],
                [0.75, 1, 'Below Average', 'Somewhat misaligned, either slightly too small or too large'],
                [1, 1.25, 'Average', 'Appropriate scope, matches your level'],
                [1.5, 1.75, 'Good', 'Perfect scope with clear growth opportunities and autonomy'],
                [1.75, 2, 'Excellent', 'Ideal scope, high impact potential, perfect stretch for growth'],
            ],
        ],
        'compensation' => [
            'label' => 'Compensation',
            'question' => 'How does your total compensation compare to market rates?',
            'icon' => 'currency-dollar',
            'why_matters' => 'Fair compensation affects motivation and financial security. It\'s a reflection of your value.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Significantly below market, no equity, poor benefits'],
                [0.75, 1, 'Below Average', 'Below market average, limited equity, basic benefits'],
                [1, 1.25, 'Average', 'Market average, some equity, standard benefits'],
                [1.5, 1.75, 'Good', 'Above market, good equity, excellent benefits'],
                [1.75, 2, 'Excellent', 'Top of market, significant equity, premium benefits'],
            ],
        ],
        'culture' => [
            'label' => 'Company Culture',
            'question' => 'How well does the company culture fit your values and working style?',
            'icon' => 'heart',
            'why_matters' => 'Culture affects everything - from daily happiness to long-term career growth. Wrong fit = constant friction.',
            'score_guides' => [
                [0, 0.5, 'Poor', 'Toxic culture, values misalignment, feel excluded, can\'t do best work'],
                [0.75, 1, 'Below Average', 'Challenging culture, some misalignment, struggle to fit in'],
                [1, 1.25, 'Average', 'Acceptable culture, mostly aligned, can work effectively'],
                [1.5, 1.75, 'Good', 'Great culture, strong alignment, feel supported and included'],
                [1.75, 2, 'Excellent', 'Perfect culture fit, completely aligned values, thrive here'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Skills Variables
    |--------------------------------------------------------------------------
    */
    'skills_variables' => [
        'communication' => [
            'label' => 'Communication',
            'question' => 'How effective are you at communicating ideas, writing docs, and presenting?',
            'icon' => 'chat',
            'examples' => ['Writing PRDs, strategy docs, emails', 'Presenting to leadership, stakeholders', 'Facilitating meetings, building consensus'],
            'score_guides' => [
                [0, 0.5, 'Needs Work', 'Struggle to articulate ideas, unclear writing, poor presentations'],
                [0.75, 1, 'Developing', 'Can communicate basics, adequate writing, acceptable presentations'],
                [1, 1.25, 'Competent', 'Clear communicator, good writing, solid presentations'],
                [1.5, 1.75, 'Strong', 'Excellent communicator, compelling writing, great presenter'],
                [1.75, 2, 'Expert', 'Master communicator, persuasive writing, inspiring presenter'],
            ],
        ],
        'leadership' => [
            'label' => 'Leadership & Influence',
            'question' => 'How well can you influence others without authority and lead cross-functional teams?',
            'icon' => 'flag',
            'examples' => ['Getting engineers excited about your roadmap', 'Influencing executives on strategy', 'Building trust across organizations', 'Conflict resolution'],
            'score_guides' => [
                [0, 0.5, 'Needs Work', 'Struggle to get buy-in, weak influence, can\'t lead effectively'],
                [0.75, 1, 'Developing', 'Can influence some people, basic leadership, inconsistent results'],
                [1, 1.25, 'Competent', 'Can build consensus, decent influence, lead small teams'],
                [1.5, 1.75, 'Strong', 'Strong influencer, natural leader, trusted by teams'],
                [1.75, 2, 'Expert', 'Master influencer, inspire others, lead large initiatives'],
            ],
        ],
        'strategy' => [
            'label' => 'Strategic Thinking',
            'question' => 'How well can you think long-term, prioritize, and connect to business goals?',
            'icon' => 'light-bulb',
            'examples' => ['Building product strategy and vision', 'Using frameworks (RICE, ICE, Kano)', 'Prioritizing roadmap ruthlessly', 'Connecting product to revenue/growth'],
            'score_guides' => [
                [0, 0.5, 'Needs Work', 'Tactical only, poor prioritization, can\'t see big picture'],
                [0.75, 1, 'Developing', 'Some strategy, basic prioritization, understand immediate goals'],
                [1, 1.25, 'Competent', 'Strategic thinker, good prioritization, align to business'],
                [1.5, 1.75, 'Strong', 'Excellent strategist, expert prioritization, drive business impact'],
                [1.75, 2, 'Expert', 'Visionary strategist, perfect prioritization, shape company direction'],
            ],
        ],
        'execution' => [
            'label' => 'Execution',
            'question' => 'How effectively do you ship products, run experiments, and drive results?',
            'icon' => 'lightning-bolt',
            'examples' => ['Shipping features on time and quality', 'Running A/B tests effectively', 'Using data to make decisions', 'Unblocking teams, removing obstacles'],
            'score_guides' => [
                [0, 0.5, 'Needs Work', 'Slow execution, miss deadlines, poor results'],
                [0.75, 1, 'Developing', 'Decent execution, sometimes late, acceptable results'],
                [1, 1.25, 'Competent', 'Good execution, usually on time, solid results'],
                [1.5, 1.75, 'Strong', 'Excellent execution, always deliver, strong results'],
                [1.75, 2, 'Expert', 'World-class execution, exceed expectations, exceptional results'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    */
    'recommendations' => [
        'manager' => [
            'critical' => [
                'title' => 'Address Manager Relationship',
                'actions' => [
                    'Schedule weekly 1-on-1s to build relationship',
                    'Come prepared with agenda to show professionalism',
                    'Ask for specific feedback on your work',
                    'Understand what your manager is optimizing for',
                    'If no improvement in 3 months, consider internal transfer',
                ],
                'timeline' => '1-2 months',
                'resources' => ['How to Manage Your Manager article'],
            ],
            'improvement' => [
                'title' => 'Strengthen Manager Relationship',
                'actions' => [
                    'Increase communication frequency',
                    'Share wins and learnings proactively',
                    'Ask for stretch assignments',
                ],
                'timeline' => '3-6 months',
            ],
        ],
        'resources' => [
            'critical' => [
                'title' => 'Address Resource Constraints',
                'actions' => [
                    'Document how lack of resources impacts deliverables',
                    'Build business case with ROI data',
                    'Present to manager with specific requests',
                    'Prioritize ruthlessly with current capacity',
                ],
                'timeline' => '1-2 months',
                'resources' => ['Building Resource Request Template'],
            ],
        ],
        'compensation' => [
            'critical' => [
                'title' => 'Address Compensation Gap',
                'actions' => [
                    'Research market rates (Glassdoor, LinkedIn)',
                    'Document your impact and achievements',
                    'Get competing offers to understand market value',
                    'Schedule comp conversation with manager',
                    'If no progress, consider external opportunities',
                ],
                'timeline' => '2-3 months',
                'resources' => ['PM Compensation Guide'],
            ],
        ],
        'communication' => [
            'improvement' => [
                'title' => 'Develop Communication Skills',
                'actions' => [
                    'Take technical writing course',
                    'Practice with Amazon 6-pager format',
                    'Get feedback on your PRDs/docs',
                    'Join Toastmasters for presentation skills',
                    'Record yourself presenting, review',
                ],
                'timeline' => '3-6 months',
            ],
        ],
        'leadership' => [
            'improvement' => [
                'title' => 'Develop Leadership Skills',
                'actions' => [
                    'Find a leadership mentor',
                    'Read: Influence Without Authority',
                    'Lead one small cross-functional initiative',
                    'Practice stakeholder management',
                    'Study how senior PMs lead',
                ],
                'timeline' => '3-6 months',
            ],
        ],
        'strategy' => [
            'improvement' => [
                'title' => 'Develop Strategic Thinking',
                'actions' => [
                    'Study product strategy frameworks',
                    'Practice writing strategy docs',
                    'Learn from successful strategies',
                    'Shadow strategic PMs',
                    'Read: Good Strategy, Bad Strategy',
                ],
                'timeline' => '6-12 months',
            ],
        ],
        'execution' => [
            'improvement' => [
                'title' => 'Improve Execution Skills',
                'actions' => [
                    'Improve project management skills',
                    'Learn agile/scrum thoroughly',
                    'Study why past projects were late',
                    'Focus on smaller, shippable increments',
                ],
                'timeline' => '3-6 months',
            ],
        ],
    ],
];
