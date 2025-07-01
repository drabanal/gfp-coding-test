<?php

namespace App\Http\Controllers;

use App\Services\GitHubService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    protected $gitHubService;

    public function __construct(GitHubService $gitHubService)
    {
        $this->gitHubService = $gitHubService;
    }

    /**
     * Display assigned issues
     */
    public function myAssignedIssues(Request $request)
    {
        $state = $request->get('state', 'open');
        $items = $this->gitHubService->getUserAssignedIssues($state);
        
        $issues = [];

        foreach ($items as $item) {
            array_push($issues, [
                'id' => $item['id'],
                'number' => $item['number'],
                'title' => $item['title'],
                'body' => $item['body'],
                'owner' => $item['user']['login'],
                'repo' => $item['repository']['name'],
                'created_at' => Carbon::parse($item['created_at'])->format('Y-m-d H:i')
            ]);
        }

        return view('github.issues.lists', compact('issues'));
    }


    /**
     * Display issue details
     */
    public function issueDetails($owner, $repo, $issueNumber)
    {
        $issue = $this->gitHubService->getIssueDetails($owner, $repo, $issueNumber);

        if (!$issue) {
            abort(404, 'Issue not found');
        }
        
        $issue['created_at'] = Carbon::parse($issue['created_at'])->format('Y-m-d H:i');

        return view('github.issues.view', compact('issue', 'owner', 'repo'));
    }
}