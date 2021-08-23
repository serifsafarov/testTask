<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePrizeToBonusRequest;
use App\Http\Requests\RejectGiftRequest;
use App\Http\Resources\PrizeResource;
use App\Models\Gift;
use App\Models\Prize;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrizeController extends Controller
{
    /**
     * @param Request $request
     * @return PrizeResource
     */
    public function winPrize(Request $request): PrizeResource
    {
        //Выбираем тип приза
        $type = collect([
            'money', 'bonus', 'gift'
        ])->filter(function ($item) use ($request) {
            switch ($item) {
                case 'money':
                    //Если пользователь перешёл лимит выигрыша
                    return $request->user()->prizes()->where('type', 'money')->select(
                            DB::raw('sum(amount) as total_amount')
                        )->first()->total_amount < config('prize.prize_limit.money', 120);
                case 'bonus':
                    return true;
                case 'gift':
                    return
                        Gift::query()->where('count', '>', 0)->exists() &&
                        $request->user()->prizes()->where('type', 'gift')->count() < config('prize.prize_limit.gift', 4);
            }
        })->random(1)->first();

        $prize = null;

        //Выбираем приз
        switch ($type) {
            case 'money':
                $range = config('prize.money_prize_range', [1, 12]);
                $prize = Prize::query()->create([
                    'user_id' => $request->user()->id,
                    'type' => 'money',
                    'amount' => mt_rand_float($range[0], $range[1], 2)
                ]);
                break;
            case 'bonus':
                $range = config('prize.bonus_prize_range', [1, 12]);
                $prize = Prize::query()->create([
                    'user_id' => $request->user()->id,
                    'type' => 'bonus',
                    'amount' => mt_rand_float($range[0], $range[1], 2)
                ]);
                break;
            case 'gift':
                $gift = Gift::query()->where('count', '>', 0)->inRandomOrder()->first();
                $prize = Prize::query()->create([
                    'user_id' => $request->user()->id,
                    'type' => 'gift',
                    'gift_id' => $gift->id
                ]);
                break;
        }
        $prize->refresh();

        return new PrizeResource($prize);
    }

    /**
     * @param ChangePrizeToBonusRequest $request
     * @return PrizeResource
     */
    public function changeToBonus(ChangePrizeToBonusRequest $request): PrizeResource
    {
        $prize = Prize::query()->find($request->id);
        $prize->type = 'bonus';
        $prize->amount = $prize->amount * config('prize.money_to_bonus_rate', 2);
        $prize->save();
        return new PrizeResource($prize);
    }

    public function rejectGift(RejectGiftRequest $request)
    {
        Prize::query()->find($request->id)->delete();
        return new JsonResponse(true);
    }
}
