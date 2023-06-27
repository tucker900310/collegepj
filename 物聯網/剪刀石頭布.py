import RPi.GPIO as GPIO
import time
import random
global gGPIOnum

def selectRandomNum(choices):
    return random.choices(choices)

def SetupOI(GPIOnum,OUT_IN):#設電源開關
    GPIO.setmode(GPIO.BCM)
    
    if OUT_IN=="OUT":
        GPIO.setup(GPIOnum,GPIO.OUT)
    else:
        GPIO.setup(GPIOnum,GPIO.IN)
def Setup (GPIOnum, frequency):#設定PWM
    global gGPIOnum
    GPIO.setmode(GPIO.BCM)
    gGPIOnum = GPIOnum
    GPIO.setup(gGPIOnum,GPIO.OUT)
    
    gGPIOnum=GPIO.PWM(GPIOnum,frequency)
    gGPIOnum.start(0)

def TurnOffLED(GPIOnum):#關燈
    GPIO.output(GPIOnum,False)



if __name__=="__main__":
    SetupOI(2,"OUT")
    SetupOI(3,"OUT")
    SetupOI(4,"OUT")
    TurnOffLED(2)
    TurnOffLED(3)
    TurnOffLED(4)
    try:
        userInput=input("Please enter 0 or 2 or 5: ")#輸入剪刀石頭布
        
        if userInput =="0":
            userInput="stone"
        elif userInput =="2":
            userInput="scissors"
        elif userInput =="5":
            userInput="paper"
        else:
            userInput="failed"

        print("Your choise is: ",userInput)
        
        choices=[0,2,5]
        computerChoise=selectRandomNum(choices)#電腦隨機出拳
        if computerChoise[0] == 0:
            computerChoise[0]="stone"
        elif computerChoise[0] == 2:
            computerChoise[0]="scissors"
        elif computerChoise[0] == 5:
            computerChoise[0]="paper"

        print("computer choise is: ",computerChoise[0])
        #使用者獲勝
        if (userInput == "stone" and computerChoise[0]== "scissors")or(userInput == "scissors" and computerChoise[0]== "paper")or(userInput == "paper" and computerChoise[0]== "stone"):
            print("you win")
            Setup(4,100)
            for i in range (0,2):
                for dc in range(0,101,5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
                for dc in range(100,-1,-5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
        #平手
        elif (userInput == "stone" and computerChoise[0]== "stone")or(userInput == "scissors" and computerChoise[0]== "scissors")or(userInput == "paper" and computerChoise[0]== "paper"):
            print("fair")
            Setup(3,100)
            for i in range (0,2):
                for dc in range(0,101,5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
                for dc in range(100,-1,-5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
            
        #電腦獲勝
        else:
            print("you loose")
            Setup(2,100)
            for i in range (0,2):
                for dc in range(0,101,5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
                for dc in range(100,-1,-5):
                    gGPIOnum.ChangeDutyCycle(dc)
                    time.sleep(0.1)
            
        
    except KeyboardInterrupt:
        GPIO.cleanup()