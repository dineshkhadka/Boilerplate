<?php

    // $url should be an absolute url
    function redirect($url){
        if (headers_sent()){
            die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
        }else{
            header('Location: ' . $url);
            exit();
        }    
    }

    // Image Compress
    // compress_image($_FILES["file"]["tmp_name"], "newfilename.jpg", 20);
    // Temporary Name , New Filename , Image Quality (0-100) 
    function image_compress($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source_url);
        }elseif ($info['mime'] == 'image/gif'){
            $image = imagecreatefromgif($source_url);
        }elseif ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($source_url);
        }else{
            die('Unknown image file format');
        }
        
        //compress and save file to jpg
        imagejpeg($image, $destination_url, $quality);
        //return destination file
        return $destination_url;
        
        //Alternatively the resulting image can be stored as png if transparency needs to be preserved. The function looks like this
        //imagepng($image, 'destination.png', 5);
        
    }



    
    // check if the target directory exists and is writable.
    function check_dir($target_dir) {
        if (!is_dir($target_dir)) {
            $_SESSION['failure']['message'] = "Upload directory does not exist. <br />";
            global $uploadOk;
            $uploadOk = 0;
        }
        if (!is_writable($target_dir)) {
            $_SESSION['failure']['message'] = "Upload directory is not writable. <br />";
            global $uploadOk;
            $uploadOk = 0;
        }
    }


    // check if exist or not
    function existing($target_file){
        // Check if file already exists
        if (!file_exists($target_file)) {
            global $uploadOk;
            $uploadOk = 1;
        } else {
            $_SESSION['failure']['message'] = "Sorry, file already exists. <br />";
            global $uploadOk;
            $uploadOk = 0;
            
        }
    }


    // check file type
    function fileExtensionCheck($file_extension){
        if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg"){
            $_SESSION['failure']['message'] = "Sorry, only JPG, JPEG & PNG files are allowed. <br />";
            global $uploadOk;
            $uploadOk = 0;
        }    
    }


    //Fake image test
    function fakeImage($img_temp){
            // Check if image file is an actual image or fake image
            $check = getimagesize($img_temp);
            if ($check !== false) {
                global $uploadOk;
                $uploadOk = 1;
            } else {
                $_SESSION['failure']['message'] = "File is not an image. <br />";
                global $uploadOk;
                $uploadOk = 0;
            }    
    }


    
    // creating unique filename
    function hash_filename($img, $file_extension){
        $new_filename = date('Y-m-d') . '-' . md5(uniqid(round(microtime(true)))) . '.' . $file_extension;
        return $new_filename;
    }


    //Get youtube id
    function getYouTubeVideoId($url)
    {
        $video_id = false;
        $url = parse_url($url);
        if (strcasecmp($url['host'], 'youtu.be') === 0)
        {
            #### (dontcare)://youtu.be/<video id>
            $video_id = substr($url['path'], 1);
        }
        elseif (strcasecmp($url['host'], 'www.youtube.com') === 0)
        {
            if (isset($url['query']))
            {
                parse_str($url['query'], $url['query']);
                if (isset($url['query']['v']))
                {
                    #### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
                    $video_id = $url['query']['v'];
                }
            }
            if ($video_id == false)
            {
                $url['path'] = explode('/', substr($url['path'], 1));
                if (in_array($url['path'][0], array('e', 'embed', 'v')))
                {
                    #### (dontcare)://www.youtube.com/(whitelist)/<video id>
                    $video_id = $url['path'][1];
                }
            }
        }
        return $video_id;
    }


    //Get youtube thumbnail image
    function getYoutubeImage($e){
        //GET THE URL
        $url = $e;

        $queryString = parse_url($url, PHP_URL_QUERY);

        parse_str($queryString, $params);

        $v = $params['v'];  
        //DISPLAY THE IMAGE
        if(strlen($v)>0){
             echo '<img src="http://img.youtube.com/vi/'.$v.'/hqdefault.jpg"  />';
        }
    }


    //Shorten string
    function shorten_string($string, $wordsreturned)
    {
      $retval = $string;
      $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
      $string = str_replace("\n", " ", $string);
      $array = explode(" ", $string);
      if (count($array)<=$wordsreturned)
      {
        $retval = $string;
      }
      else
      {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array)." ...";
      }
      return $retval;
    }

    //Add active class
    function active($currect_page){
      $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
      $url = end($url_array);  
      if($currect_page == $url){
          echo 'active'; //class name in css 
      } 
    }


?>