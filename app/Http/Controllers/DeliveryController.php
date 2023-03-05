<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function setDaliveryDate() {
        $deliveryDates = [];
        //最短の配送日を何日ずらすか
        $daysToShiftCount = null;
        //都道府県がどこか
        $Prefectures = null;
        //最短配送日
        $shortestDeliveryDate = 1;
        //表示する件数
        $indicateCount = 5;
        //15時以降の場合配送日をずらすか否か
        $isDeliveryDelayAfterFifteenHour = true;
        //土曜日、日曜日を配送不可日とするか否か
        $isDeliveryDelaySaturdayAndSunday = true;
        //配送先の都道府県によって、最短配送日を設定日数分、後にずらす設定
        $deliveryDelayPrefectures = ['北海道' => 2, '沖縄県' => 3];
        $Prefectures = $deliveryDelayPrefectures['北海道'];

        $daysToShiftCount = $shortestDeliveryDate;

        if($isDeliveryDelayAfterFifteenHour && Carbon::now()->hour === 15) {
            $daysToShiftCount += 1;
        }

        if(!is_null($Prefectures)) {
            $daysToShiftCount += $Prefectures;
        }

        $startDate = Carbon::now()->addDays($daysToShiftCount);

        // 配送日の配列を作成
        for ($i = 0; count($deliveryDates) < $indicateCount; $i++) {
            $deliveryDate = $startDate->copy()->addDays($i);
            $week = $deliveryDate->dayOfWeek;
            if($isDeliveryDelaySaturdayAndSunday && ($week === Carbon::SUNDAY || $week === Carbon::SATURDAY)) {
                continue;
            }
            $deliveryDates[] = $deliveryDate->format('Y-m-d');
        }

        return view('deliveryDateSelect', ['deliveryDates' => $deliveryDates]);
    }
}
