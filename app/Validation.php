<?php

namespace Visma;

date_default_timezone_set('Europe/Vilnius');

use PDO;

class Validation
{

    private static $errors = [];

    public static function appointment($post)
    {
        self::name($post['name']);
        self::email($post['email']);
        self::phone($post['phoneNumber']);
        self::personalId($post['personalId']);
        self::date($post['date'], $post['time']);

        return self::$errors;
    }

    private static function name($e)
    {
        $val = preg_match('/^[a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]{3,50}$/', $e);

        if (!$val) {
            Validation::$errors['name'] = 'Name can only contain letters';
        } else {
            Validation::$errors['name'] = '';
        }
    }

    private static function email($e)
    {
        if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
            Validation::$errors['email'] = 'Incorrect email format';
        } else {
            Validation::$errors['email'] = '';
        }
    }

    private static function phone($e)
    {
        $val = preg_match('/^[+]?[0-9]{5,20}$/', $e);

        if (!$val) {
            Validation::$errors['phone'] = 'Please enter a correct phone number';
        } else {
            Validation::$errors['phone'] = '';
        }
    }

    private static function personalId($e)
    {
        $val = preg_match('/^[0-9]{11}$/', $e);

        if (!$val) {
            Validation::$errors['personal'] = 'Personal ID must consist of 11 digits';
        } else {
            Validation::$errors['personal'] = '';
        }
    }

    private static function date($e, $t)
    {
        $now = date('Y-m-d H:i');
        $post = $e . " " . $t;

        if ($post <= $now) {
            Validation::$errors['date'] = 'Please select a future time';
        } else {
            Validation::$errors['date'] = '';
        }
    }
}
