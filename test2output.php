<?php
    if(!empty($_POST['upload']))
    {
        echo "File with name ".$_FILES['myImage']['name']." uploaded";
    }
    else
    {
        echo "Please upload a file";
    }
?>