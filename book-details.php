<?php include("./database/connection.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - ЗАГЛАВИЕ</title> <!-- !!! -->
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>

    <div class="container-fluid">

        <?php include("./elements/header.php");
        $bookID = $_GET['id'];


        $stmt = $connection->prepare("Select b.*, g.bookGenre from Books b JOIN genre g on b.bookGenre = g.genreID
        WHERE bookID = ? ");


        $stmt->execute([$bookID]);
        $book = $stmt->fetch();


        ?>

        <div class="container py-5">
            <div class="row align-items-center">

                <!-- Left: Book Cover -->
                <div class="col-4 cover-details">
                    <img src="<?= $book["bookCover"]; ?>" alt="cover" class="img-fluid details-cover-img">
                </div>

                <div class="col-1 empty-col"></div>

                <!-- Right: Text Details -->
                <div class="col-7 text-details">
                    <h2 class="title-detail"><?= $book["bookTitle"]; ?></h2>
                    <br>
                    <p class="other-detail"><strong class="detail-title">Автор: </strong><?= $book["bookAuthor"]; ?></p>
                    <p class="other-detail"><strong class="detail-title">Година:
                        </strong><?= $book["yearOfPublishing"]; ?></p>
                    <p class="other-detail"><strong class="detail-title">Жанр: </strong><?= $book["bookGenre"]; ?></p>
                    <p class="other-detail"><strong class="detail-title">Анотация: </strong>
                        <?= $book["bookAnnotation"]; ?></p>

                    <p class="other-detail">
                    <div class="rating">
                        <p class="other-detail"> <strong class="detail-title">Оценка: </strong></p>
                        <!-- като число ?? -->
                        <div class="stars-landing" id="stars-box" style="--rating: 4;">⭐⭐⭐⭐⭐</div>
                    </div>
                    </p>

                </div>
            </div>
        </div>


        <!-- Input Review -->
        <?php
        // Review form validation
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            if (isset($_SESSION['user']['userID'])) {
                $userID = $_SESSION['user']['userID'];
            } else {
                die("Error: You must be logged in to submit a review.");
            }

            $bookTitle = $book["bookTitle"];

            $sql = "INSERT INTO Reviews (title, review, bookReviewID, userID, dateAdded) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
            $sth = $connection->prepare($sql);
            $sth->execute([$bookTitle, $_POST['review'], $bookID, $userID]);
        }

        $tooltip = 'title="За да добавите коментар, трябва да влезете в профила си." data-bs-custom-class="custom-tooltip warrning-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom"';

        ?>

        <div class="tooltip" id="tooltip-template" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>


        <form method="POST" action="" <?php if (!isset( $_SESSION['user'] ) ) { ?> onsubmit="return false;" <?php } ?>>
            <div class="container-rev-input">
                <div class="card review-card input-review <?php if (!isset( $_SESSION['user'] ) ) { echo "not-logged-in"; } ?>">
                    <?php ?>
                    <div class="card-header info">
                        <p><strong class="rev-card-data">Потребителско име: </strong>
                            <?= $username = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : "Гост" ?>
                        </p>
                        <p><strong class="rev-card-data">Дата: </strong><?php echo date('d-m-Y'); ?></p>
                    </div>

                    <div class="card-body">

                        <p class="rating">

                            <div class="rating rev-rating">
                            <h5 class="rating-txt rev-card-data rating-rev"> <strong>Оценка:</strong> </h5>
                            <div class="stars-landing" id="stars-box" style="--rating: 3;">⭐⭐⭐⭐⭐</div>
                        </div>

                            <?php
                            //include("./elements/rating/index.html");
                            ?>

                        </p>

                        <div class="form-group">
                            <label for="review-text" class="rev-card-data">Отзив:</label>
                            <textarea name="review" class="form-control text-input" id="review-text" rows="4"
                                placeholder="Въвеждане.." <?php if (!isset($_SESSION['user'])) echo $tooltip; ?> required></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn open-review-btn" <?php if (!isset($_SESSION['user'])) echo $tooltip; ?>  >Публикувай</button>
                    </div>
                </div>
            </div>
        </form>


        <!-- Section : Reviews -->
        <div class="row book-reviews">
            <div class="col-xl-12">

                <h2 class="categories-h">Отзиви</h2>

                <div class="reviews-container">
                    <?php

                    $stmt = $connection->prepare("SELECT r.*, u.username FROM Reviews r JOIN User u ON r.userID = u.userID WHERE r.bookReviewID = ? AND r.status = 'approved' order by r.dateAdded DESC");
                    $stmt->execute([$bookID]);
                    $reviews = $stmt->fetchAll();
                
                    foreach ($reviews as $rev) {
                        ?>
                        <!-- review -->
                        <?php include("./elements/review-card.php") ?>
                    <?php } ?>
                    <?php 
                    if(empty($reviews)){
                        echo "<h3 style='text-align: center;'>Все още няма отзиви за тази книга.</h3>";
                    }
                    ?>
                </div>

            </div>
        </div>


        <?php include("./elements/footer.php") ?>

    </div>

</body>

</html>