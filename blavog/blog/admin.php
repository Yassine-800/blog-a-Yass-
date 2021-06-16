<?php 

require_once "logique.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
</head>
<body>
   


<?php require_once dirname(__FILE__)."/../navbar.php"; 

if ($isAdmin){?>


    <p>salut admin</p>

<?php 
var_dump($posts);
foreach($posts as $value){?>
    
    <div class="row">

    <div class="col-4">       
         <p><strong><?php echo $value['title']?></strong></p>
        <p><?php echo $value['display_name']?></p></div>
    <div class="col-4">
    
        <form action="" method="post">
            <div class="form-group">
            <button class="btn btn-danger" type="submit" name="adminPostDel" value="<?php echo $value['id']?>">Effacer</button>
            </div>
        </form>
        <form action="" method="post">
            <div class="form-group">
                <?php if($value['published']){?>

            <button class="btn btn-warning" type="submit" name="adminPostUnPublish" value="<?php echo $value['id']?>">Dépublier/button>
           <?php }else{?>
           

                       <button class="btn btn-success" type="submit" name="adminPostPublish" value="<?php echo $value['id']?>">Publier</button>

           
           <?php } ?>
           
           
            </div>
        </form>
        
    </div>
            <div class="col-4">
            
                <a class="btn btn-primary" href="postUnique.php?postId=<?php echo $value['id'] ?>">voir article</a>
            
            </div>
        

    <hr>
    </div>
<?php } ?>






<?php }else{?>


<p>vous n'etes pas administrateur</p>


<?php }?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>