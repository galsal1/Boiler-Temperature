import time
import ADS1256
import RPi.GPIO as GPIO
import sqlite3

def volt_to_Temperature(sens_V):
    coef = 284.58
    sens_temp = (-465.28)*sens_V + coef
    return(sens_temp)

def avgSensors(avgcoef,sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8):
    return ((sensor1/avgcoef),(sensor2/avgcoef),(sensor3/avgcoef),(sensor4/avgcoef),(sensor5/avgcoef),(sensor6/avgcoef),(sensor7/avgcoef),(sensor8/avgcoef))

    
def insert_temp_into_table(sensors):
    try:
        conn = sqlite3.connect('/var/www/html/BoilerSQL.odb')
        if(not number_of_row_grather_of_1(conn)):
            print(0)
            insert_new_row(conn,sensors)
        else:
            print(1)
            update(conn,sensors)
            
    except:
        print("error")

def number_of_row_grather_of_1(conn):
    cursor = conn.cursor()
    rowcount_query = """SELECT COUNT(1) FROM Sensors WHERE ID=1;"""
    cursor.execute(rowcount_query)
    conn.commit()
    return (cursor.fetchone()[0]!=0)
    
def insert_new_row(conn,sensors):
    cursor = conn.cursor()
    insert_query = """INSERT INTO Sensors(sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7,sensor8) 
    VALUES(?,?,?,?,?,?,?,?);"""
    cursor.execute(insert_query,sensors)
    conn.commit()

def update(conn,sensors):
    cursor = conn.cursor()
    update_query = """Update Sensors Set sensor1 = ?, sensor2 = ? ,sensor3 = ?, sensor4 = ? ,sensor5 = ?, sensor6 = ? ,sensor7 = ?, sensor8 = ? 
    WHERE ID = 1;"""
    cursor.execute(update_query,sensors)
    conn.commit()

#buzzer pin is GPIO 23 (P4 on raspi board)       
buzzer=23
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(buzzer,GPIO.OUT)

try:
    ADC =ADS1256.ADS1256()
    ADC.ADS1256_init()
    
    clibration1 = 2.6693
    clibration2 = 2.3365
    clibration3 = 0.923975
    clibration4 = 1.505565
    clibration5 = 0.457756
    clibration6 = 0.15
    
    while(1):
        ADC_Value = ADC.ADS1256_GetAll()        
        
        cnt=1
        sensor1 = volt_to_Temperature(float(ADC_Value[0]*5.0/0x7fffff)) + clibration1
        sensor2 = volt_to_Temperature(float(ADC_Value[1]*5.0/0x7fffff)) + clibration2
        sensor3 = volt_to_Temperature(float(ADC_Value[2]*5.0/0x7fffff)) + clibration3
        sensor4 = volt_to_Temperature(float(ADC_Value[3]*5.0/0x7fffff)) + clibration4
        sensor5 = volt_to_Temperature(float(ADC_Value[4]*5.0/0x7fffff)) + clibration5
        sensor6 = volt_to_Temperature(float(ADC_Value[5]*5.0/0x7fffff)) + clibration6
        sensor7 = volt_to_Temperature(float(ADC_Value[6]*5.0/0x7fffff))
        
        sensor8 = float(ADC_Value[7]*5.0/0x7fffff)
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
        if(sensors[7]>0.5):
            GPIO.output(buzzer,GPIO.HIGH)
        else:
            GPIO.output(buzzer,GPIO.LOW)
        print("\33[2A")
        
        time.sleep(1)

except:
    GPIO.cleanup()
    print ("\r\nProgram end")
    exit()
    

              
            
