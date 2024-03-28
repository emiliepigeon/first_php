<?php 
    include '../Config/database.php';
    global $message ;

    // Création du CRUD

    // méthode pour supprimer un article
    if(isset($_GET['method']) && $_GET['method'] == 'delete'){
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM article WHERE id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $message = "<div class='alert alert-success text center'>L'article a été supprimé </div>";
        }
    }

    //méthode pour lister les article et le titre des categories
    $sql = "SELECT art.*, CAT.title AS cat FROM article AS art INNER JOIN mydb.categories as CAT WHERE art.categories_id = CAT.id ORDER BY art.id DESC"; 


    $stmt = $conn->prepare($sql);
    $stmt->execute();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style type="text/css">
.tftable {font-size:12px;color:#fbfbfb;width:100%;border-width: 1px;border-color: #686767;border-collapse: collapse;}
.tftable th {font-size:12px;background-color:#171515;border-width: 1px;padding: 8px;border-style: solid;border-color: #686767;text-align:left;}
.tftable tr {background-color:#2f2f2f;}
.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #686767;}
.tftable tr:hover {background-color:#171515;}
</style>

<table class="tftable" border="1">
<tr><th>id</th><th>categories</th><th>cover</th><th>title</th><th>created_at</th><th>update</th><th>vue</th><th>delete</th></tr>
<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
<tr><td><?=$row['id'] ?></td><td><?=$row['cat'] ?></td><td><?=$row['cover'] ?></td><td><?=$row['title'] ?></td><td><?=$row['created_at'] ?></td>
<td><a href="article_update.php?method=update&id=<?= $row['id']?>">update</a></td>
<td><a href="">vue</a></td>
<td><a href="article.php?method=delete&id=<?= $row['id']?>">delete</a></td>
</tr>
<?php } ?>
</table>

 
</body>
</html>