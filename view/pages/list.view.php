<!DOCTYPE html>
<html>
<?php require "view/_partials/head.view.php"; ?>

<body>
    <?php require "view/_partials/nav.view.php"; ?>
    <div class="container">
        <?php if (!empty($list)) : ?>
            <table>
                <tr>
                    <th><a href="/visma/list?sort=name">Name</a></th>
                    <th>Email</th>
                    <th>Phone Nr.</th>
                    <th>Personal ID</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($list as $item) : ?>
                    <tr>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['email']; ?></td>
                        <td><?= $item['phone_number']; ?></td>
                        <td><?= $item['personal_id']; ?></td>
                        <td><?= $item['date_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <h3>Appointment list is empty</h3>
        <?php endif; ?>
    </div>
</body>

</html>