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
class IncomesCategoryAssignedToUsers extends \Core\Model
{
    /**
     * incomes_category_assigned_to_users table id
     * 
     * @var string
     */
    public $id;

    /**
     * incomes_category_assigned_to_users table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * incomes_category_assigned_to_users table name
     * 
     * @var string
     */
    public $name;
    
    public static function getCategoriesAssignedToUser($user_id)
    {
        $sql = 'SELECT * FROM incomes_category_assigned_to_users
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
        $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
                SELECT :user_id, name FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->execute();

    }

    /**
     * update category name
     * 
     * @return void
     */
    public static function updateCategory($id, $name)
    {
        $sql = 'UPDATE incomes_category_assigned_to_users
                SET name = :name
                WHERE id = :id'; 

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * remove category
     * 
     * @return void
     */
    public static function removeCategory($id)
    {
        $sql = 'DELETE FROM incomes_category_assigned_to_users
                WHERE id = :id'; 

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }
}