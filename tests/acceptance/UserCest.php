<?php


class UserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToLoginAsAdmin(AcceptanceTester $I)
    {
        $I->amOnUrl('http://doa.local/user/login');
        $I->fillField('input#username', 'admincv');
        $I->fillField('input#password', 'k3nt4k1');

        $I->click('.login-form button');
        $I->amOnUrl('http://doa.local/dms');
        $I->see('featured');
        $I->see('dashboard');
        //$I->seeInSource('Sign In');

    }

    // tests
    public function tryToHomepage(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Search By Body Style');
    }
}
