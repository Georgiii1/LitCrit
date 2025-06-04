<form method="post" action="" onsubmit="return confirmDelete(event);">
    <input type="hidden" name="review_id" value="<?= $rev["bookReviewID"]; ?>">
    <div class="dots-menu">
        <button type="button" class="dots-button">&#x22EE;</button>
        <div class="dropdown-options">
            <button type="submit" name="edit" value="edit" class="dropdown-option">Редактирай</button>
            <button type="submit" name="delete" value="delete" class="dropdown-option">Изтрий</button>
        </div>
    </div>
</form>

<?php 
function deleteReview($reviewId) {
    global $connection;
    print_r($connection);
    $stmt = $connection->prepare("DELETE FROM Reviews WHERE ReviewID = ?");
    $stmt->execute([$reviewId]);
}

if (isset($_POST['delete'])){
        echo "<script>
            if (confirm('Сигурни ли сте, че искате да изтриете този отзив?')) {
                window.location.href = 'delete-review.php?review_id=" . intval($_POST['review_id']) . "';
            }
        </script>";
}

?>