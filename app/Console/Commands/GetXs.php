<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Log;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;
use App\Models\XsDay;
use App\Models\XsDetail;
use DB;

class GetXs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetXs';

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
        //01-01-2004
        $maxDate = XsDay::max('day');
        $startDate = empty($maxDate) ? Carbon::parse("01-01-2004") : Carbon::parse($maxDate)->addDays(1);
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $url = 'https://ketqua.net/xo-so.php?ngay=';
        while ($startDate < $now) {
            DB::beginTransaction();
            Log::info($startDate->format('Y-m-d'));
            if (XsDay::whereDate('day', $startDate->format('Y-m-d'))->exists()) {
                $startDate = $startDate->addDays(1);
                continue;
            }
            $xsDay = new XsDay();
            $xsDay->day = $startDate;
            if (!$xsDay->save()) {
                return false;
            }

            $crawlerPage = new Crawler;
            $crawlerPage->addHTMLContent($this->getHtml($url . $startDate->format('d-m-Y')), 'UTF-8');
            $div = $crawlerPage->filter('table#result_tab_mb')->filter('tbody')->filter('div.row-no-gutters');
            $stt = 0;
            $div->each(function (Crawler $node) use (&$stt, $xsDay) {
                $node->filter('div.phoi-size')->each(function (Crawler $nodeDev) use ($stt, $xsDay) {
                    if (is_numeric(trim($nodeDev->text()))) {
                        $xsDetail = new XsDetail();
                        $xsDetail->xs_day_id = $xsDay->id;
                        $xsDetail->origin = trim($nodeDev->text());
                        $xsDetail->item = substr(trim($nodeDev->text()), -2, 2);
                        $xsDetail->number_order = $stt;
                        if (!$xsDetail->save()) {
                            return false;
                        }
                    }
                });
                $stt++;

            });
            $startDate = $startDate->addDays(1);
            DB::commit();
        }
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
