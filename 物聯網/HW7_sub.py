import paho.mqtt.client as mqtt
import re

def TurnOnLED(GPIOnum):#開燈
    GPIO.output(GPIOnum,True)
    
def TurnOffLED(GPIOnum):#關燈
    GPIO.output(GPIOnum,False)
   
def Setup(GPIOnum,OUT_IN):#設定電燈開關
    GPIO.setmode(GPIO.BCM)
    if OUT_IN=="OUT":
        GPIO.setup(GPIOnum,GPIO.OUT)
    else:
        GPIO.setup(GPIOnum,GPIO.IN)
Setup(2, "OUT")
Setup(3, "OUT")
Setup(4, "OUT")
TurnOffLED(2)
TurnOffLED(3)
TurnOffLED(4)

if __name__ == "__main__":
    try:
        def on_connect(client, userdata, flags, rc):
            print("Connect with Result Code: "+str(rc))
            client.subscribe("tem")#溫度
            client.subscribe("humid")#濕度

        def on_message(client, userdata, msg):
            print(msg.topic +" "+ str(msg.payload))
            msgtoStr = str(msg.payload)
            hasdotstr = ''.join([x for x in msgtoStr if x.isdigit() or x == "."])
            strtoFloat = float(hasdotstr)
            if msg.topic == "humid":#濕度判段
                if strtoFloat <= 50:
                    TurnOnLED(3)
                else:
                    TurnOffLED(2)
                    TurnOffLED(3)
            elif msg.topic == "tem":#溫度判斷
                if strtoFloat >= 35:
                    TurnOnLED(2)
                else:
                    TurnOffLED(2)
                    TurnOffLED(3)

        client = mqtt.Client()
        client.on_connect = on_connect
        client.on_message = on_message
        client.connect("localhost", 1883, 60)
        client.loop_forever()
        
    except KeyboardInterrupt:
        GPIO.cleanup()