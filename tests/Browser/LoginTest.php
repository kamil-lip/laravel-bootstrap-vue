<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test singing in
     *
     * @return void
     * @throws \Throwable
     */
    public function testSignIn()
    {

        $user = factory(User::class)->create([
            'email' => 'john@justsomedomain.com',
        ]);

        $this->browse(function (Browser $browser, Browser $secondBrowser) use ($user) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->assertSeeIn('.card-header', 'Login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/')
                ->assertSee('You are logged in!');

            // try to sign in with wrong email address. It's should not let the user in.
            $secondBrowser->visit('/')
                ->assertPathIs('/login')
                ->assertSeeIn('.card-header', 'Login')
                ->type('email', 'thisisemailis@notinthedatabase.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /**
     * Test singing out
     *
     * @return void
     * @throws \Throwable
     */
    public function testSignOut()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'email' => 'john@justsomedomain.com',
            ]);

            $browser->loginAs($user)
                ->visit('/')
                ->waitForText('You are logged in!')
                ->click('#navbarUserDropdown')
                ->click('#navbarSupportedContent > ul.navbar-nav.ml-auto > li > div > a')
                ->waitForLocation('/login')
                ->assertSeeIn('.card-header', 'Login'); // login page

        });
    }

}
