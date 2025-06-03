<?php
// include("./admin-control/includes.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛитКрит - Най-популярни</title>
    <link rel="icon" href="pictures/logo-ico.ico" type="image/x-icon">

</head>


<body>
    <div class="container-fluid">

        <?php include("./elements/header.php") ?>

        <?php
        $data = $connection->query("
        SELECT b.*, g.bookGenre 
        FROM Books b 
        JOIN genre g ON b.bookGenre = g.genreID")->fetchAll();

        $category = $_GET['category'];

        function defineCategory($categoryToDefine)
        {
            switch ($categoryToDefine) {
                case 'popular':
                    return "Най-популярни";
                case 'suggested':
                    return "Препоръчани за Вас";
                case 'new':
                    return "Нови заглавия";
            }
        }
        ?>

        <h2 class="page-category-title"><?php echo defineCategory($category); ?></h2>
        <?php
        defineCategory($category);
        ?>

        <div class="row book-row">
            <?php foreach($data as $el){ ?>
            <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
            </div>
            <?php } ?>

            <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
            </div>

            <div class="col-xl-4 col-sm-6 col-12">
                <?php include("./elements/book-card.php") ?>
            </div>
        </div>


        <?php include("./elements/footer.php") ?>

    </div>

</body>

</html>