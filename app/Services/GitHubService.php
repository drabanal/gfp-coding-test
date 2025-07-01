<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    protected $baseUrl = 'https://api.github.com';
    protected $token = null;

    public function __construct()
    {
        $this->token = config('services.github.token');
    }

    /**
     * Get issues assigned to the authenticated user 
     */
    public function getUserAssignedIssues($state = 'open', $perPage = 30)
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->baseUrl}/issues", [
                    'filter' => 'assigned', // 'assigned', 'created', 'mentioned', 'subscribed', 'all'
                    'state' => $state,
                    'per_page' => $perPage
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('GitHub API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('GitHub Service Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get issue details by issue number/ID
     */
    public function getIssueDetails($owner, $repo, $issueNumber)
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->baseUrl}/repos/{$owner}/{$repo}/issues/{$issueNumber}");

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->status() === 404) {
                Log::warning("Issue #{$issueNumber} not found in {$owner}/{$repo}");
                return null;
            }

            Log::error('GitHub API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('GitHub Service Error: ' . $e->getMessage());
            return null;
        }
    }
}