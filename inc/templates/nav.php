<div>
    <div class="float-left">
        <p>
            <a href="/?task=report"> All Students </a
            <?php if (hasPrivilege()): ?>> |
                <a href="/?task=add"> Add New Student </a>
            <?php endif;?>
            <?php if (isRole('admin')): ?> |
                <a href="/?task=seed"> Seed </a>
            <?php endif;?>
        </p>
    </div>
    <div class="float-right">
        <p>
            <?php if (!$_SESSION['loggedin']): ?>
            <a href="/auth.php"> Login </a>
            <?php else: ?>
            <a href="/auth.php?logout=true"> Logout (<?php echo $_SESSION['role']; ?>) </a>
            <?php endif;?>
        </p>
    </div>
</div>



