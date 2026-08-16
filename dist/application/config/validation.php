<?php

// Username rules: letters, numbers, dots (.) and underscores (_) only.
// Returns an error message, or null when the username is valid.
function validate_username($username)
{
    $username = trim($username);

    if ($username === "") {
        return "Username is required";
    }

    if (strlen($username) < 3) {
        return "Username must be at least 3 characters";
    }

    if (strlen($username) > 50) {
        return "Username must not be longer than 50 characters";
    }

    if (!preg_match('/^[A-Za-z0-9._]+$/', $username)) {
        return "Username can only contain letters, numbers, dots (.) and underscores (_)";
    }

    return null;
}

// Password rules: between 4 and 10 characters.
// Returns an error message, or null when the password is valid.
function validate_password($password)
{
    if ($password === "") {
        return "Password is required";
    }

    if (strlen($password) < 4) {
        return "Password must be at least 4 characters";
    }

    if (strlen($password) > 10) {
        return "Password must not be longer than 10 characters";
    }

    return null;
}

// Turns a MySQL "Duplicate entry ..." error into a friendly message.
// Returns null when the error is not a duplicate-entry error.
function duplicate_entry_message($error)
{
    if (stripos($error, "Duplicate entry") === false) {
        return null;
    }

    if (stripos($error, "username") !== false) {
        return "This username already exists, please choose another one";
    }

    if (stripos($error, "email") !== false) {
        return "This email is already registered";
    }

    return "This record already exists";
}
?>
