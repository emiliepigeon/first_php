<?php
    include '../config/database.php';

    global $message; var_dump($_POST);
    /**
     * methode pour update un article
     */

    if(isset($_GET['method']) && $_GET['method'] && 'update'){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT art.*, CAT.title AS cat FROM article AS art INNER JOIN mydb.categories as CAT WHERE art.id = :id AND art.categories_id = cat.id LIMIT 1";
            $toto = $conn->prepare($sql);
            $toto->bindParam(':id', $id);
            $toto->execute();
            $article = $toto->fetch(PDO::FETCH_ASSOC);
            
        }
    }
    if(isset($_GET['update']) && $_GET['update'] == 'update'){
        $id = $_POST['id'];
        $cover = $_POST['cover'];
        $categories_id = $_POST['categories_id'];
        $title = $_POST['title'];
        
    
        $sql = "UPDATE article SET cover = :cover, categories_id = :categories_id, title = :title WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'cover' => $cover,
            'categories_id' => $categories_id,
            'title' => $title,
            'id' => $id
        ]);
        header('location: article.php');
    }
    

    $sql = "SELECT id, title FROM categories";
    $cat = $conn->prepare($sql);
    $cat->execute();
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
.table_component {
    overflow: auto;
    width: 100%;
}

.table_component table {
    border: 1px solid #dededf;
    height: 100%;
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    border-spacing: 1px;
    text-align: left;
}

.table_component caption {
    caption-side: top;
    text-align: left;
}

.table_component th {
    border: 1px solid #dededf;
    background-color: #eceff1;
    color: #000000;
    padding: 5px;
}

.table_component td {
    border: 1px solid #dededf;
    background-color: #ffffff;
    color: #000000;
    padding: 5px;
}
</style>
<form method="post" action="article_update.php?update=update">
    <div class="table_component" role="region" tabindex="0">
    <table>
        <caption>Table 1</caption>
        <thead>
            <tr>
                <th>id</th>
                <th><input type="text" name="id" value="<?= $article['id'] ?$article['id'] : '' ?>"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>title</td>
                <td><input type="text" name="title" value="<?= $article['title'] ?$article['title'] : '' ?>"></td>
            </tr>
            <tr>
                <td>cover</td>
                <td><input type="text" name="cover" value="<?= $article['cover'] ?$article['cover'] : '' ?>"></td>
            </tr>
            <tr>
                <td>categories_id</td>
                <td><select name="categories_id">
                <option value="1" <?= $article['categories_id'] == 43 ? 'selected' : ''; ?>>Cinéma</option>
                <option value="2" <?= $article['categories_id'] == 44 ? 'selected' : ''; ?>>Séries</option>
                <option value="3" <?= $article['categories_id'] == 45 ? 'selected' : ''; ?>>Gaming</option>
                <option value="4" <?= $article['categories_id'] == 46 ? 'selected' : ''; ?>>Musique</option>
                <option value="5" <?= $article['categories_id'] == 47 ? 'selected' : ''; ?>>Livre</option>
                <option value="6" <?= $article['categories_id'] == 48 ? 'selected' : ''; ?>>Evenement</option>
            </select>
            </td>
            </tr>
        </tbody>
    </table>
    <button type="submit">Envoyer</button>
    </div>
</form>
</body>
</html>