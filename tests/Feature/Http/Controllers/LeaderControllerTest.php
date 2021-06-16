<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeaderControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUserSuccessAction()
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

    public function testCreateUserFailAction()
    {
        $paramMissing = 'age';
        $requestParams = [
            'name'      => 'Nancy',
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $this->post('/api/user/leaderboard', $requestParams)
            ->assertJson([
                'message' => 'Creation failed, ' . $paramMissing . ' is a required field.'
            ]);
    }
}
