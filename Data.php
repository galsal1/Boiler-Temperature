<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('BoilerSQL.odb');
    }
}
$conn = new MyDB();
if(!$conn){
    echo $conn-> lastErrorMsg();
}
else{
    $result = $conn->query('SELECT sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8 FROM Sensors WHERE ID=1');
    while(!$result){
        $result = $conn->query('SELECT sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8 FROM Sensors WHERE ID=1');
    }
    if($result){
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $Se1 = round($row['sensor1'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 115px; position: absolute; width: 300px; font-size:xx-large;'>". $Se1 ."<span>&#176</span></div>";
        
        $Se2 = round($row['sensor2'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 191px; position: absolute; width: 300px; font-size:xx-large;'>". $Se2 ."<span>&#176</span></div>";
        
        $Se3 = round($row['sensor3'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 267px; position: absolute; width: 300px; font-size:xx-large;'>". $Se3 ."<span>&#176</span></div>";
        
        $Se4 = round($row['sensor4'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 343px; position: absolute; width: 300px; font-size:xx-large;'>". $Se4 ."<span>&#176</span></div>"; 
               
        $Se5 = round($row['sensor5'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 419px; position: absolute; width: 300px; font-size:xx-large;'>". $Se5 ."<span>&#176</span></div>";
        
        $Se6 = round($row['sensor6'],1);
        echo "<div style=' z-index: 1; left: 295px; top: 495px; position: absolute; width: 300px; font-size:xx-large;'>". $Se6 ."<span>&#176</span></div>";
               
        $Se7 = round($row['sensor7'],1);
        $Se8 = $row["sensor8"]; 
        if($Se8>0.5){
            echo "<img src='image\water-puddle.png' width='450' style='position: absolute; top: 650px;'/>";
            $red = "#FF0000";
            echo "<div style='position: absolute; left: 450px; top:300px; width:400px;'>
            <p style='position:relative; margin:0 auto; font-size:xx-large; color:". $red ."'>Warning!!! Water leakage</p>
            <img src='image\Warning_Leakage.png' width='300' style='position:relative; margin:0 auto; left:35px; top:50px'/>
            </div>";
        }


        echo "<div style='position: absolute; left: 75px; top: 100px; width: 200px; height: 30px; border-top-style: solid; border-width: 9px;
               
                border-right-style: solid; border-left-style: solid; border-top-left-radius: 30px 30px; border-top-right-radius: 30px 30px; background-color:". temperaturecolor($Se1) ."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 130px; width: 200px; height: 50px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-image: linear-gradient(". temperaturecolor($Se1) .",".temperaturecolor($Se2)."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 180px; width: 200px; height: 30px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-color:". temperaturecolor($Se2) ."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 210px; width: 200px; height: 50px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-image: linear-gradient(". temperaturecolor($Se2) .",".temperaturecolor($Se3)."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 260px; width: 200px; height: 30px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-color:". temperaturecolor($Se3) ."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 290px; width: 200px; height: 50px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-image: linear-gradient(". temperaturecolor($Se3) .",".temperaturecolor($Se4)."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 340px; width: 200px; height: 30px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-color:". temperaturecolor($Se4) ."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 370px; width: 200px; height: 50px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-image: linear-gradient(". temperaturecolor($Se4) .",".temperaturecolor($Se5)."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 420px; width: 200px; height: 30px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-color:". temperaturecolor($Se5) ."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 450px; width: 200px; height: 50px; border-width: 9px; border-right-style: solid; border-left-style: solid; background-image: linear-gradient(". temperaturecolor($Se5) .",".temperaturecolor($Se6)."'></div>";

        echo "<div style='position: absolute; left: 75px; top: 500px; width: 200px; height: 50px; border-width: 9px;
                border-bottom-style: solid; border-right-style: solid; border-left-style: solid; border-bottom-left-radius: 30px 30px; border-bottom-right-radius: 30px 30px; background-color:". temperaturecolor($Se6) ."'></div>";

        $url = "http://100dayscss.com/codepen/thermostat-gradient.jpg";

        echo "<div class='main' style=' box-sizing: border-box; position: absolute; left: 520px; top: 60px; '>
                <div class='container' style='width: 400px; height: 400px; overflow: hidden;'>

		            <div class='outer-circle' style='display: flex; justify-content: center; align-items: center; width: 200px; height: 200px; background-color: #f1f1f1; border-radius: 50%; cursor: pointer;'>

			            <div class='middle-circle' style='display: flex; justify-content: center; align-items: center; position: absolute; width: 180px;
				            height: 180px; border-radius: 50%; border-bottom: 20px solid #f1f1f1; border-top: 20px solid transparent; border-left: 20px solid transparent; border-right: 20px solid transparent;
				            background: url(". $url ."); background-repeat: no-repeat; background-size: 180px 180px; background-position: center center;'>
				
				            <div class='inner-circle' style='display: flex; justify-content: center; align-items: center; position: absolute; width: 143px; height: 143px;
					            background-color: #fff; border-radius: 50%; flex-direction: column;
					            span {
						            position: relative;
					            }'>

					            <span class='mid' style='margin: 5px 0; font-size: 60px; transition: 0.4s; color: #5a2962; backface-visibility: hidden;
							        &::after {
								        content: '°';
								        position: absolute;
								        font-size: 25px;
								        top: 8px;
								        right: -9px;}'>". $Se7 ."<span>&#176</span></span>
					            <span class='bottom' style='font-size:15px; color: #5a2962;'>Roof</span>
					            <div class='line' style='position: relative; width: 100%; height: 100%; background-color: transparent; border-radius: 50%;
						            position: absolute;
						            left: 0;
						            top: 0;
						            overflow: hidden;
						            transform: rotate(". getDegree($Se7) ."deg);'>
                                                    </div>
				            </div>
			            </div>
		            </div>
	            </div>
            </div>";
    }
    echo "<div style='position:absolute; margin: 0 auto; left:100px; top:-20px; font-size:x-large;'>". date('d/m/Y H:i:s a', time()) ."</div>";
    $conn->close();
}
function getDegree($temperature){
    if($temperature<25){
        $temperature =  25 - $temperature;
        return (-1)* $temperature * 2.57;
    }
    if($temperature>25){
        $temperature =  $temperature-25;
        return $temperature * 7.2;
    }
}

function temperaturecolor($temperature){
    $purple = "#A12EDF";
    $blue = "#371FE3";
    $lightblue = "#0BB5E7";
    $turquoise = "#00FFC9";
    $green = "#00FF0F";
    $yellow = "#F3FF00";
    $orange = "#FF8000";
    $red = "#FF0000";
    $brown = "#AA0A0A";
    if($temperature<20){
        return $purple;
    }
    if($temperature>=20 AND $temperature<30){
        return $blue;
    }
    if($temperature>=30 AND $temperature<40){
        return $lightblue;
    }
    if($temperature>=40 AND $temperature<50){
        return $turquoise;
    }
    if($temperature>=50 AND $temperature<60){
        return $green;
    }
    if($temperature>=60 AND $temperature<70){
        return $yellow;
    }
    if($temperature>=70 AND $temperature<80){
        return $orange;
    }
    if($temperature>=80 AND $temperature<90){
        return $red;
    }
    if($temperature>=90){
        return $brown;
    }
}
?>
