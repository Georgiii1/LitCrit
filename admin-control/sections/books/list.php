<?php 
include("../../includes.php"); 
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
    echo "<script>alert('Нямате достъп до съдържанието на страницата!'); window.location.href = '../../index.php';</script>";
    exit;
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Books</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">

</head>
<body>


<?php include "../../includes/header.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $connection->prepare("SELECT b.bookID, b.bookTitle, b.bookAuthor, b.yearOfPublishing, g.bookGenre AS bookGenre, b.dateAdded, b.status FROM Books AS b INNER JOIN genre AS g ON b.bookGenre = g.genreID");
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo json_encode(["error" => "Failed to fetch books: " . $e->getMessage()]);
        exit;
    }
}
?>

<h1>Книги</h1>
<div class="table-wrapper"></div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Заглавие</th>
            <th>Автор</th>
            <th>Година на издаване</th>
            <th>Жанр</th>
            <th>Дата на добавяне</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo htmlspecialchars($book['bookID']); ?></td>
                    <td><?php echo htmlspecialchars($book['bookTitle']); ?></td>
                    <td><?php echo htmlspecialchars($book['bookAuthor']); ?></td>
                    <td><?php echo htmlspecialchars($book['yearOfPublishing']); ?></td>
                    <td><?php echo htmlspecialchars($book['bookGenre']); ?></td>
                    <td><?php echo htmlspecialchars($book['dateAdded']); ?></td>
                    <td>
                        <?php
                        $status = strtolower($book['status']);
                        $statusClass = 'status-badge ';
                        if ($status === 'approved') {
                            $statusClass .= 'status-approved';
                        } elseif ($status === 'declined') {
                            $statusClass .= 'status-declined';
                        } elseif ($status === 'pending') {
                            $statusClass .= 'status-pending';
                        } else {
                            $statusClass .= 'status-pending';
                        }
                        ?>
                        <span class="<?php echo $statusClass; ?>">
                            <?php echo ucfirst($status); ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit-book.php?bookID=<?php echo urlencode($book['bookID']); ?>" class="edit-icon" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a style="color:red; margin: 5px;" href="delete.php?bookID=<?php echo urlencode($book['bookID']); ?>" class="edit-icon" title="delete">
                        <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No books found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
