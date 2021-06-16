<?php
    require "logique.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/superhero/bootstrap.css">
</head>
<body>

<?php require_once dirname(__FILE__)."/../navbar.php" ?>

<div class="container">
    <?php

    foreach ($leResultatDeMaRequetePostUnique as $value) { ?>

        <img src="../images/posts/<?php echo $value['image']?>" alt="" srcset="">
<p>modifier la photo :</p>
            <form action="" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="postPic" value="upload">

                    <input type="hidden" name="postId" value="<?php echo $value['id'] ?>">
                    <input type="hidden" name="authorId" value="<?php echo $value['author_id'] ?>">

                    <input type="file" name="postPictureToUpload">
                    <button type="submit" class="btn btn-primary">Envoyer la photo</button>
            </form>



        <form  class='row' method="POST">
            <div class='col-5'>
                <input type="hidden" name=" idPostAModifier " value="<?php echo $value['id'] ?>">
                <input type="hidden" name="postId"  class='form-control' value="<?php echo $value['id'] ?>" >
            </div>
            <div class="col-auto">
                <input class="form-control" type="text" name="titleModif" id="" value="<?php echo $value['title'] ?>" placeholder="votre titre">
                <textarea class="form-control" name="contentModif" placeholder="Texte"><?php echo $value['content'] ?></textarea>
                <input class="form-control btn btn-success" type="submit" value="Enregistrer les modifications">
            </div>

        </form>
    <?php } ?>

        <form action="" method="POST" >
            <input type="hidden" name="idSuppr" value="<?php echo $value['id'] ?>">

            <div class="row">

                <input type="submit" class="btn btn-danger" value="Supprimer ce Post" >
            </div>
        </form>
    
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>

