<?php
include '../Config/database.php';
require_once '../vendor/autoload.php';

$faker = Faker\Factory::create();

// insérer 10 informations complémentaire dans informations_complementaires
for ($i = 0; $i < 10; $i++) {
    $sql = "INSERT INTO informations_complementaires (`name`,`description`) VALUES ( :name, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'name' => $faker->name(),
        'description' => json_encode($faker->text())
    ]);
}

