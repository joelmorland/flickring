<?php
#flickr class written by Joel Morland
#phpFlickr written by Dan Coulter

#require phpFlickr class
require_once("phpFlickr.php");

class flickr extends phpFlickr
{     
    function searchPhotos($search, $page=1) 
    {        
        #get photos with extra params to get original format & dimensions
        $photos = $this->photos_search(array("tags"=>$search, "tag_mode"=>"any", "per_page"=>"5", "page"=>$page, "extras"=>"original_format,o_dims", "privacy_filter"=>1));
        
        //check that photos returned
        if (is_array($photos) && count($photos)) {
            #currently displayed photos
            $disp = ($page*5-5).' - '.($page*5);
            echo "<div id='notice'>
                        Found {$photos['total']} photos for '$search' [limited to 4000]
                        <br/>Displaying $disp
                  </div>";
            
            ## GALLERY ##
            echo "<div id='gallery'>";
            
            #echo photos
            foreach ($photos['photo'] as $photo) 
            {
                echo "<a href='index.php?image={$photo['id']}' target='_blank'><img class='galleryImage' src='".$this->buildPhotoURL($photo,'thumbnail')."' /></a>";
            }
            
            echo '</div>';
            ## END GALLERY ##
            
            $this->pagination($page, $photos['pages'], $search);
        }
    }
    
    function pagination($cur, $pages, $search) {
        #flickr API only allows 4000 results to be returned - limit to 4000 otherwise dummy photos are displayed by flickr
        $pages=($pages>4000/5)?4000/5:$pages;         
        
        echo '<div class="pagination">';
        
            echo ($cur>4)?"<a href='index.php?s=$search&p=1'>1</a>":'';
            
            for ($i=$cur-2; $i<=$cur+2; $i++) {
                if ($i<1 || $i>$pages) continue; #ensure page not less than one or greater than last page
                echo ($i!=$cur)?"<a href='index.php?s=$search&p=$i'>$i</a>":"<b>$i</b>";
            } 

            #ensure current
            echo ($cur<=($pages-2))?"...<a href='index.php?s=$search&p=$pages'>$pages</a>":'';
            
        echo '</div>';
    }
    
    function echoImage($photoID) {
        $photo = $this->photos_getInfo($photoID); #get photo format, size etc from photo id
        
        #if image is restricted from full resolution download, display as large        
        $size=(isset($photo['photo']['originalformat'], $photo['photo']['originalsecret']))?'original':'large';
        
        #show full size image rather than HTML <img tag
        header('location:'.$this->buildPhotoURL($photo['photo'],$size));
    }
}
?>