<script>
    function confirmDelete(event) {
        if (!confirm('Сигурни ли сте, че искате да изтриете този отзив?')) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>

<form method="post" action="" onsubmit="return confirmDelete(event);">
    <input type="hidden" name="review_id" value="<?= $rev["reviewID"]; ?>">
    <div class="dots-menu">
        <button type="button" class="dots-button">&#x22EE;</button>
        <div class="dropdown-options">
            <button type="submit" name="edit" value="edit" class="dropdown-option">Редактирай</button>
            <button type="submit" name="delete" value="delete" class="dropdown-option">Изтрий</button>
        </div>
    </div>
</form>


<?php
if (!function_exists('deleteReview')) {
    function deleteReview($reviewId)
    {
        global $connection;
        $stmt = $connection->prepare("DELETE FROM Reviews WHERE reviewID = ?");
        $stmt->execute([$reviewId]);
    }
}

if (isset($_POST['delete'])){
    deleteReview(intval($_POST['reviewID']));
    echo "<script>alert('Отзивът беше изтрит успешно!'); window.location.reload();</script>";
}
?>