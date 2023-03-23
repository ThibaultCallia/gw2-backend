<?php

function jsonDecodeInput()
{
    $params = file_get_contents('php://input');
    return json_decode($params, true);
}

// Folowing function is used to validate the data sent to the API
// foreach is open to be extended with more validation
//  - name is required
//  - name can't be longer than 75 characters
//  - name can't contain special characters
//  - id and isChecked are not allowed
function queryValidation($params)
{
    $required = ['name'];
    $nonAllowed = ['id', 'isChecked'];
    foreach ($required as $key) {
        if (!isset($params[$key]) || empty($params[$key])) {
            return "No name provided";
        }
        if ($key === 'name' && strlen($params[$key]) > 75) {
            return "Name is too long";
        }
        $pattern = '/[\'^£$%&*()}{@#~:><>,|=_+¬-]/';
        if ($key === 'name' && preg_match($pattern, $params[$key])) {
            return "Name contains invalid characters";
        }
    }
    foreach ($nonAllowed as $key) {
        if (isset($params[$key])) {
            return "Invalid data";
        }
    }

    return false;
}
