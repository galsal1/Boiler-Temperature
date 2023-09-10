import time
import ADS1256
import RPi.GPIO as GPIO
import sqlite3


"""
function that convert the volt input into Temperature
Requires calibration throuhgh  measurements and converting the results into a formula
slope - is the slope of the straight line
sens_V - sensor voltage input
constant - is the point of intersection with y-axis

return the temperature
"""
def volt_to_Temperature(sens_V):
    constant = 284.58
    slope = (-465.28) 
    sens_temp = slope * sens_V + constant
    return(sens_temp)

"""
function that Avarage the results of avgcoef number of test
return set of average results
"""
def avgSensors(avgcoef,sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8):
    return ((sensor1/avgcoef),(sensor2/avgcoef),(sensor3/avgcoef),(sensor4/avgcoef),(sensor5/avgcoef),(sensor6/avgcoef),(sensor7/avgcoef),(sensor8/avgcoef))

    
"""
function that insert the temperature of sensors into a database
database path - /var/www/html/BoilerSQL.odb
"""
def insert_temp_into_table(sensors):
    dbPath = '/var/www/html/BoilerSQL.odb' 
    try:
        conn = sqlite3.connect(dbPath)
        if(not db_isnotempty(conn)):
            print(0)
            insert_new_row(conn,sensors)
        else:
            print(1)
            update(conn,sensors)
            
    except:
        print("error")

"""
function that check if we have 1 or more rows in database
return true if the database isnt empty and false if database is empty
"""
def db_isnotempty(conn):
    cursor = conn.cursor()
    rowcount_query = """SELECT COUNT(1) FROM Sensors WHERE ID=1;"""
    cursor.execute(rowcount_query)
    conn.commit()
    return (cursor.fetchone()[0]!=0)

"""
function that insert a new row into the database
""" 
def insert_new_row(conn,sensors):
    cursor = conn.cursor()
    insert_query = """INSERT INTO Sensors(sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8) 
    VALUES(?,?,?,?,?,?,?,?);"""
    cursor.execute(insert_query,sensors)
    conn.commit()


"""
function that update the first row in the database
""" 
def update(conn,sensors):
    cursor = conn.cursor()
    update_query = """Update Sensors Set sensor1 = ?, sensor2 = ? ,sensor3 = ?, sensor4 = ? ,sensor5 = ?, sensor6 = ? ,sensor7 = ?, sensor8 = ? 
    WHERE ID = 1;"""
    cursor.execute(update_query,sensors)
    conn.commit()

#setup buzzer fo water leakage
#buzzer pin is GPIO 23 (P4 on raspi board)       
buzzer=23
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(buzzer,GPIO.OUT)

try:
    ADC =ADS1256.ADS1256()
    ADC.ADS1256_init()
    
    #constants for calibration sensors temperature
    clibration1 = 2.6693
    clibration2 = 2.3365
    clibration3 = 0.923975
    clibration4 = 1.505565
    clibration5 = 0.457756
    clibration6 = 0.15
    
    while(1):
        ADC_Value = ADC.ADS1256_GetAll()
        cnt=0

        #init all sensors
        sensor1, sensor2, sensor3, sensor4, sensor5, sensor6, sensor7, sensor8 = 0, 0, 0, 0, 0, 0, 0, 0

        while(cnt<20):
            ADC_Value = ADC.ADS1256_GetAll()
            sensor1 += volt_to_Temperature(float(ADC_Value[0]*5.0/0x7fffff)) + clibration1
            sensor2 += volt_to_Temperature(float(ADC_Value[1]*5.0/0x7fffff)) + clibration2
            sensor3 += volt_to_Temperature(float(ADC_Value[2]*5.0/0x7fffff)) + clibration3
            sensor4 += volt_to_Temperature(float(ADC_Value[3]*5.0/0x7fffff)) + clibration4
            sensor5 += volt_to_Temperature(float(ADC_Value[4]*5.0/0x7fffff)) + clibration5
            sensor6 += volt_to_Temperature(float(ADC_Value[5]*5.0/0x7fffff)) + clibration6
            sensor7 += volt_to_Temperature(float(ADC_Value[6]*5.0/0x7fffff))
            sensor8 +=float(ADC_Value[7]*5.0/0x7fffff)
            cnt+=1        
        
        sensors = avgSensors(20,sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8)
        insert_temp_into_table(sensors)

        #if water sensors input is more than 0.5 volt buzzer start working else stop the buzzer
        if(sensors[7]>0.5):
            GPIO.output(buzzer,GPIO.HIGH)
        else:
            GPIO.output(buzzer,GPIO.LOW)

        #clear terminal
        print("\33[2A")

        #sleep 1 second
        time.sleep(1)

except:
    GPIO.cleanup()
    print ("\r\nProgram end")
    exit()
    

              
            
