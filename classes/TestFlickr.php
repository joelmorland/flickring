<?php
#require my phpFlickr class extension
require_once("flickr.php");

require_once 'PHPUnit.php';

class flickrTest extends PHPUnit_TestCase
{
    public $test;
    
    function flickrTest ($name) 
    {
        $this->PHPUnit_TestCase($name);
    }
    
    public function setUp() 
    {
        $this->test = new flickr("0469684d0d4ff7bb544ccbb2b0e8c848");
    }
    
    function TestSearchPhotos() 
    {        
        $joel = $this->test->searchPhotos();
        
        #ensure 5 photos are returned
        $this->assertTrue(substr_count($joel, "<img class='galleryImage'")==5);
    }
    
    function TestPagination() 
    {
        $joel = $this->test->pagination();
        
        #ensure pagination is displayed
        $this->assertTrue(strstr($joel, '<div class="pagination">'));
    }
    
    function echoImage($photoID) 
    {
        #mock/test image
        $joel = $this->test->echoImage(6653324159);
        
        #ensure the image isn't empty
        $this->assertNotEmpty($joel);
    }
}

?>