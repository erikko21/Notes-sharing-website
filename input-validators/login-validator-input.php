<?php
    include('../included-files/connect-database.php');

    $username_input = 'username';
    $password_input = 'password';

    if (isset($_POST[$username_input]) && isset($_POST[$password_input])) {
        $username = mysqli_real_escape_string($connection, $_POST[$username_input]);
        $password = mysqli_real_escape_string($connection, $_POST[$password_input]);
        login($connection, $username, $password);
    }

    function login($connection, $username, $password) {

        // declare table names
        $student_table = STUDENT_TABLE_NAME;
        $student_id = STUDENT_ID;
        $student_username = STUDENT_USERNAME;
        $student_password = STUDENT_PASSWORD;

        $query  = " SELECT $student_id ,$student_username, $student_password ";
        $query .= " FROM $student_table ";
        $query .= " WHERE $student_username = '$username' && $student_password = '$password';";

        $result = mysqli_query($connection, $query);
        $num_rows = mysqli_num_rows($result);

        if ($num_rows != 0) {
            session_start();

            include('../included-files/SessionConstant.php');

            $_SESSION[SESSION_STATUS] = true;
            $_SESSION[SESSION_STUDENT_USERNAME] = $username;

            $row = mysqli_fetch_assoc($result);
            $_SESSION[SESSION_STUDENT_ID] = $row[$student_id];

            echo true;
        } else {
            echo false;
        }
    }

?>