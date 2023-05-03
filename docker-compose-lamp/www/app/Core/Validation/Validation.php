<?php

namespace App\Core\Validation;

use App\Core\Controller\Controller;
/**
 * Validation class is responsible for validating data
 */

class Validation extends Controller
{
    /**
     * validate method is responsible for validating data
     *
     * @param array $data
     * @return void
     */
    public static function validate(array $data)
{
    $errors = [];

    foreach ($data as $field => $rule) {
        $value = $rule[0];
        $rules = explode('|', $rule[1]);

        foreach ($rules as $rule) {
            $parameters = [];

            if (strpos($rule, ':') !== false) {
                [$rule, $parameterString] = explode(':', $rule, 2);
                $parameters = explode(',', $parameterString);
            }

            switch ($rule) {
                case 'required':
                    if (empty($value) || $value === '') {
                        $errors[$field] = "The $field field is required";
                    }
                    break;

                case 'unique':
                    
                    $model = 'App\\Models\\' . $parameterString;
                    $instance = new $model();
                    $result = $instance->select($field)->where($field, $value)->get();

                    if ($result) {
                        $errors[$field] = 'The ' . $field . ' field must be unique';
                    }
                    break;

                case 'numeric':
                    if (!is_numeric($value) && $value !== null) {
                        $errors[$field] = "The $field field must be a number";
                    }
                    break;
                case "exists":
                    $model = 'App\\Models\\' . $parameterString;
                    $instance = new $model();
                    $result = $instance->select($field)->where($field, $value)->get();

                    if (!$result) {
                        $errors[$field] = "This $field does not exist";
                    }
                    break;

                default:
                    break;
            }
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'][] = $errors;
    }
}
/**
 * filter method is responsible for filtering data
 *
 * @param array $data
 * @return array
 */
public static function filter(array $data)
{
    $filteredData = [];

    foreach ($data as $field => $value) {
        $filteredData[$field] = trim($value);
        $filteredData[$field] = stripslashes($value);
        $filteredData[$field] = htmlspecialchars($value,ENT_QUOTES, 'UTF-8');
        $filteredData[$field] = strip_tags($value);
    }
    return $filteredData;

}

}
