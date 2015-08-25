<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicationControllerTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        // Route::enableFilters();


         Artisan::call('db:seed');

        Auth::loginUsingId(1);
        // OR:
        //$this->be(User::find(1));
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testInit()
    {
        $this->assertEquals('0', '0');
    }
}
