<?php

    function gettitle(){
        global $title;
        
        if(isset($title)){
            echo $title;
            
        } else {
            echo 'GOOD AH';
        }
    }