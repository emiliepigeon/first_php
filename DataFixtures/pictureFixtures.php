<?php
include '../Config/database.php';
require_once '../vendor/autoload.php';

$faker = Faker\Factory::create();

// insert ten users into the database
for ($i = 0; $i < 10; $i++ ) {
    $sql = "INSERT INTO informations_complementaires (name, description) 
    VALUES(:name, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'name' => $faker->name(),
        'description' => json_encode($faker->text())
    ]);
}

$article = "SELECT id FROM article";
$articleStatement = $conn->prepare($article);
$articleStatement->execute();
$articles = $articleStatement->fetchAll();

$faker = Faker\Factory::create();


// insérer dix pictures dans la base de données
for ($i = 0; $i < 10; $i++) {
    $sql = "INSERT INTO picture (name, alt, position, article_id) 
            VALUES(:name, :alt, :position, :article_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'name' => $faker->name(),
        'alt' => $faker->name(),
        'position' =>$faker->randomDigit(),
        'article_id' => $articles[array_rand($articles)]['id']
    ]);
}