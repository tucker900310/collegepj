import paho.mqtt.client as mqtt
import RPi.GPIO as GPIO
import random
import time

if __name__ == "__main__":
    try:
        TopicServerIP = "localhost"
        TopicServerPort = 1883
        TopicName = "humid"

        mqttc = mqtt.Client("python_pub")
        mqttc.connect(TopicServerIP, TopicServerPort)#連接

        while True:
            
            
            humid = []
            for i in range(100):
                humid.append(random.randint(0, 100))#濕度隨機1到100
                time.sleep(1)#每秒產生
            mean = sum(humid)/len(humid)
            if mean:
                mqttc.publish(TopicName, mean)
            time.sleep(5)
            
        except KeyboardInterrupt:
        GPIO.cleanup()