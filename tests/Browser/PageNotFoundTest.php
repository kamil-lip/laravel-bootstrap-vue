<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\NonExistingPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class PageNotFoundTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();

            $browser->loginAs($user)->visit(new NonExistingPage())->waitFor('#page-404');
        });
    }
}
