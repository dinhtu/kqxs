<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Log;
use Sunra\PhpSimple\HtmlDomParser;

class CrawlBukken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CrawlBukken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        // $url = "https://suumo.jp/jj/bukken/ichiran/JJ012FC001/?ar=030&bs=021&cn=9999999&cnb=0&ekTjCd=&ekTjNm=&hb=0&ht=9999999&kb=1&kt=9999999&sc=12207&ta=12&tb=0&tj=0&tt=9999999&po=0&pj=1&pc=100";
        // $client = new Client();
        // $crawler = $client->request('GET', $url);
        // $pages = [];
        // $pages['https://suumo.jp/jj/bukken/ichiran/JJ012FC001/?ar=030&bs=021&cn=9999999&cnb=0&ekTjCd=&ekTjNm=&hb=0&ht=9999999&kb=1&kt=9999999&sc=12207&ta=12&tb=0&tj=0&tt=9999999&po=0&pj=1&pc=100'] = 'https://suumo.jp/jj/bukken/ichiran/JJ012FC001/?ar=030&bs=021&cn=9999999&cnb=0&ekTjCd=&ekTjNm=&hb=0&ht=9999999&kb=1&kt=9999999&sc=12207&ta=12&tb=0&tj=0&tt=9999999&po=0&pj=1&pc=100';
        // $crawler->filter('ol.pagination-parts li a')->each(function (Crawler $node) use (&$pages) {
        //     $pages['https://suumo.jp' . $node->filter('a')->attr('href')] = 'https://suumo.jp' . $node->filter('a')->attr('href');
        // });
        // $data = [];
        // $total = "";
        // foreach ($pages as $page) {
        //     $clientPage = new Client();
        //     $crawlerPage = $clientPage->request('GET', $page);
        //     $group = $crawlerPage->filter('div.property_unit_group');
        //     $total = $crawlerPage->filter('div.pagination_set-hit')->text();
        //     $group->filter('div.property_unit')->each(
        //         function (Crawler $node) use (&$data) {
        //             $item = [
        //                 "物件名" => "",
        //                 "販売価格" => "",
        //                 "所在地" => "",
        //                 "沿線・駅" => "",
        //                 "土地面積" => "",
        //                 "建物面積" => "",
        //                 "間取り" => "",
        //                 "築年月" => "",
        //                 "url-detail" => "",
        //             ];
        //             $info = $node->filter('.property_unit-info');
        //             $info->filter('dl')->each(function(Crawler $nodeDl) use (&$item) {
        //                 if (isset($item[trim($nodeDl->filter('dt')->text())])) {
        //                     $item[trim($nodeDl->filter('dt')->text())] = $nodeDl->filter('dd')->text();
        //                 }
        //             });
        //             $item['url-detail'] = 'https://suumo.jp' . $node->filter('.property_unit-title')->filter('a')->attr('href');
        //             if ($item['物件名'] == "") {
        //                 $item['物件名'] = $node->filter('.property_unit-title')->filter('a')->text();
        //             }
        //             $data[] = $item;
        //         }
        //     );
        // }
        // $filename = "C:\C#\ALC2002\WindowsFormsApp\WindowsFormsApp\bin\data.csv";

        // $handle = fopen($filename, 'w');
        // fputcsv($handle, $this->convert(array('全物件数：'.$total)));
        // fputcsv($handle, $this->convert(array('物件名', '販売価格', '所在地', '沿線・駅', '土地面積', '建物面積', '間取り', '築年月', 'url')));

        // foreach ($data as $item) {
        //     fputcsv($handle, $this->convert($item));
        //     # code...
        // }
        // fclose($handle);

        $arrUrl = [
            // [
            //     'name' => 'suumo・アットホームの対象URL',
            //     'url' => 'https://suumo.jp/jj/bukken/ichiran/JJ010FJ001/?ar=030&bs=021&ta=12&jspIdFlg=patternShikugun&sc=12207&kb=1&kt=9999999&tb=0&tt=9999999&hb=0&ht=9999999&ekTjCd=&ekTjNm=&tj=0&cnb=0&cn=9999999&srch_navi=1',
            // ],
            // [
            //     'name' => 'スーモ　新築一戸建て',
            //     'url' => 'https://suumo.jp/jj/bukken/ichiran/JJ010FJ001/?ar=030&bs=020&ta=12&jspIdFlg=patternShikugun&sc=12207&kb=1&kt=9999999&km=1&tb=0&tt=9999999&hb=0&ht=9999999&ekTjCd=&ekTjNm=&tj=0&kw=1&srch_navi=1',
            // ],
            // [
            //     'name' => 'スーモ　中古マンション',
            //     'url' => 'https://suumo.jp/jj/bukken/ichiran/JJ010FJ001/?ar=030&bs=020&ta=12&jspIdFlg=patternShikugun&sc=12207&kb=1&kt=9999999&km=1&tb=0&tt=9999999&hb=0&ht=9999999&ekTjCd=&ekTjNm=&tj=0&kw=1&srch_navi=1',
            // ],
            // [
            //     'name' => 'スーモ　新築マンション',
            //     'url' => 'https://suumo.jp/jj/bukken/ichiran/JJ010FJ001/?ar=030&bs=010&ta=12&firstFlg=0&urlFlg=0&jspIdFlg=1&sc=12207&kb=1&kt=9999999&km=1&mb=0&mt=9999999&ekTjCd=&ekTjNm=&tj=0&srch_navi=1',
            // ],
            // [
            //     'name' => 'アットホーム　中古一戸建て',
            //     'url' => 'https://www.athome.co.jp/kodate/chiba/matsudo-city/list/',
            // ],
            // [
            //     'name' => 'アットホーム　新築一戸建て',
            //     'url' => 'https://www.athome.co.jp/kodate/shinchiku/chiba/matsudo-city/list/',
            // ],
            // [
            //     'name' => 'アットホーム　中古マンション',
            //     'url' => 'https://www.athome.co.jp/mansion/chuko/chiba/matsudo-city/list/',
            // ],
            [
                'name' => 'アットホーム　新築マンション',
                'url' => 'https://www.athome.co.jp/mansion/shinchiku/chiba/matsudo/list/',
            ],
        ];
        $dataCrawl = [];
        foreach ($arrUrl as $urlItem) {
            $flag = true;
            $itemCrawl = [];
            $currentPage = 1;
            $total = 0;
            Log::info($urlItem['name']);
            switch ($urlItem['name']) {
                case 'suumo・アットホームの対象URL':
                case 'スーモ　新築一戸建て':
                case 'スーモ　中古マンション':
                    while ($flag) {
                        $page = $urlItem['url'] . '&pn=' . $currentPage;
                        $clientPage = new Client();
                        $crawlerPage = $clientPage->request('GET', $page);
                        $group = $crawlerPage->filter('div.property_unit_group');
                        if (count($group) == 0) {
                            $flag = false;
                            break;
                        }
                        Log::info($currentPage);
                        $currentPage++;
                        if (empty($total)) {
                            $total = $crawlerPage->filter('div.pagination_set-hit')->text();
                        }
                        $group->filter('div.property_unit')->each(
                            function (Crawler $node) use (&$itemCrawl) {
                                $item = [
                                    "物件名" => "",
                                    "販売価格" => "",
                                    "所在地" => "",
                                    "沿線・駅" => "",
                                    "土地面積" => "",
                                    "建物面積" => "",
                                    "間取り" => "",
                                    "築年月" => "",
                                    "url-detail" => "",
                                ];
                                $info = $node->filter('.property_unit-info');
                                $info->filter('dl')->each(function(Crawler $nodeDl) use (&$item) {
                                    if (isset($item[trim($nodeDl->filter('dt')->text())])) {
                                        $item[trim($nodeDl->filter('dt')->text())] = $nodeDl->filter('dd')->text();
                                    }
                                });
                                $item['url-detail'] = 'https://suumo.jp' . $node->filter('.property_unit-title')->filter('a')->attr('href');
                                if ($item['物件名'] == "") {
                                    $item['物件名'] = $node->filter('.property_unit-title')->filter('a')->text();
                                }
                                $itemCrawl[] = $item;
                            }
                        );
                        sleep(15);
                    }
                    break;

                case 'スーモ　新築マンション':
                    while ($flag) {
                        $page = $urlItem['url'] . '&pn=' . $currentPage;
                        $clientPage = new Client();
                        $crawlerPage = $clientPage->request('GET', $page);
                        $group = $crawlerPage->filter('div.property_unit');
                        if (count($group) == 0) {
                            $flag = false;
                            break;
                        }
                        Log::info($currentPage);
                        $currentPage++;
                        if (empty($total)) {
                            $total = $crawlerPage->filter('div.hitbox-number')->text();
                        }

                        $group->filter('div.cassette-content')->each(
                            function (Crawler $node) use (&$itemCrawl) {
                                $item = [
                                    "物件名" => "",
                                    "販売価格" => "",
                                    "所在地" => "",
                                    "沿線・駅" => "",
                                    "土地面積" => "",
                                    "建物面積" => "",
                                    "間取り" => "",
                                    "築年月" => "",
                                    "url-detail" => "",
                                ];
                                $info = $node->filter('.cassette-result_detail');
                                $info->filter('.cassette_basic-list_item')->each(function(Crawler $nodeDl) use (&$item) {
                                    $name = trim($nodeDl->filter('p.cassette_basic-title')->text());
                                    if ($name == "交通") {
                                        $name = "沿線・駅";
                                    }
                                    if (isset($item[$name])) {
                                        $item[$name] = $nodeDl->filter('p.cassette_basic-value')->text();
                                    }
                                });
                                $item['販売価格'] = $node->filter('.cassette_price-accent')->text();
                                $item['土地面積'] = $node->filter('.cassette_price-description')->text();
                                $item['url-detail'] = 'https://suumo.jp' . $node->filter('.cassette_header-title')->filter('a')->attr('href');
                                if ($item['物件名'] == "") {
                                    $item['物件名'] = $node->filter('.cassette_header-title')->filter('a')->text();
                                }
                                $itemCrawl[] = $item;
                            }
                        );
                        // sleep(2);
                    }
                break;
                case 'アットホーム　中古一戸建て':
                case 'アットホーム　新築一戸建て':
                case 'アットホーム　中古マンション':
                // case 'アットホーム　新築マンション':
                    while ($flag) {
                        $page = $urlItem['url'] . 'page' . $currentPage;
                        $crawlerPage = new Crawler;
                        $crawlerPage->addHTMLContent($this->getHtml($page), 'UTF-8');

                        $group = $crawlerPage->filter('div.object');

                        if (count($group) == 0) {
                            $flag = false;
                            break;
                        }
                        Log::info($currentPage);
                        $currentPage++;

                        if (empty($total)) {
                            $divTotal = $crawlerPage->filter('p.item-list_result');
                            $total = $divTotal->filter('span.counter')->text();
                        }
                        $group->filter('table.defTbl')->filter('tr')->each(
                            function (Crawler $node) use (&$itemCrawl, $urlItem, $group) {
                                $classTmp = "span.object-title_name";
                                if ($urlItem['name'] == "アットホーム　中古マンション") {
                                    $classTmp = "p.object-title";
                                    $item = [
                                        "物件名" => $group->filter($classTmp)->filter('a')->text(),
                                        "価格" => "",
                                        "所在地" => "",
                                        "交通" => "",
                                        "階建" => "",
                                        "間取り" => "",
                                        "専有面積" => "",
                                        "築年月" => "",
                                        "構造" => "",
                                        "url-detail" => 'https://www.athome.co.jp' . $group->filter($classTmp)->filter('a')->attr('href'),
                                    ];
                                } else {
                                    $item = [
                                        "物件名" => $group->filter($classTmp)->filter('a')->text(),
                                        "価格" => "",
                                        "所在地" => "",
                                        "交通" => "",
                                        "間取り" => "",
                                        "建物面積" => "",
                                        "土地面積" => "",
                                        "築年月" => "",
                                        "url-detail" => 'https://www.athome.co.jp' . $group->filter($classTmp)->filter('a')->attr('href'),
                                    ];
                                }

                                if ($urlItem['name'] == "アットホーム　中古マンション") {
                                    if (count($node->filter('th')) == 2) {
                                        if (isset($item[trim($node->filter('th')->first()->text())])) {
                                            $item[trim($node->filter('th')->first()->text())] = $node->filter('td')->first()->text();
                                        }
                                        if (isset($item[trim($node->filter('th')->last()->text())])) {
                                            $item[trim($node->filter('th')->last()->text())] = $node->filter('td')->last()->text();
                                        }
                                    } else {
                                        if (isset($item[trim($node->filter('th')->text())])) {
                                            $item[trim($node->filter('th')->text())] = $node->filter('td')->text();
                                        }
                                    }
                                } else {
                                    if (isset($item[trim($node->filter('th')->text())])) {
                                        $item[trim($node->filter('th')->text())] = $node->filter('td')->text();
                                    }
                                }
                                $itemCrawl[] = $item;
                            }
                        );
                    }
                break;
                case 'アットホーム　新築マンション':
                    Log::info($currentPage);
                    $crawlerPage = new Crawler;
                    $crawlerPage->addHTMLContent($this->getHtml($urlItem['url']), 'UTF-8');

                    $crawlerPage->filter('div.sys-articleItem')->each(
                        function (Crawler $node) use (&$itemCrawl) {
                            $item = [
                                "物件名" => "",
                                "販売価格" => "",
                                "所在地" => "",
                                "沿線・駅" => "",
                                "土地面積" => "",
                                "建物面積" => "",
                                "間取り" => "",
                                "築年月" => "",
                                "url-detail" => "",
                            ];
                            $item['物件名'] = $node->filter('h2.title')->filter('a')->text();
                            $item['販売価格'] = $node->filter('li.placeText')->text();
                            $item['所在地'] = $node->filter('p.address')->text();
                            $item['沿線・駅'] = $node->filter('p.bigFreeWord')->text();
                            $item['土地面積'] = $node->filter('ul.smallFreeWord')->text();
                            $item['建物面積'] = $node->filter('li.sitearea')->text();
                            $item['間取り'] = $node->filter('li.layout')->text();
                            $item['築年月'] = $node->filter('p.title')->text();
                            $item['url-detail'] = 'https://www.athome.co.jp/' . $node->filter('h2.title')->filter('a')->attr('href');
                            $itemCrawl[] = $item;
                        }
                    );
                    $total = count($itemCrawl) . $crawlerPage->filter('div.seachTtlCaption')->text();

                break;
            }
            $dataCrawl[] = [
                'name' => $urlItem['name'],
                'data' => $itemCrawl,
                'total' => $total
            ];
        }
        // dd($dataCrawl);
        foreach ($dataCrawl as $item) {
            $filename = "C:\Php\\". $item['name'] . ".csv";
            $handle = fopen($filename, 'w');
            fputcsv($handle, $this->convert(array('全物件数：'.$item['total'])));
            $header = array('物件名', '販売価格', '所在地', '沿線・駅', '土地面積', '建物面積', '間取り', '築年月', 'url');
            switch ($item['name']) {
                case 'アットホーム　中古一戸建て':
                case 'アットホーム　新築一戸建て':
                    $header = ["物件名","価格", "所在地", "交通", "階建", "間取り", "専有面積", "築年月", "構造", "url"];
                    break;
                case 'アットホーム　中古マンション':
                    $header = ["物件名", "価格", "所在地", "交通", "間取り", "建物面積", "土地面積", "築年月", "url"];
                    break;
            }
            fputcsv($handle, $this->convert($header));

            foreach ($item['data'] as $dataItem) {
                fputcsv($handle, $this->convert($dataItem));
            }
            fclose($handle);
        }
    }
    function convert($fields) {
        $result = [];
        foreach ($fields as $field) {
            // dd(($field));
            // $encode = mb_detect_encoding($field, "auto");
            // $field = mb_convert_encoding($field, "UTF-8", $encode);
            $result[] = mb_convert_encoding($field, "SJIS", "UTF-8");
        }
        return $result;
    }
    function getHtml($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if(!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
