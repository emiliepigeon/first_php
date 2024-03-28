<?php
    include 'Config/Database.php';

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
	} $cat = $picturePaths = [];

	for ($idCategorie = 1; $idCategorie <= 6; $idCategorie++) {
		$cat = "SELECT picture FROM categories WHERE id = :id";
		$cate = $conn->prepare($cat);
		$cate->execute([':id' => $idCategorie]);
		$image = $cate->fetch(PDO::FETCH_ASSOC);
		$picturePaths[$idCategorie] = $image['picture'];
    }

?>
<!DOCTYPE html>
<html lang="en">
    <?php include '_partials/head.php'; ?>
<body>
    <?php include '_partials/header.php'; ?>   
    <main>
        <!--Slider-->
        <div class="row" id="banner">
            <div class="col-12">
                <img src="./assets/image/accueil/slide-acceuil.jpg" alt="slider" width="100.5%" height="305px"
                    class="img-fluid slider mt-3">
                <!--<h1 class="slide text-center">Actuellement</h1>-->
            </div>
        </div>
        <!--Hook of the web site HOME PAGE-->
        <div>
            <h1 class="hookhp text-uppercase text-center py-3 mb-1 "><strong>distinguer le remarquable du banal!</strong></h1>
        </div>
        <a href="movies.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2"><strong>cinéma</strong></h2></a>
        <div class="container-fluid">
            <!--Category 1 title-->
            <section class="col-12">
                <div class="row">
                    <!--MOVIE-->
                    <article class="col-4">
                        <a href="movies.php"><img class="gdhp rounded-5 mt-5 mx-3" src="./assets/image/covers/<?= $picturePaths[1] ?>" alt="image catégorie cinéma home page" 
                            width="453" height="490"></a>
                    </article>
                    <!--Movie section 1 to 6-->
                    <div class="col-8 pt-3">
                        <div class="row">
                            <?php while($row = $cinéma->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article cinéma home page"
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6 mt-3">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30) ?></strong></h3>
                                        <p class="tphp text-truncate">
                                        
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <a href="series.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2 mt-3"><strong>séries</strong></h2></a>
        <div class="container-fluid">
            <!--Category 2 title-->
            <section class="col-12">
                <div class="row">
                    <!--SERIES-->
                    <div class="col-sm-8 pt-3">
                        <div class="row">
                            <!--Serie section 1 to 6-->
                            <?php while($row = $séries->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">                         
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article séries home page" 
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6 mt-4">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30) ?></strong></h3>
                                        <p class="tphp text-truncate">
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                         </div>
                    </div>     
                <div class="col-4">
                    <div class="row">
                        <article class="col-12">
                            <a href="series.php"><img class="gdhp rounded-5 mt-5 mx-3" src="./assets/image/covers/<?= $picturePaths[2] ?>" alt="image catégorie série home page" 
                                width="453" height="490"></a>
                        </article>
                    </div>
                </div>
             </section>
        </div>
        <a href="videogame.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2 mt-3"><strong>gaming</strong></h2></a>
        <div class="container-fluid">
            <!--Category 3 title-->
            <section class="col-12">
                <div class="row">
                    <!--GAMING page not developed-->
                    <article class="col-4">
                        <a href="videogame.php"><img class="gdhp rounded-5 mt-5 mx-3" src="./assets/image/covers/<?= $picturePaths[3] ?>" alt="image catégorie gaming home page" 
                            width="453" height="490"></a>
                    </article>
                    <div class="col-8">
                        <div class="row">
                            <!--Gaming section 1 to 6-->
                            <?php while($row = $gaming->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article gaming home page" 
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6 mt-3">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30)?></strong></h3>
                                        <p class="tphp text-truncate">
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <a href="music.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2 mt-3"><strong>musique</strong></h2></a>
        <div class="container-fluid">
            <!--Category 4 title-->
            <section class="col-12">
                <div class="row">
                    <!--MUSIC page not developed-->
               <div class="col-sm-8">
                        <div class="row">
                            <!--Music section 1 to 6-->
                            <?php while($row = $musique->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article musique home page" 
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6 mt-4">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30)?></strong></h3>
                                        <p class="tphp text-truncate">
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                         </div>
                    </div>     
                <div class="col-4">
                    <div class="row">
                        <article class="col-12">
                            <a href="music.php"><img class="gdhp mt-5 rounded-5 mx-3" src="./assets/image/covers/<?= $picturePaths[4] ?>" alt="image catégorie musique home page" 
                                width="453" height="490"></a>
                        </article>
                    </div>
                </div>
             </section>
        </div>
        <a href="book.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2 mt-3"><strong>livres</strong></h2></a>
        <div class="container-fluid">
            <!--Category 5 title-->
            <section class="col-12">
                <div class="row">
                    <!--BOOK page not developed-->
                    <article class="col-4">
                        <a href="book.php"><img class="gdhp mt-5 rounded-5 mx-3" src="./assets/image/covers/<?= $picturePaths[5] ?>" alt="image catégorie livres home page" 
                            width="453" height="490"></a>
                    </article>
                    <div class="col-8">
                        <div class="row">
                            <!--Book section 1 to 6--->
                            <?php while($row = $livres->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article livres home page" 
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6  mt-4">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30)?></strong></h3>
                                        <p class="tphp text-truncate">
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <a href="evenement.php" class="liencat"><h2 class="stcategoryhp text-uppercase text-center py-2 mt-3"><strong>événements</strong></h2></a>
        <div class="container-fluid">
            <!--Category 6: title-->
            <section class="col-12">
                <div class="row">
                    <!--EVENTS-->
                    <div class="col-sm-8">
                        <div class="row">
                            <!--Event section 1-->
                            <?php while($row = $évenements->fetch(PDO::FETCH_ASSOC)): ?>
                            <div class="col-6">
                                <div class="row">
                                    <article class="col-4 col-lg-6 ">
                                        <a href=""><img class="artimg rounded-5 mt-3"
                                            src="./assets/image/covers/<?= $row['cover'] ?>" alt="image article évènements home page" 
                                            width="192" height="127"></a>
                                    </article>
                                    <article class="col-4 col-lg-6 mt-3">
                                        <h3 class="tarticlehp align-baseline text-truncate"><strong><?= substr($row['title'], 0, 30)?></strong></h3>
                                        <p class="tphp text-truncate">
                                        <?= substr($row['description'], 0, 100) ?></p>
                                        <p class="ppub">Publié le: <timer><?= $row['created_at'] ?></timer>
                                    </article>
                                </div>
                            </div>
                            <?php endwhile; ?>
                         </div>
                    </div> 
                <div class="col-4">
                    <div class="row">
                        <article class="col-12">
                        <a href="evenement.php"><img class="gdhp mt-5 rounded-5 mx-3" src="./assets/image/covers/<?= $picturePaths[6] ?>" alt="image catégorie évènementq home page" 
                            width="453" height="490"></a>
                        </article>
                    </div>
                </div>
             </section>
        </div>
        <!--arrow go top page-->
        <div class="limit text-center pb-5">
            <a href="#"><img src="./assets/image/accueil/fleche-toppage.svg" alt="fleche retour haut de la page accueil"></a>
        </div>
    </main>
    <?php include '_partials/footer.php'; ?>
</body>
</html>