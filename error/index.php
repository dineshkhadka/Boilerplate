<!DOCTYPE html>
<html>    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <title>404 Page Not Found</title>
        <!--favicon-->
        <link rel="shortcut icon" href="../favicon.png">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Google web font link-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <link type="text/css" href="../assets/css/error.min.css" rel="stylesheet">  <!--CUSTOM CSS FILE-->



        <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->



    </head>
    <body>

        <section>
            <div class="container">
                <div class="row row1">
                    <div class="col-md-12">
                        <h3 class="center capital f1" >Something went Wrong!</h3>
                        <h1 id="error" class="center">404</h1>
                        <p class="center">Page not Found!</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="cflask-holder" >
                            <span class="tada"><i class="fa fa-flask fa-5x flask flip"></i> 
                                <i id="b1" class="bubble"></i>
                                <i id="b2" class="bubble"></i>
                                <i id="b3" class="bubble"></i>

                            </span>
                        </div>
                    </div>
                </div>


                <div class="row"> <!--Search Form Start-->
                    <div class="col-md-12">     
                        <div class="col-md-6 col-md-offset-3 links-wrapper text-center">
                               <?php
                                    $previous = "javascript:history.go(-1)";
                                    if(isset($_SERVER['HTTP_REFERER'])) {
                                        $previous = $_SERVER['HTTP_REFERER'];
                                    }
                                ?>                               
                                <a href="<?= $previous ?>" class="btn btn-danger"><i class="fa fa-long-arrow-left"></i> &nbsp;Go back</a>
                        </div>
                    </div>
                </div> <!--Search Form End-->   

                
            </div>
        </section>

        


    </body>
    
</html>
