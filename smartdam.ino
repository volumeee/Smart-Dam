#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include "base64.h"
#include <WiFiClient.h>
#include <Servo.h>

#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);


WiFiClient wifiClient;

// Setup WiFi network
//const char* ssid = "MYPCONEPROK7 8321";
//const char* password = "12345678";
const char* ssid = "";
const char* password = "";

// read sensor
const int sensorPin = A0;
int speakerPin = D8;
int state = 0;
int trig_pin = D7;
int echo_pin = D6;
long echotime; 
float distance;

// Twilio Parameter
String account_sid = "";
String auth_token = "";
String from = "";
String to = "";

String status_air;

Servo myservo;  // create servo object to control a servo
int pos = 0;    // variable to store the servo position
int tinggi_sensor = 16;
int ketinggian = 0;





void setup() {
 
  Serial.begin(115200);

  

//lcd.begin();

//lcd.setCursor(0,0);
 // lcd.print("KETINGGIAN = ");
//lcd.setCursor(0,1);
 // lcd.print("STATUS AIR = ");


 
 myservo.write(0);  
  WiFi.begin(ssid, password);
  
  pinMode(sensorPin,INPUT);
  pinMode(speakerPin, OUTPUT);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi..");
  }
 
  Serial.println("Connected to WiFi");


  pinMode(trig_pin, OUTPUT); 
  pinMode(echo_pin, INPUT);
  digitalWrite(trig_pin, LOW);  
 
   


    myservo.attach(4,500,2400);  // attaches the servo on pin 13 to the servo object

  
}
 
void loop() {


digitalWrite(trig_pin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig_pin, LOW);
  echotime= pulseIn(echo_pin, HIGH);
  distance= 0.0001*((float)echotime*340.0)/2.0;

  ketinggian = tinggi_sensor - distance;


  Serial.println("echo time: "+echotime);
  
  if(ketinggian <=2) {
     

      
    status_air = "Siaga 3";
    String body = " Peringatan bendungan!  Status Bendungan: "+status_air+". Ketinggian air pada siaga 3: ";
      
 //     lcd.setCursor(0,0);
 // lcd.print("KETINGGIAN = "+String(ketinggian));
 // lcd.setCursor(0,1);
 // lcd.print("STATUS ="+String(status_air));


      if ((WiFi.status() == WL_CONNECTED)) { //Check the current connection status
     
        HTTPClient http;
     
        int nilai = random(29,37);
        String data = (String) nilai;
       String link = "http://api.thingspeak.com/apps/thingtweet/1/statuses/update";
        http.begin(wifiClient,link);
        String tweet = "api_key=xxxxxxxxxx&status="+ body + ketinggian+" cm";
        int httpCode = http.POST(tweet); 

        String link2 = "http://.com";        
        http.begin(wifiClient,link2);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");  //Specify content-type headerint httpCode = http.GET();

         data = "message_sent="+  body+ketinggian+ "&jarak="+  ketinggian;
        int httpCode2 = http.POST(data);
        
        Serial.println(httpCode);
        
   
        if (httpCode2 > 0) { //Check for the returning code
            
                   Serial.print("ketinggian = ");
            Serial.println(ketinggian);
             Serial.print("tinggi sensor = ");
            Serial.println(tinggi_sensor);
             Serial.print("jarak = ");
            Serial.println(distance);
            
            Serial.println("-----------------------------------------");


            String payload = http.getString();
          
            Serial.println("response untuk http code wa");
            //Serial.println(link);
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("-----------------------------------------");
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("response untuk http code database");
            Serial.println(link2);
            Serial.println(httpCode2);

          

            
            Serial.println(payload);
        }
        else {
            Serial.println("Error on HTTP request");
        }
        http.end();
      }
      digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);


      
  } else if(ketinggian > 2 && ketinggian <=4 ) {
     
    status_air = "Siaga 2";
    String body = " Peringatan bendungan!  Status Bendungan: "+status_air+". Ketinggian air pada siaga 2: ";
        
//      lcd.setCursor(0,0);
//  lcd.print("KETINGGIAN = "+String(ketinggian));
//lcd.setCursor(0,1);
//  lcd.print("STATUS ="+String(status_air));


      if ((WiFi.status() == WL_CONNECTED)) { //Check the current connection status
     
        HTTPClient http;
     
        int nilai = random(29,37);
        String data = (String) nilai;
       String link = "http://api.thingspeak.com/apps/thingtweet/1/statuses/update";
        http.begin(wifiClient,link);
        String tweet = "api_key=xxxxxxxxxx&status=" + body + ketinggian + " cm";
        int httpCode = http.POST(tweet); 

          String link2 = "http:.com";        
        http.begin(wifiClient,link2);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");  //Specify content-type headerint httpCode = http.GET();

         data = "message_sent="+  body+ketinggian+ "&jarak="+  ketinggian;
        int httpCode2 = http.POST(data);
        
        Serial.println(httpCode);

    
        
        if (httpCode2 > 0) { //Check for the returning code
            
              Serial.print("ketinggian = ");
            Serial.println(ketinggian);
             Serial.print("tinggi sensor = ");
            Serial.println(tinggi_sensor);
             Serial.print("jarak = ");
            Serial.println(distance);
            Serial.println("-----------------------------------------");


            String payload = http.getString();
          
            Serial.println("response untuk http code wa");
           /// Serial.println(link);
            Serial.println(httpCode);
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("-----------------------------------------");
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("response untuk http code database");
            Serial.println(link2);
            Serial.println(httpCode2);

            
            Serial.println(payload);
        }
        else {
            Serial.println("Error on HTTP request");
        }
        http.end();
      }
      digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);
      digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);

      
  }else if(ketinggian > 4 ) {
    status_air = "Siaga 1";
    String body = " Peringatan bendungan!  Status Bendungan: "+status_air+". Ketinggian air pada siaga 1: ";
 //    lcd.setCursor(0,0);
 // lcd.print("KETINGGIAN = "+String(ketinggian));
//lcd.setCursor(0,1);
 // lcd.print("STATUS ="+String(status_air));


      if ((WiFi.status() == WL_CONNECTED)) { //Check the current connection status


      

     
        HTTPClient http;
     
        int nilai = random(29,37);
        String data = (String) nilai;
      String link = "http://api.thingspeak.com/apps/thingtweet/1/statuses/update";
        http.begin(wifiClient,link);
        String tweet = "api_key=xxxxxxxxxx&status=" + body + ketinggian + " cm";
        int httpCode = http.POST(tweet); 

          String link2 = "http://.com";    
        http.begin(wifiClient,link2);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");  //Specify content-type headerint httpCode = http.GET();

         data = "message_sent="+  body+ketinggian+ "&jarak="+  ketinggian;
        int httpCode2 = http.POST(data);
        
        Serial.println(httpCode);
   
        if (httpCode2 > 0) { //Check for the returning code
            
            Serial.print("ketinggian = ");
            Serial.println(ketinggian);
             Serial.print("tinggi sensor = ");
            Serial.println(tinggi_sensor);
             Serial.print("jarak = ");
            Serial.println(distance);
            Serial.println("-----------------------------------------");

        
        
        
            String payload = http.getString();
          
            Serial.println("response untuk http code wa");
            //Serial.println(link);
            Serial.println(httpCode);
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("-----------------------------------------");
            Serial.println("  ");
            Serial.println("  ");
            Serial.println("response untuk http code database");
            Serial.println(link2);
            Serial.println(httpCode2);

            
            Serial.println(payload);
        }
        else {
            Serial.println("Error on HTTP request");
        }
        http.end();
         digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);

        digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);

        digitalWrite(speakerPin, HIGH);
      delay(500);
      digitalWrite(speakerPin, LOW);
      delay(500);


      
    for (pos = 180; pos >= 0; pos -= 1) { // goes from 180 degrees to 0 degrees
          myservo.write(pos);              // tell servo to go to position in variable 'pos'
          delay(30);                       // waits 15ms for the servo to reach the position
        }


      
          // in steps of 1 degree
         for (pos = 0; pos <= 180; pos += 1) { // goes from 0 degrees to 180 degrees
          // in steps of 1 degree
          myservo.write(pos);              // tell servo to go to position in variable 'pos'
          delay(15);                       // waits 15ms for the servo to reach the position
        }

      
     

        
      }
     
  }
  delay(500);
 
}