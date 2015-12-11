<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    



<?php 

    include 'classXml.php';
    
    $test = new xmlParser();
    
    echo $test->filterXml();
    echo '<br><br><br>-----------------------------------------------------------------------------------------------------------------<br><br><br>';
    //echo $test->filterXml();

    
?>

</body>
</html>