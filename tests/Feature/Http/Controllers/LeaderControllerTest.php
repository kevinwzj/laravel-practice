<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LeaderControllerTest extends TestCase
{
    protected $leader;

    public function setUp() :void{
        parent::setUp();
        $this->leader = $this->app->make('App\Http\Controllers\LeaderController');
    }

    public function testCreateUserFailAction()
    {
        $paramMissing = 'age';
        $requestParams = [
            'name'      => 'Kevin',
            'address'   => '1787 156 ST Surrey BC V3A 6S9'
        ];
        $request = new Request($requestParams);
        $result = $this->leader->create($request);
        $result = response()->json($result)->getContent();
        $result = json_decode($result, true);
        $result = $result['original'];
        $actual = $result['message'];
        $this->assertTrue($actual == 'Creation failed, ' . $paramMissing . ' is a required field.');
    }
}
