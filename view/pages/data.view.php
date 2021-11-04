<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>
    <?php require "view/_partials/nav.view.php"; ?>
    <div class="container">
        <div class="buttons">
            <form method="POST">
                <input type="submit" name="exportAll" value="Export All Data">
            </form>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="csv" accept=".csv">
                <input type="submit" name="importData" value="Import Data">
            </form>
        </div>
    </div>
</body>

</html>