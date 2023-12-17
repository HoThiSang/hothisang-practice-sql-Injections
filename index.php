<?php
require_once 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new PDO("mysql:host=localhost;dbname=Practice_security", "root", "");
    $query = "SELECT username, password, credit_card_number FROM userdata WHERE username=:username";
    $statement = $db->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();
    $list_users = $statement->fetch(PDO::FETCH_ASSOC);
 
    if ($list_users) {
        if ($password===$list_users['password']) {
            echo '<div class="card m-3">
                    <div class="card-header">
                        <span>' . $list_users['username'] . '</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Your credit card number: ' . $list_users['credit_card_number'] . '</p>
                    </div>
                </div>
                <hr>';
        } else {
          echo '<div class="text-danger">Wrong username or password!</div>';
        }
    } else {
        echo '<div class="text-danger">Wrong username or password!</div>';
    }
}

?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>