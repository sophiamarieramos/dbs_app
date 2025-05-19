<?php
 
class database {
 
    function opencon() {
        return new PDO(
            'mysql:host=localhost;dbname=DBS_APP',
            'root',
            ''
        );
    }
 
    function signupUser($firstname, $lastname, $username, $email, $password) {
        $con = $this->opencon();
 
        try {
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO Admin (admin_FN, admin_LN, admin_username, admin_email, admin_password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $username, $email, $password]);
 
            $userId = $con->lastInsertId();
            $con->commit();
 
            return $userId;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
    function isUsernameExists ($username) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
        }
         function isEmailExists ($email) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
        }
}