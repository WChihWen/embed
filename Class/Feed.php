<?php
class Feed{
    public $title ='';
    public $link ='';
    public $pubDate ='';
    public $source  ='';
    public $sourceUrl ='';


    public function __construct($title,$link,$pubDate,$source,$sourceUrl){
        $this->title =$title;
        $this->link =$link;
        $this->pubDate =$pubDate;
        $this->source =$source;
        $this->sourceUrl =$sourceUrl;        
    }

}

?>