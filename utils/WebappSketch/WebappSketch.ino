/***********************************************************/
/*       Webapp v1.0  by Luca Bellan (lucabellan.it)       */
/***********************************************************/
/*
    SERIAL PROTOCOL:

    Command for relays: 0#[1-4]#[0/1]#@
      0 = type: relay
      [1-4] = related relay
      [0/1] = set relay status
      #@ = close and execute command
      
    Command for sensors: 1#[1-4]#[1-4]#[0/1]#[0/1]#[0-N]#@
      1 = type: sensor
      [1-4] = related sensor
      [1-4] = related relay
      [0/1] = sensor target
      [0/1] = set relay status
      [0-N] = seconds
      #@ = close and execute command
*/
/***********************************************************/


//  PIN
#define PIN_SENS_1 2
#define PIN_SENS_2 3
#define PIN_SENS_3 4
#define PIN_SENS_4 5
#define PIN_RELAY_1 6
#define PIN_RELAY_2 7
#define PIN_RELAY_3 8
#define PIN_RELAY_4 9

//  Serial vars
char inData[100];
char inChar = -1;
byte index = 0;
byte commandPos = -1;
int command[6];

//  Auto vars
byte AutoSensorTarget[4] = {0, 0, 0, 0};
byte AutoRelay[4] = {0, 0, 0, 0};
byte AutoRelayStatus[4] = {0, 0, 0, 0};
int AutoRelaySeconds[4] = {0, 0, 0, 0};
byte AutoTimerActive[4] = {0, 0, 0, 0};
unsigned long AutoTimer[4] = {0, 0, 0, 0};

void setup() {

  //  Start serial
  Serial.begin(9600);

  //  Initialize components
  pinMode(PIN_SENS_1, INPUT_PULLUP);
  pinMode(PIN_SENS_2, INPUT_PULLUP);
  pinMode(PIN_SENS_3, INPUT_PULLUP);
  pinMode(PIN_SENS_4, INPUT_PULLUP);
  pinMode(PIN_RELAY_1, OUTPUT);
  pinMode(PIN_RELAY_2, OUTPUT);
  pinMode(PIN_RELAY_3, OUTPUT);
  pinMode(PIN_RELAY_4, OUTPUT);

}

void loop() {

  checkSerial();
  checkSensors();
  manageTimers();
  delay(1);
  
}

void checkSerial() {

  if(Serial.available() > 0) {
    while (Serial.available() > 0) {
      inChar = Serial.read();
      if(inChar != '@'&& inChar != '#') {
        inData[index] = inChar;
        index++;
      } else if(inChar=='#') {
        commandPos++;
        command[commandPos] = atoi(inData);
        resetSerialString();
      } else if(inChar == '@') {
        switch(command[0]) {
          case 0:
            setRelay(command[1], command[2]);
          break;
          case 1:
            setSensor(command[1], command[2], command[3], command[4], command[5]);
          break;
        }
        commandPos = -1;
        resetSerialString();
      }
    }
  }
}

void checkSensors() {

  if(digitalRead(PIN_SENS_1) == AutoSensorTarget[0] && AutoTimerActive[0] == 0 && AutoRelay[0] != 0) {
    setRelay(AutoRelay[0], AutoRelayStatus[0]);
    if(AutoRelaySeconds[0] != 0) {
      AutoTimer[0] = millis();
      AutoTimerActive[0] = 1;
    }
  }

  if(digitalRead(PIN_SENS_2) == AutoSensorTarget[1] && AutoTimerActive[1] == 0 && AutoRelay[1] != 0) {
    setRelay(AutoRelay[1], AutoRelayStatus[1]);
    if(AutoRelaySeconds[1] != 0) {
      AutoTimer[1] = millis();
      AutoTimerActive[1] = 1;
    }
  }

  if(digitalRead(PIN_SENS_3) == AutoSensorTarget[2] && AutoTimerActive[2] == 0 && AutoRelay[2] != 0) {
    setRelay(AutoRelay[2], AutoRelayStatus[2]);
    if(AutoRelaySeconds[2] != 0) {
      AutoTimer[2] = millis();
      AutoTimerActive[2] = 1;
    }
  }

  if(digitalRead(PIN_SENS_4) == AutoSensorTarget[3] && AutoTimerActive[3] == 0 && AutoRelay[3] != 0) {
    setRelay(AutoRelay[3], AutoRelayStatus[3]);
    if(AutoRelaySeconds[3] != 0) {
      AutoTimer[3] = millis();
      AutoTimerActive[3] = 1;
    }
  }

}

void manageTimers() {

  for(int i=0;i<4;i++) {
    if(AutoTimerActive[i] == 1) {
      AutoTimer[i]++;
      if(millis() >= AutoTimer[i] + (AutoRelaySeconds[i] * 1000) ) {
        AutoTimer[i] = 0;
        AutoTimerActive[i] = 0;
        if(AutoRelayStatus[i] == 1) { setRelay(AutoRelay[i], 0); } else { setRelay(AutoRelay[i], 1); } 
      }
    }
  }
  
}

void setRelay(int address, int value) {

  switch(address) {
    case 1:
      digitalWrite(PIN_RELAY_1, value);
    break;
    case 2:
      digitalWrite(PIN_RELAY_2, value);
    break;
    case 3:
      digitalWrite(PIN_RELAY_3, value);
    break;
    case 4:
      digitalWrite(PIN_RELAY_4, value);
    break;
  }

}

void setSensor(int sensor, int relay, int target, int stat, int seconds) {

  sensor -= 1;
  AutoSensorTarget[sensor] = target;
  AutoRelay[sensor] = relay;
  AutoRelayStatus[sensor] = stat;
  AutoRelaySeconds[sensor] = seconds;
  
}

void resetSerialString() {

  index = 0;
  for(int i=0;i<100;i++) {inData[i] = '\0';}
  
}
