<div class="container">
    <?php if (!empty($user)): ?>
        <?php foreach ($user as $users): ?>
            <div class="row border p-3 mb-3">
                <div class="col-1"><?= $users['id'] ?></div>
                <div class="col-2"><?= $users['rmgc_first_name'] ?></div>
                <div class="col-1"><?= $users['rmgc_last_name'] ?></div>
                <div class="col-3"><?= $users['rmgc_email'] ?></div>
                <div class="col-1"><?= $users['rmgc_gender'] ?></div>
                <div class="col-2"><?= $users['rmgc_address'] ?></div>
                <div class="col">
                    <a class="btn btn-primary" href="/users/edit/<?= $users['id'] ?>">Edit</a> |
                    <a class="btn btn-danger" href="/users/delete/<?= $users['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="row border p-3">
            <div class="col text-center">No Record Found.</div>
        </div>
    <?php endif; ?>

    <nav aria-label="Page navigation">
        <!-- Add pagination links dynamically -->
    </nav>
</div>
