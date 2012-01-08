<?php

#require phpFlickr class
require_once("phpFlickr.php");

#require my phpFlickr class extension
require_once("flickr.php");

require_once 'PHPUnit.php';

class flickrTest extends PHPUnit_TestCase 
{
    public $test;
    
    public function setUp() {
        $this->test = new flickr("0469684d0d4ff7bb544ccbb2b0e8c848");
    }
    
    function TestSearchPhotos() 
    {        
        $joel = $this->test->searchPhotos();
        
        $this->assertNotEmpty($joel);
    }
    
    function TestPagination() {
        $joel = $this->test->pagination();
        
        $this->assertNotEmpty($joel);
    }
    
    function echoImage($photoID) {
        $joel = $this->test->echoImage(6653324159);
        
        $this->assertNotEmpty($joel);
    }
}

?>