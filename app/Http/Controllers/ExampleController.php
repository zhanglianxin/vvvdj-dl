<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function hello($url = 'http://www.vvvdj.com/radio/3454.html')
    {
        putenv('webdriver.chrome.driver=' . env('CHROME_DRIVER'));

        $caps = DesiredCapabilities::chrome();
        $options = new ChromeOptions();
        $options->addArguments(['--window-size=1920,1080', '--disable-gpu', '--headless']);
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = ChromeDriver::start($caps);
        $driver->get($url);

        $audio = WebDriverBy::id('jp_audio_0');
        $anchorNext = WebDriverBy::xpath('//*[@id="ico-next"]/a');
        if (!$elem = isElementExist($driver, $audio)) {
            // exit
        } else {
            $ids = $driver->executeScript('MUSICID');
            // "{\"Result\":200,\"Data\":[{\"id\":\"158451\",\"musicname\":\"\\u97a0\\u6587\\u5a34 - BINGBIAN\\u75c5\\u53d8(Yaha Electro Rmx 2018)\"},{\"id\":\"155969\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e50\\u51b0\\u51bb12\\u6708\\u96ea\\u4e0b\\u7684\\u90a3\\u4e48\\u8ba4\\u771f\\u4e32\\u70e7\"},{\"id\":\"155399\",\"musicname\":\"\\u97e9\\u7ea2 - \\u4e00\\u4e2a\\u4eba(Dj3esr\\u738b\\u8d6b Extended Rmx 2017)\"},{\"id\":\"158209\",\"musicname\":\"\\u4e8e\\u6587\\u6587 - \\u4f53\\u9762(Dj\\u8d3a\\u4ed4 Krk Studio Rmx 2018)\"},{\"id\":\"157797\",\"musicname\":\"Dj\\u5c71\\u5f1f-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u9001\\u7ed9\\u97f6\\u5173DJKO\\u8f66\\u8f7dHi\\u6162\\u6447A1\\u4e32\\u70e7\"},{\"id\":\"158740\",\"musicname\":\"Dj\\u5999\\u97f3-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedDisco\\u97f3\\u4e5080000X\\u75c5\\u53d8X\\u6211\\u662f\\u771f\\u7684\\u7231\\u4e0a\\u4f60\\u97f3\\u4e50\"},{\"id\":\"151030\",\"musicname\":\"\\u4e1c\\u839eDJMask-\\u5168\\u4e2d\\u6587\\u56fd\\u8bedClub\\u97f3\\u4e50\\u5f00\\u5fc3\\u65f6\\u5165\\u8033\\u4f24\\u5fc3\\u65f6\\u5165\\u5fc3\\u4e32\\u70e7\"},{\"id\":\"158782\",\"musicname\":\"\\u84dd\\u6eaaDj\\u6d69\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedHouse\\u97f3\\u4e50Li\\u5f64Decaderover\\u6162\\u6447\\u4e32\\u70e7\"},{\"id\":\"158783\",\"musicname\":\"\\u6000\\u96c6DjRIO-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u8fd1\\u671f\\u70ed\\u64ad\\u4f53\\u9762\\u4e0a\\u5934\\u8df3\\u821eDj\\u4e32\\u70e7\"},{\"id\":\"159034\",\"musicname\":\"\\u6069\\u5e73Dj\\u950b\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedProgHouse\\u97f3\\u4e50\\u7ed9\\u6770\\u4ed4\\u7f14\\u9020\\u5305\\u623f\\u4e32\\u70e7\"},{\"id\":\"159080\",\"musicname\":\"DJ\\u7ec6VIN-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u7cbe\\u90093\\u6708\\u70ed\\u64ad\\u4e2d\\u6587\\u699c\\u6b4c\\u5355\\u4e32\\u70e7\"},{\"id\":\"159127\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e503\\u6708\\u795e\\u66f2\\u8d77\\u98ce\\u4e86\\u957f\\u5c9b\\u51b0\\u8336\\u4e32\\u70e7\"},{\"id\":\"156808\",\"musicname\":\"DjHs\\u534e\\u5c11-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u6211\\u6c38\\u8fdc\\u5728\\u4f60\\u8eab\\u540e\\u505a\\u4f60\\u7684\\u5907\\u7231\\u4e32\\u70e7\"},{\"id\":\"156325\",\"musicname\":\"\\u4e91\\u6d6eDJXC-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u6253\\u9020\\u8fd1\\u671f\\u6d41\\u884c\\u55e8\\u66f2\\u6162\\u6447\\u4e32\\u70e7\"},{\"id\":\"157560\",\"musicname\":\"\\u6069\\u5e73Dj\\u950b\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e50\\u6211\\u4ee5\\u4e3a\\u80fd\\u5fd8\\u8bb0\\u4f60\\u5e84\\u5fc3\\u598d\\u4e32\\u70e7\"},{\"id\":\"157674\",\"musicname\":\"DjCoco\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedProgHouse\\u97f3\\u4e50\\u5305\\u623f\\u70ed\\u6253\\u795e\\u4ed9\\u6c34\\u4e13\\u7528\\u4e32\\u70e7\"},{\"id\":\"158881\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bed\\u6162\\u6b4c\\u8fde\\u7248\\u97f3\\u4e50\\u70ed\\u95e8\\u6296\\u97f3\\u6700\\u7f8e\\u7684\\u671f\\u5f85\\u4e32\\u70e7\"},{\"id\":\"159717\",\"musicname\":\"DjCoco\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u83b1\\u6069\\u73b0\\u573a\\u5f55\\u5236\\u5fa1\\u666f\\u8c6a\\u5eadC2\\u680b\\u4e32\\u70e7\"},{\"id\":\"159827\",\"musicname\":\"\\u4e8e\\u6587\\u6587 - \\u4f53\\u9762(Dj\\u94ed\\u4ed4 ProgHouse Rmx 2018 V3)\"}]}"
            $req = "http://www.vvvdj.com/play/ajax/temp?ids=${ids}";
            // TODO make a HTTP request
            $response = "{\"Result\":200,\"Data\":[{\"id\":\"158451\",\"musicname\":\"\\u97a0\\u6587\\u5a34 - BINGBIAN\\u75c5\\u53d8(Yaha Electro Rmx 2018)\"},{\"id\":\"155969\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e50\\u51b0\\u51bb12\\u6708\\u96ea\\u4e0b\\u7684\\u90a3\\u4e48\\u8ba4\\u771f\\u4e32\\u70e7\"},{\"id\":\"155399\",\"musicname\":\"\\u97e9\\u7ea2 - \\u4e00\\u4e2a\\u4eba(Dj3esr\\u738b\\u8d6b Extended Rmx 2017)\"},{\"id\":\"158209\",\"musicname\":\"\\u4e8e\\u6587\\u6587 - \\u4f53\\u9762(Dj\\u8d3a\\u4ed4 Krk Studio Rmx 2018)\"},{\"id\":\"157797\",\"musicname\":\"Dj\\u5c71\\u5f1f-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u9001\\u7ed9\\u97f6\\u5173DJKO\\u8f66\\u8f7dHi\\u6162\\u6447A1\\u4e32\\u70e7\"},{\"id\":\"158740\",\"musicname\":\"Dj\\u5999\\u97f3-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedDisco\\u97f3\\u4e5080000X\\u75c5\\u53d8X\\u6211\\u662f\\u771f\\u7684\\u7231\\u4e0a\\u4f60\\u97f3\\u4e50\"},{\"id\":\"151030\",\"musicname\":\"\\u4e1c\\u839eDJMask-\\u5168\\u4e2d\\u6587\\u56fd\\u8bedClub\\u97f3\\u4e50\\u5f00\\u5fc3\\u65f6\\u5165\\u8033\\u4f24\\u5fc3\\u65f6\\u5165\\u5fc3\\u4e32\\u70e7\"},{\"id\":\"158782\",\"musicname\":\"\\u84dd\\u6eaaDj\\u6d69\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedHouse\\u97f3\\u4e50Li\\u5f64Decaderover\\u6162\\u6447\\u4e32\\u70e7\"},{\"id\":\"158783\",\"musicname\":\"\\u6000\\u96c6DjRIO-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u8fd1\\u671f\\u70ed\\u64ad\\u4f53\\u9762\\u4e0a\\u5934\\u8df3\\u821eDj\\u4e32\\u70e7\"},{\"id\":\"159034\",\"musicname\":\"\\u6069\\u5e73Dj\\u950b\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedProgHouse\\u97f3\\u4e50\\u7ed9\\u6770\\u4ed4\\u7f14\\u9020\\u5305\\u623f\\u4e32\\u70e7\"},{\"id\":\"159080\",\"musicname\":\"DJ\\u7ec6VIN-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u7cbe\\u90093\\u6708\\u70ed\\u64ad\\u4e2d\\u6587\\u699c\\u6b4c\\u5355\\u4e32\\u70e7\"},{\"id\":\"159127\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e503\\u6708\\u795e\\u66f2\\u8d77\\u98ce\\u4e86\\u957f\\u5c9b\\u51b0\\u8336\\u4e32\\u70e7\"},{\"id\":\"156808\",\"musicname\":\"DjHs\\u534e\\u5c11-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u6211\\u6c38\\u8fdc\\u5728\\u4f60\\u8eab\\u540e\\u505a\\u4f60\\u7684\\u5907\\u7231\\u4e32\\u70e7\"},{\"id\":\"156325\",\"musicname\":\"\\u4e91\\u6d6eDJXC-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u6253\\u9020\\u8fd1\\u671f\\u6d41\\u884c\\u55e8\\u66f2\\u6162\\u6447\\u4e32\\u70e7\"},{\"id\":\"157560\",\"musicname\":\"\\u6069\\u5e73Dj\\u950b\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bedClub\\u97f3\\u4e50\\u6211\\u4ee5\\u4e3a\\u80fd\\u5fd8\\u8bb0\\u4f60\\u5e84\\u5fc3\\u598d\\u4e32\\u70e7\"},{\"id\":\"157674\",\"musicname\":\"DjCoco\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedProgHouse\\u97f3\\u4e50\\u5305\\u623f\\u70ed\\u6253\\u795e\\u4ed9\\u6c34\\u4e13\\u7528\\u4e32\\u70e7\"},{\"id\":\"158881\",\"musicname\":\"DjBilly\\u4ed4-\\u5168\\u4e2d\\u6587\\u5168\\u56fd\\u8bed\\u6162\\u6b4c\\u8fde\\u7248\\u97f3\\u4e50\\u70ed\\u95e8\\u6296\\u97f3\\u6700\\u7f8e\\u7684\\u671f\\u5f85\\u4e32\\u70e7\"},{\"id\":\"159717\",\"musicname\":\"DjCoco\\u4ed4-\\u5168\\u4e2d\\u6587\\u56fd\\u7ca4\\u8bedClub\\u97f3\\u4e50\\u83b1\\u6069\\u73b0\\u573a\\u5f55\\u5236\\u5fa1\\u666f\\u8c6a\\u5eadC2\\u680b\\u4e32\\u70e7\"},{\"id\":\"159827\",\"musicname\":\"\\u4e8e\\u6587\\u6587 - \\u4f53\\u9762(Dj\\u94ed\\u4ed4 ProgHouse Rmx 2018 V3)\"}]}";
            $result = json_decode($response, true);
            if (200 !== $result['Result']) {
                // exit
            } else {
                $musicNames = $result['Data'];
            }
            $src = $elem->getAttribute('src');

            if (!$nextBtn = isElementExist($driver, $anchorNext)) {
                // no next (but always have), so should check it by some other logic
            } else {
                $nextBtn->click();
            }
        }
        sleep(5);
        $driver->quit();
    }
}
