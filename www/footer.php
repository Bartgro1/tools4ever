</div> <!-- close content container -->

<?php if (isset($sql) && is_array($sql)) : ?>
    <div class="sql-statement">
        <?php foreach ($sql as $s) : ?>
            <?php if (isset($s['total'])) : ?>
                <p><strong>SQL Statement: </strong><span class="sql-statements"><?php echo htmlspecialchars($s['total']); ?></span></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>



