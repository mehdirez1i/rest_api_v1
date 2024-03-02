

<?php
include 'config/db_connect.php';

$sql = 'SELECT id, name, phone, email  FROM user';

$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($conn);
    print_r($user);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php foreach($user as $us){ ?>
    <div class="container">
        <p><?php echo htmlspecialchars($us['name']) ; ?></p>
        <p><?php echo htmlspecialchars($us['phone']) ; ?></p>
        

    </div>


    <?php } ?>

        
    </body>
    </html>