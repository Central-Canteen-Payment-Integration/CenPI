<?php if (isset($data['username'])): ?>
    <h1>Hi, <?php echo htmlspecialchars($data['username']); ?>!</h1>
<?php endif; ?>