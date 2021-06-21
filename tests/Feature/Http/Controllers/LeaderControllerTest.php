<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class LeaderControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $leader;

    public function setUp() :void
    {
        parent::setUp();
        $this->leader= $this->app->make('App\Http\Controllers\LeaderController');
    }

    public function testCreateLeaderSuccessAction()
    {
        $requestParams = [
            'name'      => 'Nancy',
            'age'       => 31,
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Leader ' . $requestParams['name'] . ' has been created.'
            ]);
    }

    public function testCreateLeaderFailAction()
    {
        $paramMissing = 'age';
        $requestParams = [
            'name'      => 'Nancy',
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Creation failed: The ' . $paramMissing . ' field is required.'
            ]);
    }

    public function testIncreaseDecreasePointSuccessAction()
    {
        $requestParams = [
            'name'      => 'Nancy',
            'age'       => 31,
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Leader ' . $requestParams['name'] . ' has been created.'
            ]);

        $id = DB::getPdo()->lastInsertId();
        $result = $this->leader->show($id);
        $result = json_decode(response()->json($result)->getContent(), true);
        $points = $result['points'] + 1;
        $this->post('/api/user/leaderboard/increase/'.$id)
            ->assertJson([
                'message' => "The points of Leader " . $requestParams['name'] . " has been increased by 1, equals to "
                    . $points
            ]);
        $points--;
        $this->post('/api/user/leaderboard/decrease/'.$id)
            ->assertJson([
                'message' => "The points of Leader " . $requestParams['name'] . " has been decreased by 1, equals to "
                    . $points
            ]);
    }

    public function testDeleteLeaderSuccessAction()
    {
        $requestParams = [
            'name'      => 'Nancy',
            'age'       => 31,
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Leader ' . $requestParams['name'] . ' has been created.'
            ]);

        $id = DB::getPdo()->lastInsertId();
        $this->delete('/api/user/leaderboard/'.$id)
            ->assertJson([
                'message' => $requestParams['name'] . ' has been deleted from leaderboard.'
            ]);
    }

    public function testUpdateLeaderSuccessAction()
    {
        $requestParams = [
            'name'      => 'Howard',
            'age'       => 31,
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Leader ' . $requestParams['name'] . ' has been created.'
            ]);

        $id = DB::getPdo()->lastInsertId();
        $updateParams = [
            'name'      => 'Howard',
            'age'       => 32,
            'points'     => 5,
            'address'   => '1785 156 ST Surrey BC V3A 6S9'
        ];
        $this->put('/api/user/leaderboard/'.$id, $updateParams)
            ->assertJson([
                'message' => 'Leader No.' . $id . ' has been updated.'
            ]);
        $result = $this->leader->show($id);
        $result = json_decode(response()->json($result)->getContent(), true);
        $actual = $result['points'];
        $this->assertTrue($actual == $updateParams['points']);
    }
}
