<?php

namespace App;

/**
 * Flash notification messages: messages for one-time display using the session
 * for storage between requests.
 *
 * PHP version 7.0
 */
class Flash
{

    /**
     * Success message type
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * Information message type
     * @var string
     */
    const INFO = 'info';

    /**
     * Warning message type
     * @var string
     */
    const WARNING = 'warning';

    /**
     * Add a message
     *
     * @param string $message  The message content
     * @param string $type  The optional message type, defaults to SUCCESS
     *
     * @return void
     */
    public static function addMessage($message, $type = 'success')
    {
        // Create array in the session if it doesn't already exist
        if (! isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        // Append the message to the array
        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    /**
     * Get all the messages
     *
     * @return mixed  An array with all the messages or null if none set
     */
    public static function getMessages()
    {
        if (isset($_SESSION['flash_notifications'])) {
            //return $_SESSION['flash_notifications'];
            $messages = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }

    /**
     * Change polish endings numerals
     * 
     * @return string
     */
    public static function polishEnding1($number) 
    {
        if ( $number < 2 ) {
            return 'a';
        }
        else if ( $number < 5 ) {
            return 'e';
        } else if ( $number >= 5 && $number < 20 ) {
            return 'i';
        } else {
            $mod = $number % 10;
            if ( ($mod >= 0 && $mod <= 1) || ($mod >= 5 && $mod <= 9) ) {
                return 'i';
            } else {
                return 'e';
            }
        }
    }

    /**
     * Change polish endings numerals
     * 
     * @return string
     */
    public static function polishEnding2($number) 
    {
        if ( $number < 2 ) {
            return 'e';
        }
        else if ( $number < 5 ) {
            return 'ą';
        } else if ( $number >= 5 && $number < 20 ) {
            return 'e';
        } else {
            $mod = $number % 10;
            if ( ($mod >= 0 && $mod <= 1) || ($mod >= 5 && $mod <= 9) ) {
                return 'e';
            } else {
                return 'ą';
            }
        }
    }
}
