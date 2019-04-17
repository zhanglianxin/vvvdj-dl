<?php

namespace App\Console\Commands;

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;

class VvvdjDl extends Command
{
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $url = $this->argument('url');
        putenv('webdriver.chrome.driver=' . env('CHROME_DRIVER', shell_exec('which chromedriver')));
        $caps = DesiredCapabilities::chrome();
        $options = new ChromeOptions();
        $options->addArguments(['--window-size=1920,1080', '--disable-gpu', '--headless',
            '--no-sandbox', '--disable-dev-shm-usage']);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = ChromeDriver::start($caps);
        $driver->get($url);

        $ids = $driver->executeScript('return MUSICID;');
        $idsLen = count(mb_split(',', $ids));
        static $count = 0;

        try {
            while ($count < $idsLen) {
                $audio = WebDriverBy::cssSelector('audio#jp_audio_0');
                $anchorNext = WebDriverBy::xpath('//*[@id="ico-next"]/a');

                $elem = isElementExist($driver, $audio);
                if (!$elem) {
                    sleep(floor(mt_rand(3000, 5000) / 1000));
                }
                $src = $elem->getAttribute('src');
                if (!$src) {
                    app('log')->info('audio', compact('elem', 'src'));
                    throw new \Exception('audio elem not found');
                } else {
                    $arr = mb_split('/', mb_split('.mp4?', $src)[0]);
                    $filename = end($arr) . '.mp4';

                    $writeSize = $this->save2File($filename, $this->getContent($src));
                    if (false !== $writeSize) {
                        $this->line($filename);
                    }

                    $nextBtn = isElementExist($driver, $anchorNext);
                    if (!$nextBtn) {
                        sleep(floor(mt_rand(2000, 3000) / 1000));
                    }
                    $nextBtn->click();
                    app('log')->debug('current', compact('count', 'src', 'filename'));
                    $count++;
                }
            }
        } catch (\Exception $e) {
            app('log')->error($e);
        } finally {
            $driver->quit();
        }
    }

    /**
     * @param string $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getContent(string $url): string
    {
        $client = new Client([
            'base_uri' => $url,
        ]);
        return $client->request('get', '', [
            RequestOptions::STREAM => true,
            RequestOptions::SYNCHRONOUS => true, // TODO request async
        ])->getBody()->getContents();
    }

    /**
     * @param string $ids
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getMusicNames(string $ids): array
    {
        $client = new Client([
            'base_uri' => "http://www.vvvdj.com/play/ajax/temp?ids={$ids}",
        ]);
        $contents = $client->request('get')->getBody()->getContents();
        $result = json_decode($contents, true);
        return 200 == $result['Result'] ? $result['Data'] : null;
    }

    /**
     * @param string $filename
     * @param string $content
     * @return int|bool
     */
    private function save2File(string $filename, string $content)
    {
        $fs = app('filesystem')->disk('local');
        if ($fs->exists($filename)) {
            $fs->delete($filename);
        }
        return $fs->put($filename, $content);
    }
}
