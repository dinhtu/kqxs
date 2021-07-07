@extends('layouts.default')

@section('content')
    <div class="main_wrapper">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">@sortablelink('item', '#')</th>
                    <th class="text-center">@sortablelink('week', 'week')</th>
                    <th class="text-center">@sortablelink('day_10', 'day_10')</th>
                    <th class="text-center">@sortablelink('month', 'month')</th>
                    <th class="text-center">@sortablelink('year', 'year')</th>
                    <th class="text-center">@sortablelink('day_old', 'day old')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataAll as $item)
                <tr>
                    <td class="text-center">{{$item['item']}}</td>
                    <td class="text-center">{{$item['week']}} <br>({{$item['count_week']}})</td>
                    <td class="text-center">{{$item['day_10']}}  <br>({{$item['count_day_10']}})</td>
                    <td class="text-center">{{$item['month']}}  <br>({{$item['count_month']}})</td>
                    <td class="text-center">{{$item['year']}}  <br>({{$item['count_year']}})</td>
                    <td class="text-center">{{$item['day_old']}}  <br>({{$item['count_day_old']}})</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
