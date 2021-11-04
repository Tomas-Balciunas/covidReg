<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>
    <?php require "view/_partials/nav.view.php"; ?>
    <div class="container">
        <p>Edit an appointment:</p>
        <form method="POST" class="app">
            <span>Name:</span>
            <input type="text" name="name" value="<?= $app['name']; ?>">

            <span>Email</span>
            <input type="text" name="email" value="<?= $app['email']; ?>">

            <span>Phone number</span>
            <input type="text" name="phoneNumber" value="<?= $app['phone_number']; ?>">

            <span>Personal Id</span>
            <input type="text" name="personalId" value="<?= $app['personal_id']; ?>">

            <span>Date</span>
            <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" value="<?= $date[0]; ?>">

            <span>Time</span>
            <select name="time">
                <option value="08:00" <?= $date[1] == '08:00:00' ? 'selected' : ''; ?>>08:00</option>
                <option value="09:00" <?= $date[1] == '09:00:00' ? 'selected' : ''; ?>>09:00</option>
                <option value="10:00" <?= $date[1] == '10:00:00' ? 'selected' : ''; ?>>10:00</option>
                <option value="11:00" <?= $date[1] == '11:00:00' ? 'selected' : ''; ?>>11:00</option>
                <option value="12:00" <?= $date[1] == '12:00:00' ? 'selected' : ''; ?>>12:00</option>
                <option value="13:00" <?= $date[1] == '13:00:00' ? 'selected' : ''; ?>>13:00</option>
                <option value="14:00" <?= $date[1] == '14:00:00' ? 'selected' : ''; ?>>14:00</option>
                <option value="15:00" <?= $date[1] == '15:00:00' ? 'selected' : ''; ?>>15:00</option>
                <option value="16:00" <?= $date[1] == '16:00:00' ? 'selected' : ''; ?>>16:00</option>
                <option value="17:00" <?= $date[1] == '17:00:00' ? 'selected' : ''; ?>>17:00</option>
            </select>

            <input type="submit" name="edit" value="Complete">
        </form>
    </div>
</body>

</html>

<style>
    .container {
        display: flex;
        flex-flow: column;
        width: 100%;
        align-items: center;
    }

    .app {
        display: flex;
        flex-flow: column;
        width: 10em;
    }

    .app>input,
    select {
        margin-bottom: 1em;
    }
</style>