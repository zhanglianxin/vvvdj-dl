<?php

namespace App\Console\Commands;

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;

class VvvdjDl extends Command
{
    const UA = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1 Safari/605.1.15';

    /**
     * Hold music names
     *
     * @var array
     */
    private $musicNames;

    /**
     * The directory to save file
     *
     * @var string
     */
    private $directory;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vvvdj:dl {url=http://www.vvvdj.com/radio/3454.html : The radio url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download vvvdj music';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');
        $arr = mb_split('/', mb_split('.html', $url)[0]);
        $this->directory = end($arr) . '/';
        putenv('webdriver.chrome.driver=' . env('CHROME_DRIVER', shell_exec('which chromedriver')));

        $caps = DesiredCapabilities::chrome();
        $options = new ChromeOptions();
        $options->addArguments(['--window-size=1920,1080', '--disable-gpu', '--headless',
            '--no-sandbox', '--disable-dev-shm-usage', '--mute-audio',]);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);

        $driver = ChromeDriver::start($caps);
        $driver->get($url);

        $ids = $driver->executeScript('return MUSICID;');
        $this->getMusicNames($ids);
        $idsLen = count(mb_split(',', $ids));

        try {
            for ($count = 0; $count < $idsLen; $count++) {
                $url = $driver->getCurrentURL();
                $audio = WebDriverBy::cssSelector('audio#jp_audio_0[src]');
                $anchorNext = WebDriverBy::xpath('//*[@id="ico-next"]/a');

                $src = getElement($driver, $audio)->getAttribute('src');
                app('log')->info('current', compact('count', 'url', 'src'));

                $arr = mb_split('/', mb_split('.mp4?', $src)[0]);
                $filename = end($arr) . '.mp4';
                $this->save2File($src, $filename);
//                shell_exec("(wget '$src' -q -O storage/app/$filename) &");

                getElement($driver, $anchorNext)->click();
                // wait url changed
                $driver->wait(5, 250)
                    ->until(WebDriverExpectedCondition::not(
                        WebDriverExpectedCondition::urlIs($url)), 'not forward');
                // WELL, DO NOT DISTURB THE SERVER
                usleep(mt_rand(1000, 3000));
            }
        } catch (\Exception $e) {
            app('log')->error($e);
            $this->error($e->getMessage());
        } finally {
            $driver->quit();
        }
    }

    /**
     * @param string $url
     * @param string $filename
     */
    private function save2File(string $url, string $filename): void
    {
        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'User-Agent' => self::UA,
            ],
        ]);
        $client->requestAsync('get', '', [
            RequestOptions::STREAM => true,
        ])->then(function (ResponseInterface $res) use ($filename) {
            if ($this->write2File($filename, $res->getBody()->getContents())) {
                $this->line($filename);
            }
        }, function (RequestException $e) use ($filename) {
            $this->error($filename);
            app('log')->error($e);
        })->wait();
    }

    /**
     * @param string $ids
     */
    private function getMusicNames(string $ids): void
    {
        $url = 'http://www.vvvdj.com/play/ajax/temp';
        $client = new Client([
            'base_uri' => $url,
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'User-Agent' => self::UA,
            ],
        ]);
        $client->requestAsync('get', null, [
            'query' => [
                'ids' => $ids,
            ],
        ])->then(function (ResponseInterface $res) {
            $result = json_decode(json_decode($res->getBody()->getContents()), true);
            $this->musicNames = 200 == $result['Result'] ? $result['Data'] : null;
            app('log')->info('musicNames', $this->musicNames);
        }, function (RequestException $e) {
            $this->warn('fail to get music names');
            app('log')->error($e);
        })->wait();
    }

    /**
     * @param string $filename
     * @param $content
     * @return bool
     */
    private function write2File(string $filename, $content): bool
    {
        return app('filesystem')->disk('local')->write($this->directory . $filename, $content);
    }
}
