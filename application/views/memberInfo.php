<div>welcome</div>
<div>
    <h3><?= $_SESSION['user_first_name'] ?></h3>
    <img src="<?= $_SESSION['user_image'] ?>">
    <a href="logout" class="logout">
        <div type="button" class="btn btn-outline-primary">
        <span>登出</span>
        </div>
    </a>
</div>