<?php

namespace Tests\Unit;

use App\Http\Controllers\PrizeController;
use App\Http\Requests\ChangePrizeToBonusRequest;
use App\Models\Prize;
use App\Models\User;
use \Illuminate\Http\Request;
use Tests\TestCase;

class ChangeToBonusTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory()->create();
        $prize = $this->createPrize($user->id);
        $res = $this->actingAs($user)->post('/api/prize/change_to_bonus', [
            'id' => $prize->id
        ]);

        $this->assertTrue($res->getStatusCode() === 200, 'Вернулся ответ с кодом, отличный от 200');
        $this->assertTrue(json_decode($res->getContent(), false)->data->amount === ($prize->amount * config('prize.money_to_bonus_rate', 2)), 'Конвертация прошла неправильно');

        $user->delete();
        $prize->delete();
    }

    private function createPrize($userId)
    {
        $range = config('prize.money_prize_range', [1, 12]);
        return Prize::query()->create([
            'user_id' => $userId,
            'type' => 'money',
            'amount' => mt_rand_float($range[0], $range[1], 2)
        ]);
    }
}
