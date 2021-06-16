<?php

    echo "login fonctionnel";

    if (isset($_POST['username']) && isset($_POST['password']) ) {

        $userNameEntre = $_POST['username'];
        $passwordEntre = $_POST['password'];

        if ($userNameEntre != "" && $passwordEntre != "") {
            require_once dirname(__FILE__)."/../access/db.php";

            $userNameFiltre = mysqli_real_escape_string($maConnection, $userNameEntre);

            $maRequete = "SELECT * FROM users WHERE username = '$userNameFiltre' ";

            $leResultatRequeteLogin = mysqli_query($maConnection, $maRequete);

            if ($leResultatRequeteLogin->num_rows == 1) {

                foreach ($leResultatRequeteLogin as $value) {
                    $motDePasseVrai = $value['password'];
                    $userId = $value['id'];
                    $displayName = $value['display_name'];
                    $username = $value['username'];
                    $role = $value['role'];
             }

                require_once dirname(__FILE__)."/../access/salt.php";

                if (md5($passwordEntre).md5($salt) == $motDePasseVrai) {
                    
                    $isLoggedIn = true;

                     $_SESSION['userId'] = $userId;  
                     $_SESSION['username'] = $username;
                     $_SESSION['displayName'] = $displayName; 
                          
                            echo "connecté";

                            if($role == 'admin'){

                                $isAdmin = true;
                                $_SESSION['role'] = 'admin';
                            }

                        }else{
                            echo "mauvais mot de passe, $userNameEntre";
                        }

                    }else{
                        echo "username inexistant";
                    }


            }else{

                echo "Veuillez entrer un username et un password";
            }


    }


?>