<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018-07-18
 * Time: 22:37
 */
?>


<?php
function template($content=""){
    echo <<<_END
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <nav>
                <a href="index.php">Index</a>
                <a href="addClient.php">addClient</a>
                <a href="addCar.php">addCar</a>
                <a href="find.php">Find</a>
                <a href="clients.php">Clients</a>
                <a href="cars.php">Cars</a>
                <a href="diary.php">Diary</a>
			</nav>
            $content
        </body>
    </html>
_END;
}
?>