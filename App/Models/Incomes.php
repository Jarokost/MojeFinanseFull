<?php

namespace App\Models;

use PDO;
use \App\Config;
use \Core\View;

/**
 * Incomes model
 *
 * PHP version 8.2
 */
class Incomes extends \Core\Model
{
    /**
     * incomes table id
     * 
     * @var string
     */
    public $id;

    /**
     * incomes table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * incomes table incomes_category_assigned_to_user_id
     * 
     * @var string
     */
    public $incomes_category_assigned_to_user_id;

    /**
     * incomes table amount
     * 
     * @var string
     */
    public $amount;

    /**
     * incomes table date_of_income
     * 
     * @var string
     */
    public $date_of_income;

    /**
     * incomes table income_comment
     * 
     * @var string
     */
    public $income_comment;

    
}