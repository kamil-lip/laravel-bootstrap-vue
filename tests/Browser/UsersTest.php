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
     * Test user list and filtering
     *
     * @return void
     */
    public function testUserListAndFiltering()
    {

        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create([
                'email' => 'johd@jedddtsomedomain.com',
            ]);

            $browser->loginAs($user)
                ->visit('/users')
                ->waitFor('#resource-list-page')
                ->click('[href="/users"]')
                ->assertPathIs('/users')
                // test filtering
                ->waitFor('#resource-list-page .filter')
                ->type('#resource-list-page .filter', $user->email)
                ->pause(1000)
                // we should see user's email in the first row of the table:
                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(3)', $user->email);;
        });
    }

    /**
     * Test user list and filtering
     *
     * @return void
     */
    public function testAddingNewValidUser()
    {

        $this->browse(function (Browser $browser) {

            $user = factory(User::class)->create([
                'email' => 'johd@jedddtsomedomain.com',
            ]);

            $userData = [
                'name' => 'Andrzej Andewageński',
                'email' => 'andrzej@justsomenonexistingdomain.com',
                'password' => 'qwertyu10!'
            ];

            $browser->loginAs($user)
                ->visit('/users')
                ->waitFor('.main-nav')
                ->waitForText('New user')
                ->clickLink('New user')
                ->assertPathIs('/users/create')
                ->waitForText('New user')
                ->type('name', $userData['name'])
                ->type('email', $userData['email'])
                ->type('password', $userData['password'])
                ->press('Submit')
                // user should be listed in the table
                ->waitForLocation('/users')
                ->waitFor('#resource-list-page .filter')
                ->type('#resource-list-page .filter', $userData['email'])
                ->pause(500)
                ->waitFor('.user-list-table')
                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(2)', $userData['name'])
                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(3)', $userData['email']);
        });
    }

    /**
     * Test user form validation
     *
     * @return void
     */
    public function testUserFormValidation()
    {

        $this->browse(function (Browser $browser) {

            $user = factory(User::class)->create([
                'email' => 'johd@jedddtsomedomain.com',
            ]);

            $userData = [
                'name' => 'Andrzej Arcy',
                'email' => 'andrzej@judsexistingdomain.com',
                'password' => 'qwertyu101!'
            ];

            $browser->loginAs($user)
                // all fields shoudl be required
                ->visit('/users')
                ->waitFor('.main-nav')
                ->waitForText('New user')
                ->clickLink('New user')
                ->assertPathIs('/users/create')
                ->waitForText('New user')
                ->type('name', '')
                ->type('email', '')
                ->type('password', '')
                ->press('Submit')
                ->assertSee('The name field is required.')
                ->assertSee('The email field is required.')
                ->assertSee('The password field is required.')
                // email must a valid email address
                ->type('email', 'thisisnotavalieemail@sddds@dds')
                ->assertSee('The email field must be a valid email.')
                // email must be unique (server side validation)
                ->type('name', $userData['name'])
                ->type('email', 'johd@jedddtsomedomain.com')// email of the user we are logged in
                ->type('password', $userData['password'])
                ->press('Submit')
                ->waitForText('The email has already been taken.');
        });
    }

    /**
     * Test user edit page
     *
     * @return void
     */
    public function testUserCanBeEdited()
    {

        $this->browse(function (Browser $browser) {

            $users = factory(User::class, 2)->create();

            $differentUser = $users[1];

            $browser->loginAs($users[0])
                // all fields should be required
                ->visit('/users')
                ->waitFor('.main-nav')
                ->waitFor('#resource-list-page .filter')
                ->type('#resource-list-page .filter', $differentUser->email)
                ->pause(500)
                ->waitFor('.user-list-table')
                ->waitForText($differentUser->name)
                ->click('.user-list-table tbody tr:first-child td .btn-primary')
                ->waitForText('Edit user')
                // type new username and password
                ->type('name', 'Amended username')
                ->type('email', 'amendedemail@jedddtsomedomain.com')
                ->press('Update')
                // go back to user list
                ->clickLink('Users')
                ->waitFor('#resource-list-page .filter')
                // user should be the only one on the list
                ->type('#resource-list-page .filter', 'amendedemail@jedddtsomedomain.com')
                ->pause(500)
                ->waitFor('.user-list-table')// wait for data to be loaded

                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(2)', 'Amended username')
                ->assertSeeIn('.user-list-table tbody tr:first-child td:nth-child(3)',
                    'amendedemail@jedddtsomedomain.com');
        });
    }

}
