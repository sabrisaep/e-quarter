<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Developer Tools</title>
</head>
<body>
<h3>Developer Tools</h3>

<h4>
    Disable function:
    <?php
    echo ini_get('disable_functions');
    ?>
</h4>

<form action="<?= base_url('developer') ?>" method="post">
    <button name="git_pull">Git Pull</button>
    <button name="migrate">Run Migration</button>
</form>

<pre>
<?= esc($output ?? '') ?>
</pre>
</body>
</html>