<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\IncomesCategoryAssignedToUsers;

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
     * Settings index
     *
     * @return void
     */
    public function indexAction()
    {
        $incomes_categories = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        View::renderTemplate('Settings/index.html', [
            'user' => $this->user,
            'incomes_categories' => $incomes_categories
        ]);
    }

    /**
     * Settings update account informations
     * 
     * @return void
     */
    public function updateAccountAction()
    {

        if ($this->user->updateProfile($_POST)) {

            Flash::addMessage('Zapisano zmiany');

            $this->redirect('/settings/index');

        } else {

            Flash::addMessage('Formularz zawiera błędy', 'warning');

            $incomes_categories = IncomesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Settings/index.html', [
                'user' => $this->user,
                'incomes_categories' => $incomes_categories
            ]);

        }
    }

    /**
     * Settings remove account
     * 
     * @return void
     */
    public function removeAccountAction()
    {
        $this->user->removeProfile();

        $this->redirect('/logout');
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function addIncomeCategoryAction()
    {
        IncomesCategoryAssignedToUsers::addCategory($_SESSION['user_id'], $_POST['name']);

        $data['incomes_categories'] = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function updateIncomeCategoryAction()
    {
        IncomesCategoryAssignedToUsers::updateCategory($_POST['id'], $_POST['name']);

        $data['incomes_categories'] = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings remove category AJAX request
     * 
     * @return void
     */
    public function deleteIncomeCategoryAction()
    {
        IncomesCategoryAssignedToUsers::removeCategory($_POST['id']);

        $data['incomes_categories'] = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }
}