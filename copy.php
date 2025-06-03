<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Моят Профил</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>

    <div class="container-fluid">

        <?php include("./elements/header.php");


        // print_r( $_SESSION['user'] );
        
        $userId = $_SESSION['user']['userID'];
        $stmt = $connection->prepare("Select * from User where userID = ? ");

        $stmt->execute([$userId]);
        $user = $stmt->fetch();


        ?>

        <!-- Section : Profile -->
        <div class="row my-profile" id="section-profile">

            <div class="col-xl-10 col-sm-12 user-info-col">
                <div class="container container-info">
                    <div class="user-info">
                        <h3 class="user-info-title">Потребителско име: </h3>
                        <h3 class="user-data"><?= $user['username'] ?></h3>
                        <br>
                        <h3 class="user-info-title">Имейл: </h3>
                        <h3 class="user-data"><?= $user['email'] ?></h3>
                        <br>
                    </div>


                    <div class="container">
                        <div class="button-group button-group2">
                            <div class="genre-button">Романтика</div>
                            <div class="genre-button">Комедия</div>
                            <div class="genre-button">Поезия</div>
                            <div class="genre-button">Фантастика</div>
                        </div>
                        <input type="hidden" name="selectedGenres" id="selectedGenres" />
                    </div>

                </div>


                <div class="col-xl-2 col-sm-12 profile-picture">
                    <img src="images/usersPfp/<?= $user['profilePicture'] ?>" alt="Профилна снимка">

                    <div class="edit-btn-container">
                        <a class="edit-profile-btn" href="account-edit-profile.php">Редактирай</a>
                    </div>

                </div>
            </div>

        </div>


        <!-- Section : My Reviews -->
        <div class="row my-reviews" id="section-my-reviews">
            <div class="col-xl-12">

                <h2 class="categories-h">Моите отзиви</h2>


                <?php

                $stmt = $connection->prepare("SELECT r.*, u.* FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.userID = ? LIMIT 3");
                $stmt->execute([$userId]);
                $reviews = $stmt->fetchAll();
                ?>

                <div class="container reviews-container">
                    <?php foreach ($reviews as $rev) { ?>
                        <div class="row book-row">
                            <div class="col-12">
                                <?php include "./elements/review-card.php"; ?>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="row view-more-row">
                        <div class="col-xl-12">
                            <a href="my-reviews.php">
                                <button class="view-all-btn">ВИЖ ВСИЧКИ</button>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

            <br>
            <br>
            <br> 

        <!-- Section : My Boooks -->
        <div class="row my-books" id="section-my-books">
            <div class="col-xl-12">

                <h2 class="categories-h">Моите книги</h2>

                <?php
                $stmt = $connection->prepare("SELECT b.*, g.bookGenre FROM Books b JOIN genre g ON b.bookGenre = g.genreID WHERE b.userID = ?");
                $stmt->execute([$userId]);
                $data = $stmt->fetchAll();
                ?>

                <div class="row custom-row">
                    <?php foreach ($data as $el) { ?>
                        <div class="col-xl-4 col-sm-6 col-12">
                            <?php include("./elements/book-card.php") ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="row view-more-row">
                    <div class="col-xl-12">
                        <a href="my-books.php">
                            <button class="view-all-btn">ВИЖ ВСИЧКИ</button>
                        </a>
                    </div>
                </div>

            </div>

            <br>
            <br>
            <br>
        </div>

        <?php include("./elements/footer.php") ?>



        </div>

</body>

</html>


elseif (isset($category) && $category == 'popular') {
            $data = $connection->query("
            SELECT b.*, g.bookGenre 
            FROM Books b 
            JOIN genre g ON b.bookGenre = g.genreID
            ORDER BY b.rating DESC LIMIT 6")->fetchAll();
        } elseif (isset($category) && $category == 'suggested') {
            // For now, we will just use the same data as popular
            $data = $connection->query("
            SELECT b.*, g.bookGenre 
            FROM Books b 
            JOIN genre g ON b.bookGenre = g.genreID
            ORDER BY b.rating DESC LIMIT 6")->fetchAll();
        } else {
            // Default case if no category is set
            $data = [];
        }