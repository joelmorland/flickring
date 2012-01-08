<?php
#require my phpFlickr class extension
require_once("classes/flickr.php");

#instantiate
$flickr = new flickr("0469684d0d4ff7bb544ccbb2b0e8c848");  

#if single image
if (isset($_GET['image'])) {
    $flickr->echoImage($_GET['image']);
    exit;    
}

#get search and page to keep it tidy and separate html from PHP logic
$search=(isset($_GET['s']))?$_GET['s']:'ocean';
$page=(isset($_GET['p']))?$_GET['p']:1;
?>

<html>
<head>
    <link rel="stylesheet" href="CSS/style.css" type="text/css" media="all" />
</head>
<body>
    <div id="container">
        <div id="search">
            <form action="" method="get">
                <label for="search">Search:</label>
                <input type="text" name="s" id="search" />
                <input type="submit" value="Search!" />
            </form>
        </div>
        
        <?php $flickr->searchPhotos($search, $page); ?>
    </div>
</body>

</html>

