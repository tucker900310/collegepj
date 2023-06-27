import paho.mqtt.client as mqtt
import RPi.GPIO as GPIO
import random
import time

if __name__ == "__main__":
    try:
        TopicServerIP = "localhost"
        TopicServerPort = 1883
        TopicName = "temp"

        mqttc = mqtt.Client("python_pub")
        mqttc.connect(TopicServerIP, TopicServerPort)#連接

        while True:
            
            
            temp = []
            for i in range(100):
                temp.append(random.randint(25, 40))#隨機25~40度
                time.sleep(1)#每秒產生
            mean = sum(temp)/len(temp)
            if mean:
                mqttc.publish(TopicName, mean)
            time.sleep(5)
            
        except KeyboardInterrupt:
        GPIO.cleanup()