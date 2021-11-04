<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>
    <?php require "view/_partials/nav.view.php"; ?>
    <div class="container">
        <p>Make an appointment:</p>
        <form method="POST" class="app">
            <span>Name:</span>
            <input type="text" name="name">

            <span>Email</span>
            <input type="text" name="email">

            <span>Phone number</span>
            <input type="text" name="phoneNumber">

            <span>Personal Id</span>
            <input type="text" name="personalId">

            <span>Date</span>
            <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>">

            <span>Time</span>
            <select name="time">
                <option value="08:00:00">08:00</option>
                <option value="09:00:00">09:00</option>
                <option value="10:00:00">10:00</option>
                <option value="11:00:00">11:00</option>
                <option value="12:00:00">12:00</option>
                <option value="13:00:00">13:00</option>
                <option value="14:00:00">14:00</option>
                <option value="15:00:00">15:00</option>
                <option value="16:00:00">16:00</option>
                <option value="17:00:00">17:00</option>
            </select>

            <input type="submit" name="register" value="Register">
        </form>
    </div>
</body>

</html>