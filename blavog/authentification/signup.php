<?php
    if (isset($_POST['usernameSignUp']) &&
    isset($_POST['passwordSignUp']) &&
    isset($_POST['passwordRetypeSignUp']) ){

        echo " tout est ok";

            if ( $_POST['usernameSignUp'] !== "" &&
                $_POST['passwordSignUp'] !== "" &&
                $_POST['passwordRetypeSignUp'] !== "" ){

                    echo "tout est bien rempli";

                $usernameEntre =  $_POST['usernameSignUp'];
                $passwordEntre =  $_POST['passwordSignUp'];
                $passwordRetypeEntre = $_POST['passwordRetypeSignUp'];
                

            if ($passwordEntre == $passwordRetypeEntre){

                require_once  dirname(__FILE__)."/../access/db.php";

    $userNameEntreFiltre =  mysqli_real_escape_string($maConnection, $usernameEntre );

    $maRequeteDeCheck =
    "SELECT * FROM users WHERE username= '$userNameEntreFiltre'";

    $retourRequeteCheckUsername = mysqli_query($maConnection, $maRequeteDeCheck);

            if($retourRequeteCheckUsername->num_rows == 0){

            // echo "on peut l'inscrire";
            $passwordEntreCrypte = md5($passwordEntre);

            require_once dirname(__FILE__)."/../access/salt.php";

            $passwordEntreCrypteSaleCrypte = $passwordEntreCrypte.md5($salt);

            $maRequeteInscription =  "INSERT INTO users (username, password, image) 
            VALUES ('$usernameEntre', '$passwordEntreCrypteSaleCrypte', 'default.png')";

            $resultatInscription = mysqli_query($maConnection, $maRequeteInscription);


            if($resultatInscription) {
                
                header("location: index.php?info=registered");

            }else {

                die(mysqli_error($maConnection));
            }

                }else {
                    echo " username indisponible";
                }

         }else {
            echo " les deux mots de passe ne sont pas identique";
            }
    
    } else {
        echo " veuillez bien remplir tout les champs";
        }

}else{
    echo "c'est pas fini";
}        

    ?>