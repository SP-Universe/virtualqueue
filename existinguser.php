<?php
    require 'main.php';
    connectmysql();
    if (isset($_POST['guestid'])) {

        function validate($data){
    
           $data = trim($data);
    
           $data = stripslashes($data);
    
           $data = htmlspecialchars($data);
    
           return $data;
    
        }
    
        $guestid = validate($_POST['guestid']);
    
        if (empty($guestid)) {
    
            header("Location: index.php?error=Die Gast-ID ist ungültig: " . $guestid);
    
            exit();
    
        }else{
    
            if(checkforexistingid($guestid))
            {
                header("Location: index.php");
                setusercookie($guestid);
                
                exit();
            }
            else{
    
                header("Location: index.php?error=Unbekannte Gast-ID: " . $guestid);
    
                exit();
    
            }
    
        }
    
    }else{
    
        header("Location: index.php");
    
        exit();
    
    }
    close_connection();
?>
