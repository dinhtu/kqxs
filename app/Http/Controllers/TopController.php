<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XsDay;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TopController extends Controller
{

    public function index(Request $request)
    {
        $date = Carbon::parse($request->date ?? Carbon::now());
        $dataAll = [];
        $xsDays = XsDay::with(['xsDetails'])->whereDate('day', '>=', $date->addDays(-7))->get();
        $data = $this->count($xsDays);
        $this->pushData('week', $dataAll, $data);
        $xsDays = XsDay::with(['xsDetails'])->whereDate('day', '>=', $date->addDays(-10))->get();
        $data = $this->count($xsDays);
        $this->pushData('day_10', $dataAll, $data);
        $xsDays = XsDay::with(['xsDetails'])->whereDate('day', '>=', $date->addMonths(-1))->get();
        $data = $this->count($xsDays);
        $this->pushData('month', $dataAll, $data);
        $xsDays = XsDay::with(['xsDetails'])->whereDate('day', '>=', $date->addYears(-1))->get();
        $data = $this->count($xsDays);
        $this->pushData('year', $dataAll, $data);
        $xsDays = XsDay::with(['xsDetails'])->where('day', 'like', '%'.$date->format('m-d'))->get();
        $data = $this->count($xsDays);
        $this->pushData('day_old', $dataAll, $data);
        // dd($dataAll);

        $dataCollection = collect($dataAll);
        if ($request->sort) {
            $dataCollection = $dataCollection->sortByDesc($request->sort);
        }
        $perPage = $request->get('perPage', 100);
        $from = $request->get('from', 1);
        $currentPageItems = $dataCollection->slice($from, $perPage)->all();
        $totalDataCollection = count($dataCollection);
        $dataAll = new LengthAwarePaginator($currentPageItems, $totalDataCollection, $perPage);

        return view('Home.index', [
            'dataAll' => $dataAll
        ]);
    }
    public function count($data) {
        $res = [];
        $i = 0;
        foreach ($data as $day) {
            foreach ($day->xsDetails as $detail) {
                $i++;
                if (isset($res[$detail->item])) {
                    $res[$detail->item]++;
                } else {
                    $res[$detail->item] = 1;
                }
            }
        }
        $res['total'] = $i;
        return $res;
    }
    public function pushData($key, &$dataAll, $data)
    {
        $i = 0;
        while ($i <= 100) {
            $dataAll[$i]['item'] = $i < 10 ? '0'.$i : $i;
            $dataAll[$i]['count_'. $key] = isset($data[$i]) ? $data[$i] : 0;
            $dataAll[$i][$key] = isset($data[$i]) ? round(($data[$i]/$data['total'])*100, 6) : 0;
            $i++;
        }
    }
}
