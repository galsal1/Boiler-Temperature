<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <style>
        *, *::before,*::after { box-sizing: inherit;}
        .line{
                &::after {
                        content:'';
                        width: 15px; 
                        height: 4px;
                        background-color: rgba(152, 49, 122, 0.6);
                        display: block;
                        position: absolute;
                        left: 20px;
                        top: 20px;
                        transform: rotate(45deg);}
        }
</style>
</head>
<body>
    <div>
        <h1 style="text-align:center;">Smart Boiler temperature</h1>
        <div style="width:1000px; margin: 0 auto; position:relative; left:50px;">
            <img src="image\boiler-icon.png" width="400" style="position: relative;"/>

            <div class="refresh" id="output"></div>
            <!--get data from database using php script and jquery-->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(document).ready(function(){
                    function getData(){
                    $.ajax({
                        type: 'POST',
                        url: 'Data.php',
                        success: function(data){
                            $('#output').html(data);
                        }
                    });
                }
                getData();
                setInterval(function () {
                    getData(); 
                }, 1000);  // it will refresh your data every 1 sec
                });
            </script>
        </div>
    </div>
    </body>
</html>
