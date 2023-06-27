# install the apport exception handler if available
import RPi.GPIO as GPIO
import pymysql
import time
import mysql.connector
import socket
from mysql.connector import Error


   conn = pymysql.Connect(
                     host = 'localhost',                            
                     user = 'root',
                     passwd = 'rootroot',
                   db = 'iot',
                   charset='utf8')#連線
    cursor = conn.cursor()
    
degrees = [0,90,180,90]#葉片轉動角度
GPIO.setmode(GPIO.BCM)
GPIO.setup(3,GPIO.OUT)
PWM_FREQ=50
pwm = GPIO.PWM(3,50)
pwm.start(0)
GPIO.output(3,True)
#設置葉片轉動
def SetAngle(angle):
    dutyCycle = 1/20*angle+3
    pwm.ChangeDutyCycle(dutyCycle)





#設置紅外線感應
def setup(GPIOnum,OUT_IN):
    GPIO.setmode(GPIO.BCM)
    if OUT_IN=="IN":
        GPIO.setup(GPIOnum,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)
    else:
        GPIO.setup(GPIOnum,GPIO.OUT)
        
counter = 0

#當感測到紅外線後產生動作
def motion(channel):
    global counter
    counter += 1
    #紀錄時間
    nowdate = time.strftime('%Y-%m-%d',time.localtime())
    nowtime = time.strftime('%H:%M:%S',time.localtime())
    print(nowdate)
    print(nowtime)
    print("motion detect {0}".format(counter))
    #燈光閃爍
    LED_Blink(16,3)
    #葉片轉動
    d = counter%4
    if d == 0:      
        SetAngle(degrees[0])
    elif d == 1:      
        SetAngle(degrees[1])
    elif d == 2:      
        SetAngle(degrees[2])
    elif d == 3:      
        SetAngle(degrees[3])
    time.sleep(1)
    #將感測時間寫進資料庫
    into = "INSERT INTO sleeptime(`date`, `time`) VALUES (%s,%s)"
    values = (nowdate,nowtime)
    cursor.execute(into, values)
    conn.commit()
    cursor.close()
#設置燈光閃爍
def LED_Blink(GPIOnum,times):
    for i in range(0,times):
        GPIO.output(GPIOnum,GPIO.HIGH)
        time.sleep(0.5)
        GPIO.output(GPIOnum,GPIO.LOW)
        time.sleep(0.5)
        
if __name__ == '__main__':
    try:
        
            setup(14,"IN")
            setup(16,"OUT")
            #感測
            GPIO.add_event_detect(14, GPIO.RISING,callback=motion, bouncetime=300)
            while True:
                time.sleep(1)
    except KeyboardInterrupt:
        print("Measurement stopped by User")
        GPIO.cleanup()
