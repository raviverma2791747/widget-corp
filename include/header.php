<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./include/style.css">
    <title>Widget Corp</title>
</head>

<body>
    <header>
        <h1>Widget Corp <?php if ($mode_admin) {
                            echo "Admin";
                        } ?></h1>
    </header>