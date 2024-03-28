<?php
session_start();
if(!isset($_SESSION['email'])){
	header('Location: login.php');
}

include 'Config/Database.php';

$users = 'SELECT * FROM user WHERE email = :email'; 
$stmt = $conn->prepare($users); 
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['update']) && $_GET['update'] === 'update') {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];


    if (!empty($email) && !empty($pseudo) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET email = :email, pseudo = :pseudo, password = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'pseudo' => $pseudo,
            'password' => $hashed_password,
			'id' => $id,
        ]);
        header("Location: account.php");
        exit();
    } else {
        echo "Veuillez remplir tous les champs";
    }
}
if (isset($_GET['method']) && $_GET['method'] === 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id = :id";
    $toto = $conn->prepare($sql);
    $toto->bindParam(':id', $id);
    $toto->execute();
    $user = $toto->fetch(PDO::FETCH_ASSOC);
}

$categories = ["cinéma", "séries", "gaming", "musique", "livres", "évenements"];

foreach($categories as $category) {
	$sql = "SELECT article.title, article.cover, article.description, article.created_at  
			FROM article
			INNER JOIN categories  
				ON article.categories_id = categories.id 
			WHERE categories.title = '$category'
			ORDER BY article.id DESC
			Limit 6
			";
	// one for each categories
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$$category = $stmt;
}

	$cat = $picturePaths = [];
	for ($idCategorie = 19; $idCategorie <= 24; $idCategorie++) {
		$cat = "SELECT picture FROM categories WHERE id = :id";
		$cate = $conn->prepare($cat);
		$cate->execute([':id' => $idCategorie]);
		$image = $cate->fetch(PDO::FETCH_ASSOC);
		$picturePaths[$idCategorie] = $image['picture'];
	}
	for ($idReview = 11; $idReview <= 70; $idReview++) {
	$rev = "SELECT * FROM review WHERE id = :id";
	$review = $conn->prepare($rev);
	$review->execute([':id' => $idReview]);
	$reviews = $review->fetch(PDO::FETCH_ASSOC);
	$description[$idReview] = $reviews['description'];
	$note[$idReview] = $reviews['note'];
	}
	
	$userId = 1; 
	$stmt = $conn->prepare("SELECT COUNT(*) AS total_reviews FROM review WHERE user_id = :userId");
	$stmt->execute([':userId' => $userId]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalReviews = $result ? $result['total_reviews'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
	<?php include ('_partials/head.php') ?>
	<body>
		<?php include ('_partials/header.php') ?>
		<main>
			<div>
				<div class="row" id="banner">
					<article class="col-12 col-md-12">
						<img alt="banière" class="position-absolute marginneg" width="100%" height="400px" src="./assets/image/covers/<?= $user['banner'] ?>">
					</article>
					<article>
						<h2 class="position-absolute pseudo titre3 py-2 "><?=substr($user['pseudo'], 0, 10)?></h2>
						<img alt="Avatar" class="rounded-circle position-relative tp start-0 translate-middle ms-5" width="90px" height="90px" src="./assets/image/covers/<?= $user['picture'] ?>" >
					</article>
				</div>			
			</div>
			<!--the table with the information-->
			<div class="row mart" id="table">
				<div class="col-12 px-0">
					<table class="table table-striped-columns table-dark table-bordered mb-0">
						<tbody>
							<tr>
								<td scope="row" style="background-color:#413A3A">Membre depuis :</td>
								<td class="text-center" style="background-color:#252323"><?= date_diff(date_create($user['created_at']), date_create('today'))->y ?> Ans</td>
							</tr>
							<tr>
								<td scope="row" style="background-color:#413A3A">Avis posté(s) :</td>
								<td class="text-center" style="background-color:#252323"><?= $totalReviews ?></td>
							</tr>
							<tr>
								<td scope="row" style="background-color:#413A3A">Dernière connexion :</td>
								<td class="text-center" style="background-color:#252323">Dernière connexion il y a une semaine</td>
							</tr>
							<tr>
								<td scope="row" style="background-color:#413A3A">Genre :</td>
								<td class="text-center" style="background-color:#252323"><?= $user['gender'] ?></td>
							</tr>
							<tr>
								<td scope="row" style="background-color:#413A3A">Age :</td>
								<td class="text-center" style="background-color:#252323"><?= date_diff(date_create($user['birth_date']), date_create('today'))->y ?> Ans</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- Recently viewed -->
			<div>
				<h2 class="text-uppercase gras text-center py-3 titre mb-5 ">récemment vus</h2>
			</div>
			<!-- Recently viewed articles -->
			<div class="container-fluid">
				<div class="row">
					<!-- The first big article-->
					<div class="col-md-3 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<section>
								<article>
									<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[19] ?>"  alt="exorsiste" class="img-fluid">
									<div class="centered-text">
										<p class="titre3">L'exorsiste</p></a>
									</div>
								</article>
							</section>
						</div>
					</div>
					<div class="col-12 col-md-9 my-auto">
						<div class="row">
							<?php while($row = $cinéma->fetch(PDO::FETCH_ASSOC)): ?>
									<div class="col-12 col-lg-6">
										<div class="row">
											<article class="col-6 col-lg-6">
												<img class="img-fluid mt-3 rounded-5"
													src="./assets/image/covers/<?= $row['cover'] ?>" alt="Image de l'article"
													width="100%" height="100%">
											</article>
											<article class="col-6 col-lg-6 mt-3">
												<h3 class="align-baseline text-capitalize"><strong><?= substr($row['title'], 0, 30) ?></strong></h3>
												<p class="overflow-scroll">
												<?= substr($row['description'], 0, 100) ?></p>
											</article>
										</div>
									</div>
							<?php endwhile; ?>
						</div>
					</div>        	
				</div>
			</div>
			<!-- see more -->
			<div class="row">
				<div class="col-12 justify-content-center">
					<a href="" class="text-center"><p class="text-center">Voir plus</a></p>
				</div>
			</div>
				<!-- Favorite -->
			<div>
				<h2 class="text-uppercase gras text-center py-3 titre mb-5">favoris</h2>
			</div>
			<!-- 6 first articles -->
			<div class="container-fluid">
			<div class="col-12 col-md-9 my-auto">
						<div class="row">
							<?php while($row = $séries->fetch(PDO::FETCH_ASSOC)): ?>
									<div class="col-12 col-lg-4">
										<div class="row">
											<article class="col-6 col-lg-6">
												<img class="img-fluid mt-3 rounded-5"
													src="./assets/image/covers/<?= $row['cover'] ?>" alt="Image de l'article"
													width="100%" height="100%">
											</article>
											<article class="col-6 col-lg-6 ">
												<h3 class="align-baseline text-capitalize"><strong><?= substr($row['title'], 0, 30) ?></strong></h3>
												<p class="overflow-scroll">
												<?= substr($row['description'], 0, 100) ?></p>
											</article>
										</div>
									</div>
							<?php endwhile; ?>
						</div>
					</div>        	
			<!-- 6 inline articles -->
			<div class="container-fluid">
			<div class="col-12 col-md-9 my-auto">
						<div class="row">
							<?php while($row = $livres->fetch(PDO::FETCH_ASSOC)): ?>
									<div class="col-12 col-lg-2">
										<div class="row">
											<article class="col-12 col-lg-12">
												<img class="img-fluid mt-3 rounded-5"
													src="./assets/image/covers/<?= $row['cover'] ?>" alt="Image de l'article"
													width="100%" height="100%">
											</article>
										</div>
									</div>
							<?php endwhile; ?>
						</div>
					</div>   
			<!-- See more -->
			<div class="row">
				<div class="col-12 justify-content-center">
					<a href="" class="text-center"><p class="text-center">Voir plus</a></p>
				</div>
			</div>
			<!-- Categories -->
			<div>
				<h2 class="text-uppercase gras text-center py-3 titre ">centres d'interêts</h2>
			</div>
			<!-- Categorie 1 -->
			<div class="container-fluid">
				<div class="row mx-lg-auto" style="max-width: 1510px; max-height: 1310px;">
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[19] ?>"  class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Gaming - Aventure</p></a>
							</div>
						</div>
					</div>
					<!-- Categorie 2 -->
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[20] ?>" alt="horreur" class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Film - Horreur</p></a>
							</div>
						</div>
					</div>
					<!-- Categorie 3 -->
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[21] ?>"  alt="Thriller" class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Livre - Thriller</p></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Categorie 4 -->
			<div class="container-fluid">
				<div class="row mx-lg-auto" style="max-width: 1510px; max-height: 1310px;">
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[22] ?>"  alt="Sience-fiction" class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Film - Sience Fiction</p></a>
							</div>
						</div>
					</div>
					<!-- Categorie 5 -->
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[23] ?>"  alt="Survie" class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Gaming - Survie</p></a>
							</div>
						</div>
					</div>
					<!-- Categorie 6 -->
					<div class="col-md-4 d-flex align-items-center justify-content-center">
						<div class="image-container">
							<a href="" class="lienb"><img src="./assets/image/covers/<?= $picturePaths[24] ?>"  alt="Musique" class="img-fluid">
							<div class="centered-text">
								<p class="titre3">Musique - Rap</p></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- See more -->
			<div class="row">
				<div class="col-12 justify-content-center">
					<a href="" class="text-center"><p class="text-center">Voir plus</a></p>
				</div>
			</div>
			<!-- Title for review -->
			<div>
				<h2 class="text-uppercase gras text-center py-3 titre">derniers messages</h2>
			</div>
			<!-- Review 1 -->
			<div class="row justify-content-center">
				<div class="col-11 col-md-3 my-3 me-md-5">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[11] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['11'], 0, 90) ?></p>
						</div>
					</div>
				</div>
				<!-- Review 2 -->
				<div class="col-11 col-md-3 my-3 me-md-5">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[12] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['12'], 0, 90) ?></p>
						</div>
					</div>
				</div>
				<!-- Review 3 -->
				<div class="col-11 col-md-3 my-3">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[13] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['13'], 0, 90) ?></p>
						</div>
					</div>
				</div>
			</div>
			<!-- Review 4 -->
			<div class="row justify-content-center">
				<div class="col-11 col-md-3  my-3 me-md-5">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[14] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['14'], 0, 90) ?></p>
						</div>
					</div>
				</div>
				<!-- Review 5 -->
				<div class="col-11 col-md-3 my-3 me-md-5">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[15] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['15'], 0, 90) ?></p>
						</div>
					</div>
				</div>
				<!-- Review 6 -->
				<div class="col-11 col-md-3 my-3">
					<div class="card">
						<div class="card-body">
							<img alt="Avatar" width="80px" height="80px" class="rounded-circle" src="./assets/image/covers/<?= $user['picture'] ?>"> <span class="badge bg-primary mare"><?= $note[16] ?></span>
							<h5 class="card-title"><?=$user['pseudo']?></h5>
							<p class="text-center"><?= substr($description['16'], 0, 90) ?></p>
						</div>
					</div>
				</div>
			</div>
			<!-- See More -->
			<div class="row">
				<div class="col-12 justify-content-center">
					<a href="" class="text-center"><p class="text-center">Voir plus</p></a>
				</div>
			</div>
			<!-- Account management title-->
			<div>
				<h2 class="text-uppercase gras text-center py-3 titre">gestion compte</h2>
			</div>
			<!-- Form for account management-->
			<form method="POST" action="?update=update">
				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				<div class="pt-4 px-14">
					<p class="ps-1">Votre Pseudo :</p>
					<div class="input-group mb-3">
						<input class="form-control" type="text" name="pseudo" value="<?= $user['pseudo'] ?>">
					</div>
				</div>
				<div class="pt-3 px-14">
					<p class="ps-1">Votre Email :</p>
					<div class="input-group">
						<input class="form-control" type="text" name="email" value="<?= $user['email'] ?>">
					</div>
				</div>
				<div class="pt-3 px-14">
					<p class="ps-1">Mot de passe :</p>
					<div class="input-group">
						<input class="form-control" type="password" name="password" value="" required>
					</div>
					<p class="thin">Votre mot de passe doit contenir : 8 à 72 caractères<br>
						1 chiffre<br>
						1 caractère spécial<br>
						1 majuscule</p>
					</div>
					<!-- Confirm -->
				<div class="text-center py-5">
					<button class="btn" id="confirmer" type="submit">Confirmer</button>
				</div>
			</form>
			</div>
			<!-- Up Page -->
			<div class="limit text-center pb-5">
				<a href="#" class=""><img src="./assets/image/series/UP.svg" alt="Go up" class=""></a>
			</div>
		</main>
		<?php include ('_partials/footer.php') ?>
	</body>
</html>