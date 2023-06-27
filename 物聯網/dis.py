import RPi.GPIO as GPIO 
import Adafruit_DHT
import time

GPIO.setmode(GPIO.BCM)

GPIO_TRIGGER =7
GPIO_ECHO =12
GPIO_TEMP =17

GPIO.setup(GPIO_TRIGGER, GPIO.OUT)
GPIO.setup(GPIO_ECHO, GPIO.IN)
sensor = Adafruit_DHT.DHT11


def send_trigger_pulse():
    GPIO.output(GPIO_TRIGGER, True)
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER,False)

def get_speed():
    humidity, temperature = Adafruit_DHT.read_retry(sensor, GPIO_TEMP)
    speed = 33100 + temperature * 60
    return speed

def distance(speed):

    send_trigger_pulse()

    while GPIO.input(GPIO_ECHO) == 0:
        StartTime = time.time()

    while GPIO.input(GPIO_ECHO) == 1:
        StopTime = time.time()

    TimeElapsed = StopTime - StartTime
    distance = (TimeElapsed * speed) / 2

    return distance

def TurnOnLED(GPIOnum):
    GPIO.output(GPIOnum,True)
    
def TurnOffLED(GPIOnum):
    GPIO.output(GPIOnum,False)
   
def Setup(GPIOnum,OUT_IN):
    GPIO.setmode(GPIO.BCM)
    
    if OUT_IN=="OUT":
        GPIO.setup(GPIOnum,GPIO.OUT)
    else:
        GPIO.setup(GPIOnum,GPIO.IN)

Setup(2,"OUT")
Setup(3,"OUT")
Setup(4,"OUT")
if __name__ == '__main__':
    try:
        speed = get_speed()
        while True:
            
            dist = distance(speed)
            print("Measured Distance = %.1f cm" % dist)
            time.sleep(1)
            if (dist <= 5):
                TurnOnLED(2)
                TurnOffLED(3)
                TurnOffLED(4)
                
            elif (dist <= 10 and dist > 5):
                TurnOnLED(3)
                TurnOffLED(2)
                TurnOffLED(4)
                
            elif (dist <= 15 and dist > 10):
                TurnOnLED(4)
                TurnOffLED(2)
                TurnOffLED(3)
                
            else:
                TurnOffLED(2)
                TurnOffLED(3)
                TurnOffLED(4)
            
    except KeyboardInterrupt:
        print("Measurement stopped by User")
        GPIO.cleanup()