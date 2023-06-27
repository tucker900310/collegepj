import RPi.GPIO as GPIO
import time

def Setup(GPIOnum,OUT_IN):#設電源開關
    GPIO.setmode(GPIO.BCM)
    
    if OUT_IN=="OUT":
        GPIO.setup(GPIOnum,GPIO.OUT)
    else:
        GPIO.setup(GPIOnum,GPIO.IN)

def TurnOnLED(GPIOnum):#開燈
    GPIO.output(GPIOnum,True)
    
def TurnOffLED(GPIOnum):#關燈
    GPIO.output(GPIOnum,False)
    
def GetGPIOStatus(GPIOnum):
    GPIO_state =GPIO.input(GPIOnum)
    return GPIO_state
if __name__ == "__main__":
    try:
        Setup(2,"OUT")
        Setup(3,"OUT")
        Setup(4,"OUT")
        while True:
            TurnOnLED(4)
            time.sleep(1)
            TurnOffLED(4)
            time.sleep(1)
            for i in range (0,5):
                TurnOnLED(3)
                time.sleep(0.2)
                TurnOffLED(3)
                time.sleep(0.2)
            TurnOnLED(2)
            time.sleep(2)
            TurnOffLED(2)
            time.sleep(2)
 

    except KeyboardInterrupt:
        GPIO.cleanup()
              
