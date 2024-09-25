<?php
require_once "Database.php"; // טעינת קובץ חיצוני צריכה להתבצע מחוץ לקלאס

class Checkings
{
    // פונקציה לבדיקה אם ערך ריק
    public function checkEmpty($val, $valName, &$err)
    {
        if (empty($val)) {
            $err[] = $valName . " is empty";
        }
    }

    // פונקציה לבדיקה של סיסמה
    public function checkPassword($Password, &$err)
    {
        if (!empty($Password)) {
            if (!preg_match("/^[a-zA-Z0-9]{8}$/", $Password)) {
                $err[] = "Password can contain 8 letters and digits only";
            }
        } else {
            $err[] = "Password can't be empty";
        }
    }

    // פונקציה לבדיקה של תעודת זהות
    public function checkId($ID, &$err)
    {
        if (!empty($ID)) {
            if (!preg_match("/^[1-3]{1}[0-9]{8}$/", $ID)) {
                $err[] = "Id can contain 9 digits only and must start with 1-3";
            }
        } else {
            $err[] = "Id can't be empty";
        }
    }

    // פונקציה לבדיקה של מספר טלפון
    public function checkPhone($Phone, &$err)
    {
        if (!empty($Phone)) {
            if (!preg_match("/^\+?(972|0)(\-)?0?(([23489]{1}\d{7})|[5]{1}\d{8})$/", $Phone)) {
                $err[] = "Wrong phone format";
            }
        } else {
            $err[] = "Phone can't be empty";
        }
    }

    // פונקציה לבדיקה של כתובת אימייל
    public function checkEmail($Email, &$err)
    {
        global $pdo; // כאן תוכל להגדיר את המשתנה הגלובלי בתוך הפונקציה

        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM customer WHERE Email = :Email");    
            $stmt->execute(['Email' => $Email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $err[] = "Email already exists";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // פונקציה לבדיקה של תאריך
    public function checkDate($Date, $date_name, &$err)
    {
        if (!empty($Date)) {
            if (!preg_match("/^[0-9]{2}(\/){1}[0-9]{2}(\/){1}[0-9]{4}$/", $Date)) {
                $err[] = "Wrong " . $date_name . " format (Must be dd/mm/yyyy)";
            }
        } else {
            $err[] = "Birthday date can't be empty";
        }
    }

    // פונקציה לבדיקה של כתובת
    public function checkAddress($Address, &$err)
    {
        if (empty($Address)) {
            $err[] = "Address can't be empty";
        }
    }
}