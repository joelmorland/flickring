<?php
#flickr class written by Joel Morland
#phpFlickr written by Dan Coulter

class flickr extends phpFlickr
{     
    function searchPhotos($search='moon', $page=1) 
    {        
        #get photos with extra params to get original format & dimensions
        $photos = $this->photos_search(array("tags"=>$search, "tag_mode"=>"any", "per_page"=>"5", "page"=>$page, "extras"=>"original_format,o_dims", "privacy_filter"=>1));
        
        //check that photos returned
        if (is_array($photos) && count($photos)) {
            echo "<div id='notice'>Found {$photos['total']} Photos</div>";
            echo '<div id="gallery">';
            #echo photos
            foreach ($photos['photo'] as $photo) 
            {
                #print_r($photo);
                #$owner = $this->people_getInfo($photo['owner']);
                echo "<a href='index.php?image={$photo['id']}' target='_blank'><img class='galleryImage' src='".$this->buildPhotoURL($photo,'thumbnail')."' /></a>";
                /*echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
                echo $photo['title'];
                echo "</a> Owner: ";
                echo "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>";
                echo "</a><br>";*/
            }
            echo '</div>';
            
            $this->pagination($page, $photos['total'], $search);
        }
    }
    
    function pagination($cur, $total, $search) {
        echo '<div class="pagination">';
        
            echo ($cur>4)?"<a href='index.php?s=$search&p=1'>1</a>":'';
            
            for ($i=$cur-2; $i<=$cur+2; $i++) {
                if ($i<1 || $i>$total) continue;
                echo ($i!=$cur)?"<a href='index.php?s=$search&p=$i'>$i</a>":"<b>$i</b>";
            } 
            
            echo ($cur!==$total)?"...<a href='index.php?s=$search&p=$total'>$total</a>":'';
            
        echo '</div>';
    }
    
    function echoImage($photoID) {
        $photo = $this->photos_getInfo($photoID); #get photo format, size etc from photo id
        
        #if image is restricted from full resolution download, display as large        
        $size=(isset($photo['photo']['originalformat'], $photo['photo']['originalsecret']))?'original':'large';
        
        #echo "<img src='".$this->buildPhotoURL($photo['photo'],$size)."' />";
        #header('Content-Type: image/jpeg');
        header('location:'.$this->buildPhotoURL($photo['photo'],$size));
    }
}
?>