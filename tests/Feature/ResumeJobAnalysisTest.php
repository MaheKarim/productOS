<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResumeJobAnalysisTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_analyze_button_on_job_details_page()
    {
        $job = Job::factory()->create([
            'job_title' => 'Software Engineer',
            'company_name' => 'Tech Corp',
            'job_details' => 'We need a software engineer with PHP and Laravel experience.',
            'job_data' => [
                'skills' => ['PHP', 'Laravel', 'MySQL'],
                'requirements' => ['3+ years experience', 'Bachelor degree']
            ]
        ]);

        $response = $this->get(route('jobs.show', $job->slug));

        $response->assertStatus(200);
        $response->assertSee('Analyze With My Resume');
        $response->assertSee(route('resume-builder.job-analysis', ['job_id' => $job->id]));
    }

    /** @test */
    public function it_redirects_to_login_for_unauthenticated_users()
    {
        $job = Job::factory()->create();

        $response = $this->get(route('jobs.show', $job->slug));

        $response->assertStatus(200);
        $response->assertSee('Analyze With My Resume');
        $response->assertSee(route('login'));
    }

    /** @test */
    public function it_requires_user_to_have_resume_data_for_analysis()
    {
        $user = User::factory()->create([
            'resume_data' => null
        ]);

        $job = Job::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('resume-builder.job-analysis', ['job_id' => $job->id]));

        $response->assertRedirect(route('resume-builder.index'));
        $response->assertSessionHas('error', 'Please upload your resume first to analyze it against job postings.');
    }

    /** @test */
    public function it_successfully_shows_analysis_results()
    {
        $user = User::factory()->create([
            'resume_data' => [
                'raw_text' => 'Software Engineer with 5 years experience in PHP, Laravel, and MySQL. Developed multiple web applications and led teams.',
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Team Leadership'],
                'experience' => [
                    [
                        'title' => 'Senior Software Engineer',
                        'company' => 'Tech Company',
                        'duration' => '2020-2024'
                    ]
                ]
            ]
        ]);

        $job = Job::factory()->create([
            'job_title' => 'Senior Software Engineer',
            'company_name' => 'Tech Corp',
            'job_details' => 'Looking for a senior software engineer with PHP, Laravel experience.',
            'job_data' => [
                'skills' => ['PHP', 'Laravel', 'MySQL'],
                'requirements' => ['5+ years experience', 'Team leadership skills']
            ]
        ]);

        $this->actingAs($user);

        // Mock the AI service response
        $this->mock(\App\Services\AiProviderService::class, function ($mock) {
            $mock->shouldReceive('getActiveProvider')->andReturn((object)[
                'default_model' => 'gpt-4'
            ]);
            
            $mock->shouldReceive('makeCompletionRequestWithFailover')->andReturn([
                'success' => true,
                'data' => [
                    'choices' => [
                        [
                            'message' => [
                                'content' => json_encode([
                                    'overall_match_score' => 85,
                                    'match_summary' => 'Strong match for this position',
                                    'gap_analysis' => [
                                        'missing_skills' => [],
                                        'missing_qualifications' => [],
                                        'experience_gaps' => []
                                    ],
                                    'strengths_assessment' => [
                                        'skill_matches' => [
                                            ['skill' => 'PHP', 'proficiency' => 'high', 'evidence' => '5 years experience']
                                        ],
                                        'relevant_experience' => [
                                            ['experience' => 'Senior Software Engineer', 'relevance' => 'high', 'years' => '4']
                                        ],
                                        'achievements_aligned' => []
                                    ],
                                    'weakness_identification' => [
                                        'skill_weaknesses' => [],
                                        'experience_shortfalls' => [],
                                        'presentation_issues' => []
                                    ],
                                    'resume_optimization_suggestions' => [
                                        'keyword_optimizations' => [],
                                        'content_recommendations' => [],
                                        'formatting_improvements' => []
                                    ],
                                    'interview_prep_focus_areas' => [
                                        'strengths_to_emphasize' => ['PHP expertise', 'Team leadership'],
                                        'weaknesses_to_address' => [],
                                        'key_stories_to_prepare' => [],
                                        'technical_topics_to_review' => ['Laravel best practices']
                                    ],
                                    'next_steps' => [
                                        'immediate_actions' => ['Apply for position'],
                                        'long_term_improvements' => [],
                                        'interview_preparation_priority' => 'high'
                                    ]
                                ])
                            ]
                        ]
                    ]
                ]
            ]);
        });

        $response = $this->get(route('resume-builder.job-analysis', ['job_id' => $job->id]));

        $response->assertStatus(200);
        $response->assertSee('Resume Analysis Results');
        $response->assertSee('85%');
        $response->assertSee('Strong match for this position');
        $response->assertSee('PHP expertise');
        $response->assertSee('Start Interview Prep');
    }
}