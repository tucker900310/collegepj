import RPi.GPIO as GPIO
import Adafruit_DHT
import time
#設置led
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

sensor = Adafruit_DHT.DHT11
GPIO_TEMP =17

if __name__ == '__main__':
    try:
        while True:
            #感測溫濕度
            humidity,temperature = Adafruit_DHT.read_retry(sensor, GPIO_TEMP)
            if humidity is not None and temperature is not None:#感測到後把他印出來
                print("Tmp={0:0.2f}*C humidity={1:0.2f}%".format(temperature,humidity))
            else:
                print("Failed to retrieve data from HDT11 senser")
            #濕度大於30且溫度大於38警告中暑
            if (humidity > 30 and temperature > 38) or (humidity > 80 and temperature > 31):
                TurnOffLED(4)
                TurnOffLED(3)
                print("heatstroke Alert")
                for i in range (0,5):
                    TurnOnLED(2)
                    time.sleep(1)
                    TurnOffLED(2)
                    time.sleep(1)
            #溫度大於34預防中暑警報
            elif temperature > 34:
                print("heatstroke Prevention Alert")
                TurnOffLED(3)
                TurnOffLED(2)
                TurnOnLED(4)
            #沒中暑
            else:
                print("No heatstroke Alert")
                for i in range (0,5):
                    TurnOffLED(4)
                    TurnOffLED(2)
                    TurnOnLED(3)
                    time.sleep(1)
                    TurnOffLED(3)
                    time.sleep(1)
                


    except KeyboardInterrupt: print("Measurement stopped by User")
    GPIO.cleanup()
