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
    <title>Création de posts</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/superhero/bootstrap.css">
</head>
<body>

<?php require_once dirname(__FILE__)."/../navbar.php" ?>

<div class="container">


    <form action="logique.php" method="POST" enctype="multipart/form-data" class='row g-3'>
    <input type="file" name="uploadPostPic">
        <div class='col-auto'>
            <input type='text'   class='form-control'  name="newTitle" placeholder='Title'>
        </div>
        <div class="col-auto">
            <textarea class="form-control" name="newContent" id="" cols="30" rows="10" placeholder="votre texte">
            </textarea>
        </div>
        
        <div class='col-auto'>
            <input class="form-control btn btn-success" type='submit' value='Valider' >
        </div>

    </form>
</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" 
 integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>

