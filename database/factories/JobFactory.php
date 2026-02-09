<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        $jobTitles = [
            'Software Engineer',
            'Senior Software Engineer',
            'Full Stack Developer',
            'Frontend Developer',
            'Backend Developer',
            'DevOps Engineer',
            'Product Manager',
            'UX/UI Designer',
            'Data Scientist',
            'Marketing Manager',
            'Sales Representative',
            'Customer Success Manager'
        ];

        $companies = [
            'Tech Corp',
            'Innovation Labs',
            'Digital Solutions',
            'Cloud Systems',
            'Data Dynamics',
            'Creative Studios',
            'Growth Marketing',
            'Sales Force',
            'Customer First',
            'Product Excellence'
        ];

        $jobTypes = ['Full-time', 'Part-time', 'Contract', 'Remote'];
        $experienceLevels = ['Entry Level', 'Mid Level', 'Senior Level', 'Executive'];
        $locations = ['New York, NY', 'San Francisco, CA', 'Austin, TX', 'Remote', 'Chicago, IL', 'Seattle, WA'];

        return [
            'job_title' => $this->faker->randomElement($jobTitles),
            'company_name' => $this->faker->randomElement($companies),
            'location' => $this->faker->randomElement($locations),
            'job_type' => $this->faker->randomElement($jobTypes),
            'experience_level' => $this->faker->randomElement($experienceLevels),
            'salary_range' => '$' . rand(60, 200) . 'k - $' . rand(120, 300) . 'k',
            'job_details' => $this->faker->paragraphs(3, true),
            'job_data' => [
                'skills' => ['PHP', 'Laravel', 'JavaScript', 'React', 'MySQL', 'Git'],
                'benefits' => ['Health Insurance', 'Remote Work', '401k Match', 'Stock Options'],
                'requirements' => ['Bachelor\'s degree', '3+ years experience', 'Team player']
            ],
            'category_id' => JobCategory::factory(),
            'is_featured' => $this->faker->boolean(20),
            'status' => 'active',
            'views_count' => rand(0, 1000),
            'applications_count' => rand(0, 100),
            'source_url' => $this->faker->url(),
            'posted_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'expires_at' => $this->faker->dateTimeBetween('now', '+90 days'),
            'slug' => \Str::slug($this->faker->randomElement($jobTitles) . '-' . $this->faker->company()),
            'created_by' => 1,
        ];
    }
}