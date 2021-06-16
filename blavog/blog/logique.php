<?php
session_start();
    if (isset($_POST['logOut'])){
        session_unset();
    }

    $racineSite = "http://localhost/firstblog/blavog";

    require_once dirname(__FILE__)."/../authentification/auth.php";
    require_once dirname(__FILE__)."/../access/db.php";

      $isOwner = false;
      $isUser = false;




    // Requete admin effacer un post

    if (isset($_POST['adminPostDel']) && $_POST['adminPostDel']!="" && $isAdmin){

  
   $idASupprimer = $_POST['adminPostDel'];
   $req = "DELETE FROM posts WHERE id=$idASupprimer";
   $deletePost = mysqli_query($maConnection, $req);

   if(!$deletePost){
      die(mysqli_error($maConnection));
   }
}

   // Requete admin dépublication

   if(isset($_POST['adminPostUnPublish']) && $isAdmin){

   $postToUnPublish = $_POST['adminPostUnPublish'];
   $req = "UPDATE posts SET published = '0' WHERE id = $postToUnPublish";
   $resultat = mysqli_query($maConnection, $req);
   header("Location: admin.php?adminPage=all");

   // Requete admin publication

   if(isset($_POST['adminPostPublish']) && $isAdmin){
      $postToPublish = $_POST['adminPostPublish'];
      $req = "UPDATE posts SET published = '1' WHERE id = $postToPublish";
      $resultat = mysqli_query($maConnection, $req);
      header("Location: admin.php?adminPage=all");
   }

   // Requete admin récuperation des posts

   if (isset($_GET['adminPage']) && $isAdmin){
         $req = "SELECT posts.id, posts.title, posts.published, users.display_name, users.username
         FROM posts INNER JOIN users
         ON users.id = posts.author_id";
         $posts = mysqli_query($maConnection, $req);
}

    // Requete modification image post

if( isset($_POST['postPic']) && $_POST['postPic'] == 'upload'){

   if (    isset($_FILES['postPictureToUpload']['name']   )   ){
         if($_SESSION['userId']== $_POST['authorId']){
            $postId = $_POST['postId']; 
            $extensionsAutorisees = array("jpeg", "jpg", "png");

            $hauteurMax = 720;
            $largeurMax = 1000;
        
            $tailleMax = 10000000;
                     
            $repertoireUpload = "../images/posts/";
         
         $nomTemporaireFichier = $_FILES['postPictureToUpload']['tmp_name'];
  

        $mesInfos = getimagesize($_FILES['postPictureToUpload']['tmp_name']);

        $monTableauExtensions = explode("/",$mesInfos['mime']); 
         $extensionUploadee = $monTableauExtensions[1];

       $unTableau =    explode("\\", $nomTemporaireFichier);

         $nomTemporaireSansChemin =  end($unTableau);
                                                
         $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
         
         $destinationFinale = $repertoireUpload.$nomFinalDuFichier;

          $maLargeur = $mesInfos[0];
         $maHauteur = $mesInfos[1];
         
         $maTaille = $_FILES['postPictureToUpload']['size'];


         if( in_array($extensionUploadee, $extensionsAutorisees) ){

             if($maTaille <= $tailleMax){

                 if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){

                             if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){

                                     echo "UPLOAD SUCCESSFUL";

                                     $requeteUploadPhotoProfile = "UPDATE posts SET image = '$nomFinalDuFichier' WHERE id = '$postId'";
                                       $resultatRequete = mysqli_query($maConnection, $requeteUploadPhotoProfile);
                                    if($resultatRequete){
                                       header("Location: postUnique.php?postId=$postId&info=picUploaded");

                                    }else{
                                       die(mysqli_error($maConnection) );
                                    }


                                 }else{

                                    header("Location: postUnique.php?postId=$postId&info=uploadFailed");
                                 }

                                 //
                 }else{

                  header("Location: postUnique.php?postId=$postId&info=resolution");
                 }

             }else{

               header("Location: postUnique.php?postId=$postId&info=oversized");
             }


         }else{

            header("Location: postUnique.php?postId=$postId&info=extension");
         }






         }else{

            echo "ce n'est pas VOTRE post, bas les pattes";
         }


   }
}




    // Requete upload photo de profil

    if( isset($_POST['profilePic']) && $_POST['profilePic'] == 'upload'){

            if (    isset($_FILES['pictureToUpload']['name']   )        ){
                  if($_SESSION['userId'] == $_POST['userId'] ){
                     $userId = $_POST['userId']; 
                     $extensionsAutorisees = array("jpeg", "jpg", "png");

                     $hauteurMax = 720;
                     $largeurMax = 1000;
                     $tailleMax = 10000000;
                 
                     $repertoireUpload = "../images/profiles/";
                  
                  $nomTemporaireFichier = $_FILES['pictureToUpload']['tmp_name'];
                  var_dump($nomTemporaireFichier);
      
                 $mesInfos = getimagesize($_FILES['pictureToUpload']['tmp_name']);
      
                 $monTableauExtensions = explode("/",$mesInfos['mime']); 
                  $extensionUploadee = $monTableauExtensions[1];
      
                $unTableau =    explode("\\", $nomTemporaireFichier);
      
                  $nomTemporaireSansChemin =  end($unTableau);
                                                         
                  $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
                  
                  $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
      
                   $maLargeur = $mesInfos[0];
                  $maHauteur = $mesInfos[1];
                  
                  $maTaille = $_FILES['pictureToUpload']['size'];
      
      
                  if( in_array($extensionUploadee, $extensionsAutorisees) ){
      
                      if($maTaille <= $tailleMax){
      
                          if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
      
                                      if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
      
                                              echo "UPLOAD SUCCESSFUL";

                                              $requeteUploadPhotoProfile = "UPDATE users SET image = '$nomFinalDuFichier' WHERE id = '$userId'";
                                                $resultatRequete = mysqli_query($maConnection, $requeteUploadPhotoProfile);
                                             if($resultatRequete){
                                                header("Location: profile.php?profile=$userId&info=picUploaded");

                                             }else{
                                                die(mysqli_error($maConnection) );
                                             }


                                          }else{
      
                                             header("Location: profile.php?profile=$userId&info=uploadFailed");
                                          }
      
                                          //
                          }else{
      
                           header("Location: profile.php?profile=$userId&info=resolution");
                          }
      
                      }else{
      
                        header("Location: profile.php?profile=$userId&info=oversized");
                      }
      
      
                  }else{
      
                     header("Location: profile.php?profile=$userId&info=extension");
                  }
      
      
      
      
      

                  }else{

                     echo "ce n'est pas VOTRE profil, bas les pattes";
                  }


            }
}
         


    // Requete modification de profil

    if(isset($_POST['userIdAModifier']) && $_POST['userIdAModifier'] !=""){

         $userId = $_POST['userIdAModifier'];
         if($_SESSION['userId'] == $userId){

               $newDisplayName = $_POST['displayName'];
               $newEmail = $_POST['email'];

               $maRequete = "UPDATE users SET display_name = '$newDisplayName', email = '$newEmail' WHERE id = $userId";

                     $resultatRequeteUpdateProfil = mysqli_query($maConnection, $maRequete);
                  if(!$resultatRequeteUpdateProfil){
                     die(mysqli_error($maConnection));
                  }else{
                     header("Location: profile.php?profile=$userId&info=edited");

                  }

         }else{
            die("vous n'avez pas le droit de modifier ce profil");
         }


   }

    // Requete affichage de profil

      if((isset($_GET['profile']) && $_GET['profile'] !="")
      || 
      (isset($_POST['profileEdit']) && $_POST['profileEdit'] != "" )){

         if(isset($_POST['profileEdit'])){
            $userId = $_POST['profileEdit'];
            $maRequeteProfile = "SELECT id, username, display_name, email, image FROM users WHERE id = '$userId'";
         }else{
            $userId = $_GET['profile'];
            $maRequeteProfile = "SELECT username, display_name, email, image FROM users WHERE id = '$userId'";
         }
         
         
         
         
         
         $resultatRequeteProfil = mysqli_query($maConnection, $maRequeteProfile);
         
         if($isLoggedIn && $_SESSION['userId'] == $userId){
              

               $isUser = true;
            }
            

   }
            

  

    // Requete de suppression d'un post

        if (isset($_POST['idSuppr']) ) {

            $idASupprimer = $_POST['idSuppr'];


            if($isLoggedIn && verifyOwnership($_SESSION['userId'], $idASupprimer, $maConnection) ) {



            $requeteDeSuppression = "DELETE FROM posts WHERE id= $idASupprimer";

            $suppression = mysqli_query($maConnection, $requeteDeSuppression);

            header( "Location: ../index.php");


         } else {

         header( "Location: ../index.php?info=pasLeDroit");

         }


      }
   
    

// Requete de modification d'un post

        if(isset($_POST['titleModif']) && isset($_POST['contentModif'])){
         
            $titreEdite = $_POST['titleModif'];
      
            $texteEdite = $_POST['contentModif'];

            $idPostAModifier = $_POST['idPostAModifier'];

// on refait passer l'Id par le biais d'un input supplémentaire

            if($isLoggedIn && verifyOwnership($_SESSION['userId'], $idPostAModifier, $maConnection) ){
             

               $maRequeteUpdate = "UPDATE posts SET title  = '$titreEdite', content = '$texteEdite' WHERE id = $idPostAModifier";

               $monResultat = mysqli_query($maConnection, $maRequeteUpdate);

               header("Location: postunique.php?postId=$idPostAModifier&info=edited");
            } else {
                header("Location: postunique.php?postId=$idPostAModifier&info=pasLeDroit");
            }
           

         }


// Requete de création de post

        if (isset($_POST['newTitle']) && isset($_POST['newContent']) ) {
            if ( $_POST['newTitle'] !== "" && $_POST['newContent'] !== "" ) {
                $createTitle = $_POST['newTitle'];
                $createContent = $_POST['newContent'];
                $authorId =  $_SESSION['userId'];
                $statusUpload = "default";

                     // Requete par défaut

                $maRequeteCreation = "INSERT INTO posts(title, content, author_id, image) VALUES ('$createTitle', '$createContent', '$authorId', 'default.jpg')";
                

                // s'il y a upload de photo

               if (    isset($_FILES['uploadPostPic']['name']   )   && $_FILES['uploadPostPic']['name'] != ""     ){
                  
                     
                        $extensionsAutorisees = array("jpeg", "jpg", "png");
   
                        $hauteurMax = 720;
                        $largeurMax = 1000;
                    
                        $tailleMax = 10000000;
                                 
                        $repertoireUpload = "../images/posts/";
                     
                     $nomTemporaireFichier = $_FILES['uploadPostPic']['tmp_name'];
                     var_dump($nomTemporaireFichier);
         
                    $mesInfos = getimagesize($_FILES['uploadPostPic']['tmp_name']);
                  
                    
                    if($mesInfos){                 
                    
                    $monTableauExtensions = explode("/",$mesInfos['mime']); 
                     $extensionUploadee = $monTableauExtensions[1];
         
                   $unTableau =    explode("\\", $nomTemporaireFichier);
         
                     $nomTemporaireSansChemin =  end($unTableau);
                                                            
                     $nomFinalDuFichier = $nomTemporaireSansChemin.".".$extensionUploadee;
                     
                     $destinationFinale = $repertoireUpload.$nomFinalDuFichier;
         
                      $maLargeur = $mesInfos[0];
                     $maHauteur = $mesInfos[1];
                     
                     $maTaille = $_FILES['uploadPostPic']['size'];
                     
         
                     if( in_array($extensionUploadee, $extensionsAutorisees) ){
         
                         if($maTaille <= $tailleMax){
         
                             if($maLargeur <= $largeurMax && $maHauteur <= $hauteurMax){
         
                                         if(move_uploaded_file($nomTemporaireFichier, $destinationFinale)){
         
                                                 echo "UPLOAD SUCCESSFUL";
                                                $statusUpload = "added";
                                                 $maRequeteCreation = "INSERT INTO posts(title, content, author_id, image) 
                                                 VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', '$nomFinalDuFichier')";
                                                   
   
                                             }else{
         
                                                $statusUpload = "failed";
                                             }
         
                                             //
                             }else{
         
                              $statusUpload = "resolution";
                             }
         
                         }else{
         
                           $statusUpload = "oversized";
                         }
         
         
                     }else{
         
                        $statusUpload = "extension";
                     }
                    }else{

                     $statusUpload = "notAPicture";
                    }
   
               }

                  $leResultatDeMonAjout = mysqli_query($maConnection, $maRequeteCreation);
                     // Test invisible pour les utilisateurs
                if(!$leResultatDeMonAjout){
                        die("RAPPORT ERREUR ".mysqli_error($maConnection));
                        
                     } 

                     header("Location: ../index.php?info=$statusUpload");
                    }
            else {
                echo "veuillez remplir tous les champs comme il faut svp";
            }
        }



// Requete pour un post précis

if (isset($_GET['postId']) || isset($_POST['postId']) ) {

     if(isset($_GET['postId'])){

              $postId = $_GET['postId'];
         
            }else{
         
                $postId = $_POST['postId'];
           }

if ($isLoggedIn) {


           if(verifyOwnership($_SESSION['userId'], $postId, $maConnection)){
           
            $isOwner = true;
           }
}

    $maRequetePostUnique = "SELECT * FROM posts WHERE id=$postId";

    $leResultatDeMaRequetePostUnique = mysqli_query($maConnection, $maRequetePostUnique);
       
    $mesCommentaires = getCommentsByPostId($postId, $maConnection);
     
     
            }else if(isset($_POST['myPosts']) && $isLoggedIn  ){

            
            $userId = $_SESSION['userId'];

            echo "on est bien dans le cas MES POSTS";

        $maRequete = "SELECT posts.image, posts.title, posts.content, posts.id, posts.published, posts.author_id, users.display_name, users.username
         FROM posts
         INNER JOIN users ON users.id = posts.author_id";

$leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);




}else{    //effectuer une requete SQL pour récupérer TOUS les posts
   
   $maRequete = "SELECT posts.image, posts.title, posts.content, posts.id, posts.author_id, users.display_name, users.username
         FROM posts
         INNER JOIN users ON users.id = posts.author_id
         WHERE posts.published = '1'";
   
        $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
        
     }

     // Requete publication

       if (isset($_POST['publish']) && $_POST['publish'] != "") {
         $post = $_POST['publish'];
         $author = $_POST['userId'];

         if($isLoggedIn && $author == $_SESSION['userId'] && 
         verifyOwnership($author, $post, $maConnection )) {

         

         $maRequetePublish = "UPDATE posts SET published = '1'
         WHERE id = '$post'";
         $monResultat = mysqli_query($maConnection, $maRequetePublish);

            if($monResultat){
         header ("Location: ../index.php?postId=$post");
         }
      }
}


      // Requete dépublication

      if (isset($_POST['unPublish']) && $_POST['unPublish'] != "") {
         $post = $_POST['unPublish'];
         $author = $_POST['userId'];

          if($isLoggedIn && $author == $_SESSION['userId'] && 
         verifyOwnership($author, $post, $maConnection )) {


         $maRequeteUnpublish = "UPDATE posts SET published = '0'
         WHERE id = '$post'";
         $monResultat = mysqli_query($maConnection, $maRequeteUnpublish);

            if($monResultat){
         header ("Location: ../index.php?postId=$post");
         }
      }
   }


      // Requete poster un commentaire

      if (isset($_POST['comment']) && $_POST['comment'] !== "" && $isLoggedIn) {
        
           $commentPost = $_POST['comment'];
           $postToComment =  $_POST['postToComment'];
           $commentAuthor = $_POST['commentAuthor'];

         if($commentAuthor == $_SESSION['userId'] && $postToComment != "") { 

           $maRequeteCommentaire = "INSERT INTO comments (content, author_id, post_id) 
           VALUES ('$commentPost', '$commentAuthor', '$postToComment')";

           $resultatRequeteCommentaire = mysqli_query($maConnection, $maRequeteCommentaire);

            if($resultatRequeteCommentaire){
           header("Location: postunique.php?postId=$postToComment&info=commented");
        } else {

           die(mysqli_error($maConnection));
        }
        
         }
      }


      function verifyOwnership($userId, $postId, $maConnection){

      
         //on veut comparer l'userId au author_id

         //a partir du postId faire une requete SQL pour récurérer l'author_id
         //et comparer l'userId de la session à cet author_id récupéré directement depuis la BDD
         //et regler $ownerVerified sur true ou false en fonction de cela


            $maRequeteDeVerification = "SELECT * FROM posts WHERE id = '$postId'";



               $resultatRequeteVerification = mysqli_query($maConnection, $maRequeteDeVerification);

               foreach($resultatRequeteVerification as $value){
                  $authorId = $value['author_id'];

               }

               $ownerVerified = false;

               if($userId == $authorId){

                  $ownerVerified = true;
               }         


            if($ownerVerified){

               return true;
            }else{

               return false;
            }

      }
     
         function getDisplayNameById($userId, $maConnection){
            $requete = "SELECT display_name FROM users WHERE id='$userId'";

            return var_dump(mysqli_query($maConnection, $requete));

      }


         
      function getCommentsByPostId($postId, $maConnection){

            $maRequeteComments = "SELECT comments.content, users.display_name, users.username 
                                 FROM comments 
                                 INNER JOIN users
                                 ON comments.author_id = users.id
                                 WHERE comments.post_id = '$postId'";
            
            $resultatRequeteComments = mysqli_query($maConnection, $maRequeteComments);

            return $resultatRequeteComments;

      }

      
      
      

   }

    ?>