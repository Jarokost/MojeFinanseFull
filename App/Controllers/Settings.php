<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;
use \App\Models\IncomesCategoryAssignedToUsers;
use \App\Models\ExpensesCategoryAssignedToUsers;
use \App\Models\PaymentMethodsAssignedToUsers;

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
        $expenses_categories = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);
        $payment_methods = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        View::renderTemplate('Settings/index.html', [
            'user' => $this->user,
            'incomes_categories' => $incomes_categories,
            'expenses_categories' => $expenses_categories,
            'payment_methods' => $payment_methods
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
            $expenses_categories = ExpensesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);
            $payment_methods = PaymentMethodsAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Settings/index.html', [
                'user' => $this->user,
                'incomes_categories' => $incomes_categories,
                'expenses_categories' => $expenses_categories,
                'payment_methods' => $payment_methods
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( IncomesCategoryAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {
        
            IncomesCategoryAssignedToUsers::addCategory($_SESSION['user_id'], $post_fetch_promise['name']);

            $data['flash_message_body'][0] = 'dodano nową kategorię: ' . $post_fetch_promise['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = IncomesCategoryAssignedToUsers::getCategoriesAssignedToUser($_SESSION['user_id']);

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
        if( IncomesCategoryAssignedToUsers::categoryExists($_POST['name']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $_POST['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = IncomesCategoryAssignedToUsers::getCategoryName($_POST['id']);
            IncomesCategoryAssignedToUsers::updateCategory($_POST['id'], $_POST['name']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $_POST['name'];
            $data['flash_message_type'][0] = 'info';
            
        }

        $data['categories'] = IncomesCategoryAssignedToUsers::getCategoriesAssignedToUser($_SESSION['user_id']);

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
        $transactions = IncomesCategoryAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $_POST['id']);
        $category_name = IncomesCategoryAssignedToUsers::getCategoryName($_POST['id']);
        $force = $_POST['force'];

        if($transactions && $force === 'n') {

            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istnieją (' . $transactions['transactions'] . ') transakcje, niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            IncomesCategoryAssignedToUsers::removeCategory($_POST['id']);

            $data['flash_message_body'][0] = 'usunięto kategorię: ' . $category_name['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function addExpenseCategoryAction()
    {
        if( ExpensesCategoryAssignedToUsers::categoryExists($_POST['name']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $_POST['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            ExpensesCategoryAssignedToUsers::addCategory($_SESSION['user_id'], $_POST['name']);

            $data['flash_message_body'][0] = 'dodano nową kategorię: ' . $_POST['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function updateExpenseCategoryAction()
    {
        if( ExpensesCategoryAssignedToUsers::categoryExists($_POST['name']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $_POST['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = ExpensesCategoryAssignedToUsers::getCategoryName($_POST['id']);
            ExpensesCategoryAssignedToUsers::updateCategory($_POST['id'], $_POST['name']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $_POST['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings remove category AJAX request
     * 
     * @return void
     */
    public function deleteExpenseCategoryAction()
    {
        $transactions = ExpensesCategoryAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $_POST['id']);
        $category_name = ExpensesCategoryAssignedToUsers::getCategoryName($_POST['id']);
        $force = $_POST['force'];

        if($transactions && $force === 'n') {

            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istnieją (' . $transactions['transactions'] . ') transakcje, niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            ExpensesCategoryAssignedToUsers::removeCategory($_POST['id']);

            $data['flash_message_body'][0] = 'usunięto kategorię: ' . $category_name['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function addPaymentMethodAction()
    {
        if( PaymentMethodsAssignedToUsers::categoryExists($_POST['name']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $_POST['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            PaymentMethodsAssignedToUsers::addCategory($_SESSION['user_id'], $_POST['name']);

            $data['flash_message_body'][0] = 'dodano nową kategorię: ' . $_POST['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update category name AJAX request
     * 
     * @return void
     */
    public function updatePaymentMethodAction()
    {
        if( PaymentMethodsAssignedToUsers::categoryExists($_POST['name']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $_POST['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = PaymentMethodsAssignedToUsers::getCategoryName($_POST['id']);
            PaymentMethodsAssignedToUsers::updateCategory($_POST['id'], $_POST['name']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $_POST['name'];
            $data['flash_message_type'][0] = 'info';
            
        }

        $data['categories'] = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }

    /**
     * Settings remove category AJAX request
     * 
     * @return void
     */
    public function deletePaymentMethodAction()
    {
        $transactions = PaymentMethodsAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $_POST['id']);
        $category_name = PaymentMethodsAssignedToUsers::getCategoryName($_POST['id']);
        $force = $_POST['force'];

        if($transactions && $force === 'n') {

            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istnieją (' . $transactions['transactions'] . ') transakcje, niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            PaymentMethodsAssignedToUsers::removeCategory($_POST['id']);

            $data['flash_message_body'][0] = 'usunięto kategorię: ' . $category_name['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }
}