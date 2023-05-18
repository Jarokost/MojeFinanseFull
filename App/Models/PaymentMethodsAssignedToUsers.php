<?php

namespace App\Models;

use PDO;
use \App\Config;
use \Core\View;

/**
 * payment_methods_assigned_to_users model
 *
 * PHP version 8.2
 */
class PaymentMethodsAssignedToUsers extends \Core\Model
{
    /**
     * payment_methods_assigned_to_users table id
     * 
     * @var string
     */
    public $id;

    /**
     * payment_methods_assigned_to_users table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * payment_methods_assigned_to_users table name
     * 
     * @var string
     */
    public $name;
    
    public static function getCategoriesAssignedToUser($user_id)
    {
        $sql = 'SELECT * FROM payment_methods_assigned_to_users
                WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    public static function fillCategoriesAssignedToUserWithDefault($user_id)
    {
        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                SELECT :user_id, name FROM payment_methods_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->execute();

    }
}