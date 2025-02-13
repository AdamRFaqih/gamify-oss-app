<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Models\Issue;


class GitHubService
{
    public static function getAllIssue()
    {
        $token = env('GITHUB_PERSONAL_ACCESS_TOKEN');
        $projectId = env('GITHUB_PROJECT_ID');

        $query = <<<GQL
        query {
            node(id: "$projectId") {
                ... on ProjectV2 {
                items(first: 100) {
                    nodes {
                    content {
                        ... on Issue {
                        id
                        number
                        title
                        url
                        state
                        createdAt
                        }
                    }
                    }
                }
                }
            }
            }
        GQL;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'content-type' => 'application/json',
        ])->post('https://api.github.com/graphql', [
            'query' => $query
        ]);
        
        $items = $response->json()['data']['node']['items']['nodes'];
        $res = [];
        foreach ($items as $item) {
            if (!empty($item['content'])) {
                $res[] = $item['content'];
            }
        }
        usort($res, function ($a, $b) {
            return $a['number'] <=> $b['number'];
        });
        return $res;


    }

    public static function syncIssue()
    {
        $issues = self::getAllIssue();
        foreach ($issues as $issue) {
            Issue::updateOrCreate(
                ['issue_id' => $issue['id']],
                [
                    'number' => $issue['number'],
                    'title' => $issue['title'],
                    'url' => $issue['url'],
                    'state' => $issue['state'],
                ]
            );
        }
    }

    public static function getUserId(string $username)
    {
        $token = env('GITHUB_PERSONAL_ACCESS_TOKEN');
        $query = <<<GQL
        query {
            user(login: "$username") {
                id
            }
        }
        GQL;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'content-type' => 'application/json',
        ])->post('https://api.github.com/graphql', [
            'query' => $query
        ]);
        return $response->json()['data']['user']['id'];
    }

    public static function setAsignee(string $issueId, string $username)
    {
        $token = env('GITHUB_PERSONAL_ACCESS_TOKEN');
        $userId = self::getUserId($username);
        $query = <<<GQL
        mutation {
            addAssigneesToAssignable(input: { assignableId: "$issueId", assigneeIds: ["$userId"] }) {
                assignable {
                ... on Issue {
                    id
                }
                ... on PullRequest {
                    id
                }
                }
            }
            }
        GQL;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'content-type' => 'application/json',
        ])->post('https://api.github.com/graphql', [
            'query' => $query
        ]);
        return $response->json();
    }

}