<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Balance controller (example)
 *
 * PHP version 7.0
 */
class Balance extends Authenticated
{

    /**
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Balance/index.html');
    }
}
