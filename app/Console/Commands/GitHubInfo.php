<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * 说个拿 openbilibili forked 仓库的思路：
 *
 * 0. `/users/$username/followers?page=1`
 *  遍历 openbilibili 这个用户的 followers
 * 1. `/users/$username/events/public`
 *  遍历每个用户的 public events，
 *  筛选时间大于源仓库 go-common 的创建时间的 ForkEvent，拿到可疑 repo
 * （时间不长一般用户不会产生太多内容，有需要可遍历第二页，分页参数同上）
 * 2. `/repos/$username/$repo`, `/repos/$username/$repo/readme`
 *  如果对 repo 请求返回 200，则请求 readme 文件，与源进行比对
 *
 * 补充：
 *  考虑到某些高级吃瓜群众，可能会重新建立备份仓库，第 1 步可以连同 CreateEvent 一起遍历出来
 *
 * ------------------------------------------------------------------
 *
 * 发现源码不要 fork，聪明地留一份 copy
 *  https://help.github.com/en/articles/duplicating-a-repository
 *
 * 最后：
 *  咱家虽然没拿到源码，趁机学一波 git 和 GitHub API 的使用还是不亏的
 */
class GitHubInfo extends Command
{
    const UA = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1 Safari/605.1.15';
    const API_HOST = 'https://api.github.com';

    private $today;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:info {user=openbilibili}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ha??';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->today = Carbon::create(2019, 4, 22, 23, 59, 59, 'Asia/Shanghai');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');

        try {
            $followers = $this->getFollowersViaUser($user);
            foreach ($followers as $follower) {
                $repos = $this->getReposViaUser($follower);
            }
            app('log')->debug('23', compact('followers', 'repos'));
        } catch (\Exception $e) {
            app('log')->error($e);
        } finally {

        }
    }

    /**
     * @param string $uri
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest(string $uri)
    {
        $client = new Client([
            'base_uri' => self::API_HOST,
            'headers' => [
                'User-Agent' => self::UA,
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);
        $response = $client->request('get', $uri);
        if (200 == $response->getStatusCode()) {
            $contents = $response->getBody()->getContents();
            app('log')->debug('contents', ['uri', 'contents']);
            return json_decode($contents, true);
        } else {
            return null;
        }
    }

    private function getFollowersViaUser($username)
    {
        // TODO get all followers
        $uri = "/users/$username/followers?page=29";
        $res = $this->makeRequest($uri);
        $result = [];
        foreach ($res as $one) {
            $result[] = $one['login'];
        }
        return $result;
    }

    private function getReposViaUser($username)
    {
        // TODO filter events and created_at > 2019-04-22T02:35:24Z, return repo name
        $uri = "/users/$username/events/public";
        $res = $this->makeRequest($uri);
        $repos = [];
        foreach ($res as $event) {
            if ('ForkEvent' == $event['type'] && (new Carbon($event['created_at']))->lessThan($this->today)) {
                app('log')->debug('event', [$event]);
                $repos[] = $event['payload']['forkee']['name'];
            }
        }
        return $repos;
    }

    private function getRepoViaRepo($username, $repo)
    {
        // TODO get repo status
        $uri = "/repos/$username/$repo";
        $res = $this->makeRequest($uri);
    }

    private function getReadmeViaRepo($username, $repo)
    {
        // TODO get repo readme file, diff with original
        $uri = "/repos/$username/$repo/readme";
        $res = $this->makeRequest($uri);
    }
}
