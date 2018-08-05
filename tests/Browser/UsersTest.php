<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test users CRUD
     *
     * @return void
     */
    public function testCRUD()
    {

        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'email' => 'john@justsomedomain.com',
            ]);

            $browser->loginAs($user)
                ->visit('/users')
                ->waitFor('.main-nav')
                ->click('[href="/users"]')
                ->assertPathIs('/users')
                // test filtering
                ->type('.resource-list .filter', $user->email)
                ->pause(1000)
                // we should see user's email in the first row of the table:
                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(3)', $user->email);
                ;
        });
    }
}
