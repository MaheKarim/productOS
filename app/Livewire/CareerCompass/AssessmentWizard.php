<?php

namespace App\Livewire\CareerCompass;

use App\Models\CareerAssessment;
use App\Services\RecommendationEngine;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AssessmentWizard extends Component
{
    // Current step (1: Intro, 2: Environment, 3: Skills, 4: Review)
    public int $currentStep = 1;

    // Environment scores (6 variables)
    public float $manager = 1.0;
    public float $resources = 1.0;
    public float $team = 1.0;
    public float $scope = 1.0;
    public float $compensation = 1.0;
    public float $culture = 1.0;

    // Skills scores (4 variables)
    public float $communication = 1.0;
    public float $leadership = 1.0;
    public float $strategy = 1.0;
    public float $execution = 1.0;

    // Calculated values
    public float $environmentTotal = 6.0;
    public float $skillsTotal = 4.0;
    public float $impactScore = 24.0;

    // Assessment ID (after saving)
    public ?int $assessmentId = null;

    // Show results
    public bool $showResults = false;

    // Show login modal for guests
    public bool $showLoginModal = false;

    // Config
    public array $environmentConfig = [];
    public array $skillsConfig = [];

    public function mount()
    {
        $this->environmentConfig = config('career-compass.environment_variables', []);
        $this->skillsConfig = config('career-compass.skills_variables', []);

        // Check if there's a saved session
        $sessionData = session('career_compass_assessment');
        if ($sessionData) {
            $this->hydrateFromSession($sessionData);
        }
    }

    protected function hydrateFromSession(array $data): void
    {
        $this->manager = $data['manager'] ?? 1.0;
        $this->resources = $data['resources'] ?? 1.0;
        $this->team = $data['team'] ?? 1.0;
        $this->scope = $data['scope'] ?? 1.0;
        $this->compensation = $data['compensation'] ?? 1.0;
        $this->culture = $data['culture'] ?? 1.0;
        $this->communication = $data['communication'] ?? 1.0;
        $this->leadership = $data['leadership'] ?? 1.0;
        $this->strategy = $data['strategy'] ?? 1.0;
        $this->execution = $data['execution'] ?? 1.0;
        $this->currentStep = $data['currentStep'] ?? 1;

        $this->calculateTotals();
    }

    protected function saveToSession(): void
    {
        session([
            'career_compass_assessment' => [
                'manager' => $this->manager,
                'resources' => $this->resources,
                'team' => $this->team,
                'scope' => $this->scope,
                'compensation' => $this->compensation,
                'culture' => $this->culture,
                'communication' => $this->communication,
                'leadership' => $this->leadership,
                'strategy' => $this->strategy,
                'execution' => $this->execution,
                'currentStep' => $this->currentStep,
            ]
        ]);
    }

    public function updatedManager(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedResources(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedTeam(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedScope(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedCompensation(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedCulture(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedCommunication(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedLeadership(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedStrategy(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }
    public function updatedExecution(): void
    {
        $this->calculateTotals();
        $this->saveToSession();
    }

    public function calculateTotals(): void
    {
        $this->environmentTotal = $this->manager
            + $this->resources
            + $this->team
            + $this->scope
            + $this->compensation
            + $this->culture;

        $this->skillsTotal = $this->communication
            + $this->leadership
            + $this->strategy
            + $this->execution;

        $this->impactScore = round($this->environmentTotal * $this->skillsTotal, 2);
    }

    public function nextStep(): void
    {
        if ($this->currentStep < 4) {
            $this->currentStep++;
            $this->saveToSession();
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->saveToSession();
        }
    }

    public function goToStep(int $step): void
    {
        if ($step >= 1 && $step <= 4) {
            $this->currentStep = $step;
            $this->saveToSession();
        }
    }

    public function startAssessment(): void
    {
        $this->currentStep = 2;
        $this->saveToSession();
    }

    public function calculateResults(): void
    {
        $this->calculateTotals();

        // Check if user is logged in
        if (!Auth::check()) {
            $this->showLoginModal = true;
            return;
        }

        $this->saveAssessment();
        $this->showResults = true;
    }

    public function closeLoginModal(): void
    {
        $this->showLoginModal = false;
    }

    public function continueAsGuest(): void
    {
        $this->showLoginModal = false;
        $this->saveAssessment();
        $this->showResults = true;
    }

    public function saveAssessment(): void
    {
        $assessment = CareerAssessment::create([
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'manager_score' => $this->manager,
            'resources_score' => $this->resources,
            'team_score' => $this->team,
            'scope_score' => $this->scope,
            'compensation_score' => $this->compensation,
            'culture_score' => $this->culture,
            'communication_score' => $this->communication,
            'leadership_score' => $this->leadership,
            'strategy_score' => $this->strategy,
            'execution_score' => $this->execution,
            'environment_total' => $this->environmentTotal,
            'skills_total' => $this->skillsTotal,
            'impact_score' => $this->impactScore,
            'assessment_date' => now(),
        ]);

        $this->assessmentId = $assessment->id;

        // Store latest assessment in session for guests
        session(['career_compass_latest_id' => $assessment->id]);

        // Clear the in-progress session data
        session()->forget('career_compass_assessment');
    }

    public function retakeAssessment(): void
    {
        // Reset all scores
        $this->manager = 1.0;
        $this->resources = 1.0;
        $this->team = 1.0;
        $this->scope = 1.0;
        $this->compensation = 1.0;
        $this->culture = 1.0;
        $this->communication = 1.0;
        $this->leadership = 1.0;
        $this->strategy = 1.0;
        $this->execution = 1.0;

        $this->calculateTotals();
        $this->currentStep = 1;
        $this->showResults = false;
        $this->assessmentId = null;

        session()->forget('career_compass_assessment');
        session()->forget('career_compass_latest_id');
    }

    public function getProgressPercentage(): int
    {
        return match ($this->currentStep) {
            1 => 0,
            2 => 33,
            3 => 66,
            4 => 100,
            default => 0,
        };
    }

    public function getStatus(): string
    {
        $score = $this->impactScore;
        if ($score >= 81)
            return 'exceptional';
        if ($score >= 61)
            return 'thriving';
        if ($score >= 41)
            return 'growing';
        if ($score >= 21)
            return 'struggling';
        return 'critical';
    }

    public function getStatusLabel(): string
    {
        return match ($this->getStatus()) {
            'exceptional' => '🌟 Exceptional',
            'thriving' => '🟢 Thriving',
            'growing' => '🟡 Growing',
            'struggling' => '🟠 Struggling',
            'critical' => '🔴 Critical',
            default => 'Unknown',
        };
    }

    public function getStatusColor(): string
    {
        return match ($this->getStatus()) {
            'exceptional' => 'yellow',
            'thriving' => 'green',
            'growing' => 'amber',
            'struggling' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    public function getRecommendations(): array
    {
        if (!$this->assessmentId) {
            return [];
        }

        $assessment = CareerAssessment::find($this->assessmentId);
        if (!$assessment) {
            return [];
        }

        $engine = new RecommendationEngine();
        return $engine->generate($assessment);
    }

    public function getStrengths(): array
    {
        if (!$this->assessmentId) {
            return [];
        }

        $assessment = CareerAssessment::find($this->assessmentId);
        if (!$assessment) {
            return [];
        }

        $engine = new RecommendationEngine();
        return $engine->getStrengths($assessment);
    }

    public function render()
    {
        return view('livewire.career-compass.assessment-wizard', [
            'progressPercentage' => $this->getProgressPercentage(),
            'status' => $this->getStatus(),
            'statusLabel' => $this->getStatusLabel(),
            'statusColor' => $this->getStatusColor(),
            'recommendations' => $this->showResults ? $this->getRecommendations() : [],
            'strengths' => $this->showResults ? $this->getStrengths() : [],
        ]);
    }
}
