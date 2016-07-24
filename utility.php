<?php

function UserExists($email) {
    $sql = "SELECT * FROM Utente WHERE email='$email'";

    if ($result = db_query($sql)) {
        printf("Select returned %d rows.\n", mysqli_num_rows($result));
        
        if (mysqli_num_rows($result) == 0) {
            mysqli_free_result($result);
            return FALSE;
        } else {
            mysqli_free_result($result);
            return TRUE;
        }
    }
    return FALSE;
}

?>
