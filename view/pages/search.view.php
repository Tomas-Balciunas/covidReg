<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>
    <?php require "view/_partials/nav.view.php"; ?>
    <div class="container">
        <?php if (!empty($results)) : ?>
            <div class="buttons">
                <form method="POST" id="download">
                    <input type="submit" name="download" value="Download Excel List">
                </form>
                <form method="POST">
                    <input type="submit" name="csv" value="Export as CSV">
                </form>
            </div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Nr.</th>
                    <th>Personal ID</th>
                    <th>Date</th>
                    <th>Control</th>
                </tr>
                <?php foreach ($results as $item) : ?>
                    <tr>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['phone_number']; ?></td>
                        <td><?= $item['personal_id']; ?></td>
                        <td><?= $item['date_time']; ?></td>
                        <td><a href="/visma/appointment/<?= $item['id']; ?>">Edit</a>&nbsp;<a href="/visma/delete/<?= $item['id']; ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <h3>No appointments found for this date</h3>
        <?php endif; ?>
    </div>
</body>

</html>