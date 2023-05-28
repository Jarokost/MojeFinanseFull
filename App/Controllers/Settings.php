<?php

namespace App\Controllers;

use \Core\View;

/**
 * Settings controller
 *
 * PHP version 8.2
 */
class Settings extends Authenticated
{
    /**
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Settings/index.html');
    }
}