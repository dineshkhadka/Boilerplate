
<!-- JavaScripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>
<?php 
	function isFile($getFile){
                return strtolower(basename($_SERVER['SCRIPT_FILENAME'], '.php')) == $getFile;
            }

     //echo (isFile('index') == true == true ? 'its true' : '');



 ?>

</body>
</html>