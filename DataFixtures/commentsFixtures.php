<?php
include '../Config/database.php';
require_once '../vendor/autoload.php';

$user = "SELECT id FROM user";
$usersStatement = $conn->prepare($user);
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$categorie = "SELECT id FROM categories";
$categoriesStatement = $conn->prepare($categorie);
$categoriesStatement->execute();
$categories = $categoriesStatement->fetchAll();

$article = "SELECT id FROM article";
$articleStatement = $conn->prepare($article);
$articleStatement->execute();
$article = $articleStatement->fetchAll();

$faker = Faker\Factory::create();


// insérer dix commentaire dans la base de données
for ($i = 0; $i < 10; $i++) {
    $sql = "INSERT INTO comments (`description`, `created_at`, `updated_at`, `article_id`, `user_id`) 
            VALUES(:description, :created_at, :updated_at, :article_id, :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'description' => $faker->paragraph(),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => $faker->date(),
        'article_id' => $article[array_rand($article)]['id'],
        'user_id' => $users[array_rand($users)]['id'],
    ]);
}