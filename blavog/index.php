<?php

  
    require "blog/logique.php";


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog a yass</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/superhero/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php require_once "navbar.php" ?>
    
    <?php if(isset($_GET['info']) && $_GET['info'] == "registered"){ ?>

    <div class="alert alert-success" role="alert">
    Successfully registered !
    </div>


    <?php }?>
    <?php if( isset($_GET['info']) && $_GET['info'] == "added" ){?>

    <div class="alert alert-dismissible alert-success">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Bien joué!</strong> Tu as bien posté <a href="#" class="alert-link">un nouveau post</a>.
    </div>
    <?php } ?>

    <?php if( isset($_GET['info']) && $_GET['info'] == 'default' ){?>

        <div class="alert alert-dismissible alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Well done!</strong> You successfully posted but no picture<a href="#" class="alert-link">a new article</a>.
        </div>
    <?php } ?>

    <?php if( isset($_GET['info']) && $_GET['info'] == 'deleted' ){?>

    <div class="alert alert-dismissible alert-danger">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Tout est bon!</strong> Tu as bien effacé <a href="#" class="alert-link">ce post</a>.
    </div>
    <?php } ?>

    <?php if( isset($_GET['info']) && $_GET['info'] == 'pasLeDroit' ){?>

    <div class="alert alert-dismissible alert-danger">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <strong>Non!</strong> arrete ne touche pas à <a href="#" class="alert-link">ce post</a>.
    </div>
    <?php } ?>
    
    


        <div class="container">

            <div class="row mt-5">



<?php if($modeInscription){ ?>
    <form method="POST">

        <div class="form-group">
            <label for="username">Username</label>

            <input type="text" class="form-control" name="usernameSignUp">
        </div>
        <div class="form-group">
            <label for="passwordSignUp">Password</label>

            <input type="password" class="form-control" name="passwordSignUp">
        </div>
        <div class="form-group">
            <label for="passwordRetypeSignUp">Re-type password</label>

            <input type="password" class="form-control" name="passwordRetypeSignUp">
        </div>
        
       
        <div class="form-group">
            <input type="hidden" name="modeInscription" value="on">
            <input type="submit" value="Sign up" class="btn btn-success">
        </div>

    </form>
    <form method="POST">
        <button class="btn btn-success" name="modeInscription" value="off">Se connecter</button>
    </form>

    <hr>
<?php } else {?>

        <?php
var_dump($leResultatDeMaRequete);
    foreach ($leResultatDeMaRequete as $post) { 
        ?>

         <div class="col-4">
                    
                            <div class="card text-white bg-success mb-3" style="max-width: 20rem;">
                            <img src="images/posts/<?php echo $post['image']?>" alt="">

                            <div class="card-header"><?php echo $post["title"]; ?></div>
                            <div class="card-body">
                               <h4 style="color : black" class="card-title"><a style="color : black" href="<?php echo $racineSite ?>
                               /blog/profile.php?profile=<?php echo $post['author_id'] ?>"> Auteur : 
                               <?php if($post["display_name"] != ""){ echo $post["display_name"];}else{echo $post['username'];} ?></a></h4>
                                <p class="card-text"><?php echo $post["content"]; ?></p>
                            </div>
                            

                           
                           
                           <?php if(isset($post['published'])) {
                               if($post['published']){?> 
                            <span class="badge bg-light">Publié</span>

                            <?php } else{?>
                            <span class="badge bg-warning">Non publié</span>
                            <?php } } ?>
                                <a href ="blog/postUnique.php?postId=<?php echo $post['id'] ?>" class="btn btn-success">Voir l'article</a>
                        
                    
         </div>
        <?php 
             } ?>

<?php } ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>


