<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
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
     * Settings success page email change
     *
     * @return void
     */
    public function successEmailChangeAction()
    {
        View::renderTemplate('Settings/change_email_success.html');
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
     * Settings update account informations
     * 
     * @return void
     */
    public function updateAccountNameAction()
    {

        if ($this->user->updateProfileName($_POST)) {

            Flash::addMessage('Imię zostało zmienione');

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
     * Settings update account informations
     * 
     * @return void
     */
    public function updateAccountPasswordAction()
    {

        if ($this->user->updateProfilePassword($_POST)) {

            Flash::addMessage('Hasło zostało zmienione');

            $this->redirect('/settings/index');

        } else {

            foreach ($this->user->errors as  $error) {
                Flash::addMessage($error, 'warning');
            }
            
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

    public function checkIfOldPasswordCorrectAction()
    {
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $user = $this->user->findByID($this->user->id);

        if ($user) {
            if (password_verify($post_fetch_promise['password'], $user->password_hash)) {
                $data = true;
            } else {
                $data = false;
            }
        } else {
            $data = false;
        }

        echo json_encode($data);
        exit;
    }

    /**
     * Settings update account informations
     * 
     * @return void
     */
    public function updateAccountEmailAction()
    {

        if ($this->user->updateProfileEmail($_POST)) {

            Flash::addMessage("Sprawdź swoją skrzynkę pocztową na nowym adresie email");

            $this->redirect('/settings/successEmailChange');

        } else {

            Flash::addMessage('Nie udało się zmienić adresu email i wysłać wiadomości', 'warning');

            foreach ($this->user->errors as  $error) {
                Flash::addMessage($error, 'warning');
            }

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
     * Reset the user's password
     *
     * @return void
     */
    public function emailChangeAction()
    {
        $token = $this->route_params['token'];

        $user = $this->getUserOrExit($token);

        if ($user->changeEmail()) {

            Flash::addMessage('Zmiana adresu email pomyślna');

            Auth::logout();

            View::renderTemplate('Settings/change_email_activation_success.html');

        } else {

            Flash::addMessage('Niepowodzenie, spróbuj zmienić adres email ponownie', 'warning');

            View::renderTemplate('Settings/index.html');

        }

    }

    /**
     * Find the user model associated with the password reset token, or end the request with a message
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    protected function getUserOrExit($token)
    {
        $user = User::findByEmailChange($token);

        if ($user) {

            return $user;

        } else {

            View::renderTemplate('Settings/token_expired.html');
            exit;

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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( IncomesCategoryAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = IncomesCategoryAssignedToUsers::getCategoryName($post_fetch_promise['id']);
            IncomesCategoryAssignedToUsers::updateCategory($post_fetch_promise['id'], $post_fetch_promise['name']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $post_fetch_promise['name'];
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $transactions = IncomesCategoryAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $post_fetch_promise['id']);
        $category_name = IncomesCategoryAssignedToUsers::getCategoryName($post_fetch_promise['id']);
        $force = $post_fetch_promise['force'];

        if($transactions && $force === 'n') {

            $ending1 = Flash::polishEnding1($transactions['transactions']);
            $ending2 = Flash::polishEnding2($transactions['transactions']);
            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istniej' . $ending2 . ' (' . $transactions['transactions'] . ') transakcj' . $ending1 . ', niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            IncomesCategoryAssignedToUsers::removeCategory($post_fetch_promise['id']);

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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( ExpensesCategoryAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            ExpensesCategoryAssignedToUsers::addCategory($_SESSION['user_id'], $post_fetch_promise['name']);

            $data['flash_message_body'][0] = 'dodano nową kategorię: ' . $post_fetch_promise['name'];
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( ExpensesCategoryAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = ExpensesCategoryAssignedToUsers::getCategoryName($post_fetch_promise['id']);
            ExpensesCategoryAssignedToUsers::updateCategory($post_fetch_promise['id'], $post_fetch_promise['name'], $post_fetch_promise['limit_value']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $post_fetch_promise['name'];
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $transactions = ExpensesCategoryAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $post_fetch_promise['id']);
        $category_name = ExpensesCategoryAssignedToUsers::getCategoryName($post_fetch_promise['id']);
        $force = $post_fetch_promise['force'];

        if($transactions && $force === 'n') {

            $ending1 = Flash::polishEnding1($transactions['transactions']);
            $ending2 = Flash::polishEnding2($transactions['transactions']);
            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istniej' . $ending2 . ' (' . $transactions['transactions'] . ') transakcj' . $ending1 . ', niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            ExpensesCategoryAssignedToUsers::removeCategory($post_fetch_promise['id']);

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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( PaymentMethodsAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            PaymentMethodsAssignedToUsers::addCategory($_SESSION['user_id'], $post_fetch_promise['name']);

            $data['flash_message_body'][0] = 'dodano nową kategorię: ' . $post_fetch_promise['name'];
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        if( PaymentMethodsAssignedToUsers::categoryExists($post_fetch_promise['name'], $_SESSION['user_id']) ) {

            $data['flash_message_body'][0] = 'kategoria "' . $post_fetch_promise['name'] .  '" już istnieje';
            $data['flash_message_type'][0] = 'warning';

        } else {

            $category_name = PaymentMethodsAssignedToUsers::getCategoryName($post_fetch_promise['id']);
            PaymentMethodsAssignedToUsers::updateCategory($post_fetch_promise['id'], $post_fetch_promise['name']);

            $data['flash_message_body'][0] = 'Zmieniono nazwę kategorii z: ' . $category_name['name'] . ' na: ' . $post_fetch_promise['name'];
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
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $transactions = PaymentMethodsAssignedToUsers::transactionsSumForSelectedCategory($_SESSION['user_id'], $post_fetch_promise['id']);
        $category_name = PaymentMethodsAssignedToUsers::getCategoryName($post_fetch_promise['id']);
        $force = $post_fetch_promise['force'];

        if($transactions && $force === 'n') {

            $ending1 = Flash::polishEnding1($transactions['transactions']);
            $ending2 = Flash::polishEnding2($transactions['transactions']);
            $data['flash_message_body'][0] = 'dla podanej kategorii: "' . $category_name['name'] . '" istniej' . $ending2 . ' (' . $transactions['transactions'] . ') transakcj' . $ending1 . ', niepowodzenie';
            $data['flash_message_type'][0] = 'warning';

            $data['category_name'] = $transactions['category_name'];
            $data['transactions'] = $transactions['transactions'];

        } else {

            PaymentMethodsAssignedToUsers::removeCategory($post_fetch_promise['id']);

            $data['flash_message_body'][0] = 'usunięto kategorię: ' . $category_name['name'];
            $data['flash_message_type'][0] = 'info';

        }

        $data['categories'] = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        echo json_encode($data);
        exit;
    }
}