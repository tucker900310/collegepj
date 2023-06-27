import socket
import RPi.GPIO as GPIO
import time

def Setup(GPIOnum,OUT_IN):
    GPIO.setmode(GPIO.BCM)
    
    if OUT_IN=="OUT": 
        GPIO.setup(GPIOnum,GPIO.OUT) #傳送訊號給元件
    else:
        GPIO.setup(GPIOnum,GPIO.IN) #接收來自元件的訊號源

def TurnOnLED(GPIOnum):
    GPIO.output(GPIOnum,True) #開燈
    
def TurnOffLED(GPIOnum):
    GPIO.output(GPIOnum,False) #關燈
    
GPIO.setmode(GPIO.BCM)    
bind_ip="192.168.157.118"#樹莓派連接手機的IP
bind_port=8888

server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server.bind((bind_ip, bind_port))
server.listen(5)
print("Listening on %s: %d" % (bind_ip, bind_port))


try:
    Setup(2, "OUT")
    Setup(3, "OUT")
    Setup(4, "OUT")
    client, addr = server.accept()
    print("Acepted connection from: %s %d" %(addr[0], addr[1]))
    data=client.recv(1024)
    while True:
        print(data)
        data = client.recv(1024)
        if data == b'redon':
            TurnOnLED(2)
        elif data == b'redoff':
            TurnOffLED(2)
        elif data == b'yellowon':
            TurnOnLED(3)
        elif data == b'yellowoff':
            TurnOffLED(3)
        elif data == b'greenon':
            TurnOnLED(4)
        elif data == b'greenoff':
            TurnOffLED(4)
        elif data == b'alloff':
            TurnOffLED(2)
            TurnOffLED(3)
            TurnOffLED(4)

except KeyboardInterrupt:
    # client_socket.close()
    GPIO.cleanup()