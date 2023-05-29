<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\User;
use \App\Auth;

/**
 * Settings controller
 *
 * PHP version 8.2
 */
class Settings extends Authenticated
{
    /**
     * user model
     * 
     * @var object
     */
    public $user;

    /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    /**
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Settings/index.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Balance 
     * 
     * @return void
     */
    public function accountAction()
    {

        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Zapisano zmiany');

            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Formularz zawiera błędy', 'warning');

            View::renderTemplate('Settings/index.html', [
                'user' => $this->user
            ]);

        }
    }
}