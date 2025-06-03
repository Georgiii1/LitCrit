<?php
if (isset($_POST['signUp'])) {

    // записване на данните от полетата в променливи за по-удобно
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // зареждаме качената снимка, ако има такава
    $profilePic = isset($_FILES['profilePicture']) ? $_FILES['profilePicture'] : null;
    $profilePic_name = $profilePic && !empty($profilePic['name']) ? $profilePic['name'] : '';
    $profilePic_temp = $profilePic && !empty($profilePic['tmp_name']) ? $profilePic['tmp_name'] : '';
    $profilePic_type = $profilePic && !empty($profilePic['type']) ? $profilePic['type'] : '';

    // Default profile picture filename
    $defaultPic = "default-profile-picture.png";
    $uploadDir = "images/usersPfp/";

    if (!empty($profilePic_name)) {
        if ($profilePic_type != "image/jpeg" && $profilePic_type != "image/png" && $profilePic_type != "image/jpg") {
            echo "Прикачете снимка във формат jpeg или png<br><br>";
            exit;
        } else {
            // Save the uploaded file in the images folder
            move_uploaded_file($profilePic_temp, $uploadDir . $profilePic_name);
            $finalPic = $profilePic_name;
        }
    } else {
        // No file uploaded, use default
        $finalPic = $defaultPic;
    }

    // INSERT заявка към базата, с която се записват полетата
    $sql = "INSERT INTO User (username, email, passwordHashed, profilePicture) VALUES (?,?,?,?)";
    $sth = $connection->prepare($sql);

    try {
        $sth->execute([$username, $email, $password, $finalPic]);
        echo "Профилът беше създаден успешно!";
    } catch (PDOException $e) {
        echo "Грешка при създаване на профила: " . $e->getMessage();
    }

}

if (isset($_POST['logIn'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT * FROM User WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["passwordHashed"])) {
        $_SESSION['user'] = $user; 
        header("Location: account.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>


<div id="loginPopup" class="popup">
    <div class="popup-content">

        <span class="close-btn" onclick="togglePopup()">&times;</span>

        <!-- SIGNUP FORM BEGIN -->
        <form id="signupForm" class="signup-form" method="post" enctype="multipart/form-data">

            <div class="pfp-image-upload profile-picture profile-picture-signup">
                <input type="file" id="imageUpload" name="profilePicture" accept="image/*" hidden>
                <label for="imageUpload" class="image-drop-area">
                    <img id="previewImage" class="edit-image" src="images/usersPfp/default-edit-profile-picture.png"
                        alt="Профилна снимка">
                </label>
            </div>

            <div class="form-group">
                <label for="username">Потребителско име:</label>
                <input type="text" id="username" name="username" placeholder="Въвеждане..">
            </div>

            <div class="form-group">
                <label for="email">Имейл:</label>
                <input type="email" id="email" name="email" placeholder="Въвеждане..">
            </div>

            <div class="form-group">
                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" placeholder="Въвеждане..">
            </div>

            <div class="form-group">
                <label for="password-2">Потвърждение на парола:</label>
                <input type="password" id="password-2" name="password" placeholder="Въвеждане..">
            </div>

            <button type="submit" name="signUp" class="btn-forms">Регистрация</button>

            <div class="link-container">
                <a href="javascript:void(0)" class="change-form-btn" onclick="toggleForms()">Вече имате профил?</a>
            </div>
        </form>
        <!-- SIGNUP FORM END -->



        <!-- LOGIN FORM BEGIN -->
        <form id="loginForm" method="post" style="display: none;" class="login-form">


            <div class="form-group">
                <label for="username">Потребителско име:</label>
                <input type="text" id="username" name="username" placeholder="Въвеждане..">
            </div>

            <div class="form-group">
                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" placeholder="Въвеждане..">
            </div>

            <button type="submit" name="logIn" class="btn-forms">Вход</button>

            <div class="link-container">
                <a href="javascript:void(0)" class="change-form-btn" onclick="toggleForms()">Нямате профил?</a>
            </div>
        </form>
        <!-- LOGIN FORM END -->

    </div>
</div>



<script>
    function togglePopup() {
        const popup = document.getElementById('loginPopup');
        popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
    }

    function toggleForms() {
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');


        loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
        signupForm.style.display = signupForm.style.display === 'none' ? 'block' : 'none';
    }
</script>



<!-- onclick="togglePopup()" -->