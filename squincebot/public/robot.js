
    var motorSpeedResolution=25; //Lower resolution = faster cycles, theoretically smoother
    //var motorPulseStartUp=(motorPulseOn-25); //This will work unless we change rampUp
    //var rampUp=50;
    //var driveCounter=0;
    /*
    Previous 3 lines were used to "ramp up" the speed, but the "pulse" nature of my logic makes this unnecessary
    */
    var driveLoopCounter=0; //Used to count cycles. Every so many cycles we check forward.
    var loop; //This is used for the main moveForward loop. variable must be set ahead of time.
    var motorsStopped=true;  //Used to keep track of if the motors are enabled.  Only need to restart the drive loop if they are stopped

    //Variables for motor speeds. As object in fornt gets closer, speed drops.
    //Speed is out of the Resolution. 25=full speed, as 25 is the current resolution set.
    //Speeds of around 10 will no longer make the rover move I have found, which is why the DANGER is set to 15
    var MOTORDANGER=15;
    var MOTORCLOSE=18;
    var MOTORMID=20;
    var MOTORFAR=25;

    var motorPulseOn=MOTORDANGER;    //Start motors up with lowest speed


    //module for reading from distance sensors
    var usonic = require('mmm-usonic');
    //module for "stats & analysis".  I use this to get rid of outliers within my distance readings
    var stats = require("stats-analysis")


    //Setup the distance sensors, display a reading
    usonic.init(function(error) {
        if (error) {
            console.log("error");
        } else {
            console.log(" no error");
            var sensorf = usonic.createSensor(6, 20, 750);
            var distancef = sensorf();
            console.log("front" + distancef + " cm");
            var sensorl = usonic.createSensor(13, 16, 950);
            var distancel = sensorl();
            console.log("left" + distancel + " cm");
        }
    });

    //Setup the GPIO pins
    var Gpio = require('onoff').Gpio,
        motorSpeedRight = new Gpio(18, 'out'), //Output for signalling L298N
        motorEnableBackwardRight = new Gpio(23, 'out'),
        motorEnableForwardRight = new Gpio(24, 'out'),

        motorSpeedLeft = new Gpio(17, 'out'),
        motorEnableForwardLeft = new Gpio(27, 'out'),
        motorEnableBackwardLeft = new Gpio(22, 'out'),

        //led = new Gpio(17, 'out');

        //Set this as input from bump sensor
        button = new Gpio(4, 'in', 'falling');



    //used for bumper - to help debounce input
    var last=0;

    var _ = require('lodash'); //module - used for throttle function, has many other features though
    //Watch event - if bumper is triggered, interrupt main loop
    //the _.throttle function is used to help debounce input.
    button.watch(_.throttle(function(err, state) {
      if (err)
      {
          throw err;
      }
      if (state != last)
      {
        if (state == 1)
        {
            //Bumper button pressed//
            last = state;
            bumpEvent();
        }
        else
        {
            //state=0, bumper not pressed//
            last=state;
            if(motorsStopped) //If motors were stopped, get them going again
            {
              getMovin();
            }
        }
      }
    }, 100));

    //main "DRIVE" function. This is put on a loop, and the timeout of the loop determines how long of an "ON PULSE"
    //the motors get.
    drive=function(){
    motorSpeedRight.writeSync(1);
    motorSpeedLeft.writeSync(1);
      setTimeout(function() {motorSpeedRight.writeSync(0); }, motorPulseOn);
      setTimeout(function() {motorSpeedLeft.writeSync(0); }, motorPulseOn);
    }

    //checks the counter, every 25 cycles we stop and check forward sensor.
    checkDrive=function() {
      stopCounter=0;
      driveLoopCounter++;

      if(driveLoopCounter==25)
        {
          driveLoopCounter=0
          checkLeft();
          checkForward();
        }
        else {
          drive();
        }

    }

    //Gets the "drive" function running within a loop.  the loop recalls in time with the "resolution" variable.
    //Currently we run the drive function every 25 ms. Changing the resolution variable can speed up or slow down how
    //often the loop is recalled, which in turn will effect the way the speeds operate
    getMovin=function() {
      //Get drive function running on loop
      console.log("movin");
      motorSpeedRight.writeSync(1);
      motorSpeedLeft.writeSync(1);

      motorEnableForwardRight.writeSync(1);
      motorEnableForwardLeft.writeSync(1);
      motorsStopped=false;

      //console.log(motorSpeedRight.readSync());
      //console.log(motorEnableForwardRight.readSync());
      loop = setInterval(checkDrive, motorSpeedResolution);
    }

    //Stop all motors. Used when bupmer is triggered.
    stopMotors=function() {
      console.log("stop!");
      motorsStopped=true;
      clearInterval(loop);

      motorEnableForwardRight.writeSync(0);
      motorEnableForwardLeft.writeSync(0);

      motorEnableBackwardRight.writeSync(0);
      motorEnableBackwardLeft.writeSync(0);

      motorSpeedRight.writeSync(0);
      motorSpeedLeft.writeSync(0);
    }

    //Stop all motors. Is used when distance reading shows object is too close.
    distanceStopMotors=function() {
      console.log("stop!");
      motorsStopped=true;
      clearInterval(loop);

      motorEnableForwardRight.writeSync(0);
      motorEnableForwardLeft.writeSync(0);

      motorEnableBackwardRight.writeSync(0);
      motorEnableBackwardLeft.writeSync(0);

      motorSpeedRight.writeSync(0);
      motorSpeedLeft.writeSync(0);

      checkForward();


    }
    enableReverse=function() {
      console.log("back it UPPP");
      var start = +new Date();
      motorEnableBackwardRight.writeSync(1);
      motorEnableBackwardLeft.writeSync(1);

      motorSpeedRight.writeSync(1);
      motorSpeedLeft.writeSync(1);
      var end= +new Date();
      while((end - start)<500)
      {
        var end= + new Date();
      }
      if ((end - start)>=500)
      {
        stopMotors();
      }
      //setTimeout(function(){ stopMotors(); }, 500);
      console.log('done backin up');

    }

    bumpEvent=function() {
        //Stop the drive loop
        clearInterval(loop);
        driveCounter=0;
        console.log("HIT SOMETHING WITH BUMPER");
        //Kill forward motor movement
        stopMotors();
        //Pulse reverse to get off the wall
        enableReverse();
        closeDistanceEvent();

    //	leftOrRight();
    }
    closeDistanceEvent=function( ){
      console.log("GETTIN TOO CLOSE");
      clearInterval(loop);
      stopMotors();
      //motorEnableForwardLeft.writeSync(1);
      //motorEnableBackwardRight.writeSync(1);
      var start = +new Date();
      var end= +new Date();

      var sensorl = usonic.createSensor(13,16,750);
      //Setup an array, take 5 readings
      var distanceArray=[];
      for(var i=0; i<5; i++)
      {
        var reading = sensorl();
        if (reading<1000) //only take reading if less than 1000cm. above this is most likely a false read
        {
          distanceArray.push(reading);
        }
      }
      noOutliers=stats.filterOutliers(distanceArray); //use stats&analysis module to remove statistical outliers from set
      var total=0;
      //console.log("filtered out " + (5-noOutliers.length) + " outliers"); //just for fun
      for(var i=0; i<noOutliers.length; i++)  //average out the remainders
      {
        total+=parseFloat(noOutliers[i]); //add em up
      }
      var response = total/noOutliers.length; //divide by total for average
      console.log('distance to left: ' + response);
      /*
      if(response>50)
      {

          motorEnableBackwardLeft.writeSync(1);
          motorEnableForwardRight.writeSync(1);
        console.log("Corner? Rotating left!");
        while((end - start)<600)
        {

          motorSpeedLeft.writeSync(1);
          motorSpeedRight.writeSync(1);
          end= +new Date();
        }
        if((end - start)>=600)
        {
          motorEnableBackwardLeft.writeSync(0);

          motorEnableForwardLeft.writeSync(1);
          motorEnableForwardRight.writeSync(1);
          console.log("done rotating");
            checkForward();
        }

      }
      */

        console.log("Corner? Rotating right!");
        while((end - start)<600)
        {
          motorEnableForwardLeft.writeSync(1);
          motorEnableBackwardRight.writeSync(1);
          motorSpeedLeft.writeSync(1);
          motorSpeedRight.writeSync(1);
          end= +new Date();
        }
        if((end - start)>=600)
        {
          motorEnableBackwardRight.writeSync(0);

          motorEnableForwardLeft.writeSync(1);
          motorEnableForwardRight.writeSync(1);
          console.log("done rotating");
            checkForward();
        }





    }



    checkLeft=function(){

      var sensorl = usonic.createSensor(13,16,750);
      //Setup an array, take 5 readings
      var distanceArray=[];
      for(var i=0; i<5; i++)
      {
        var reading = sensorl();
        if (reading<1000) //only take reading if less than 1000cm. above this is most likely a false read
        {
          distanceArray.push(reading);
        }
      }
      noOutliers=stats.filterOutliers(distanceArray); //use stats&analysis module to remove statistical outliers from set
      var total=0;
      //console.log("filtered out " + (5-noOutliers.length) + " outliers"); //just for fun
      for(var i=0; i<noOutliers.length; i++)  //average out the remainders
      {
        total+=parseFloat(noOutliers[i]); //add em up
      }
      var response = total/noOutliers.length; //divide by total for average
      console.log("DISTANCE TO LEFT WALL: " + response + " cm.");
      //If left wall greater than 45cm away, push towards it by pulsing only right wheel
      if(response>35){
        var start = +new Date();
        var end= +new Date();
        console.log("pushing towards left wall");
        while((end - start)<250)
        {
          var end= + new Date();
          motorEnableForwardLeft.writeSync(0);
          motorEnableForwardRight.writeSync(1);
          //motorEnableForwardLeft.writeSync(1);
          motorSpeedRight.writeSync(1);

        }
        if ((end - start)>=250)
        {
          console.log("done with pushing towards wall");
          motorEnableForwardLeft.writeSync(1);

        }
      }
      if(response>50)
      {
        var start = +new Date();
        var end= +new Date();
        console.log("pushing towards left wall again, extra hard");
        while((end - start)<250)
        {
          var end= + new Date();
          motorEnableForwardLeft.writeSync(0);
          motorEnableForwardRight.writeSync(1);
          //motorEnableForwardLeft.writeSync(1);
          motorSpeedRight.writeSync(1);

        }
        if ((end - start)>=250)
        {
          console.log("done with pushing towards wall again");
          motorEnableForwardLeft.writeSync(1);

        }
      }
      //if left wall less than 30cm away,pull away from it by pulsing only left wheel
      else if (response<25) {
        //stopMotors();
        var start = +new Date();
        var end= +new Date();
        console.log("pulling away from left wall");
        while((end - start)<250)
        {
          var end= + new Date();
          motorEnableForwardRight.writeSync(0);

          motorEnableForwardLeft.writeSync(1);
          //motorEnableForwardLeft.writeSync(1);
          motorSpeedLeft.writeSync(1);

        }
        if ((end - start)>=250)
        {
          motorEnableForwardRight.writeSync(1);

          console.log("done with pulling away from wall");
        }
      }
      //else, in the middle = all good
      else {
        console.log("Left wall RIGHT WHERE I WANT IT");
      }

    }
    //function for checking forward distance sensor. main distance sensing function.
    checkForward=function() {
      var sensorf = usonic.createSensor(6, 20, 750);

      //Setup an array, take 8 readings
      var distanceArray=[];
      for(var i=0; i<8; i++)
      {
        var reading = sensorf();
        if (reading<1000) //only take reading if less than 1000cm. above this is most likely a false read
        {
          distanceArray.push(reading);
        }
      }
      noOutliers=stats.filterOutliers(distanceArray); //use stats&analysis module to remove statistical outliers from set
      var total=0;
      console.log("filtered out " + (8-noOutliers.length) + " outliers"); //just for fun
      for(var i=0; i<noOutliers.length; i++)  //average out the remainders
      {
        total+=parseFloat(noOutliers[i]); //add em up
      }
      var response = total/noOutliers.length; //divide by total for average

      if(response>30) //if response is "CLEAR"
      {

        console.log("all clear: " + response + " cm away.");
        //adjust speed based on forward distance clear
        if(response<50)
        {
          motorPulseOn=MOTORDANGER;
          console.log("danger speed");
        }
        else if (response<75){
          motorPulseOn=MOTORCLOSE;
          console.log("close speed");


        }
        else if(response<100){
          motorPulseOn=MOTORMID;
          console.log("mid speed");
        }
        else if (response>100)
        {
          motorPulseOn=MOTORFAR;
          console.log("far - top speed");
        }
        if(motorsStopped)
        {
          getMovin();
          console.log("start back up");
        }
      }

      else {
          console.log("DANGER: " + response + " cm away.");
          closeDistanceEvent();
      }
    }

    getMovin();
  startUp=function(){

      console.log("get movin...");
    }


    process.on('SIGINT', function () {
      console.log("exit...");
      motorSpeedRight.unexport();
      motorSpeedLeft.unexport();

      motorEnableBackwardRight.unexport();
      motorEnableBackwardLeft.unexport();

      motorEnableForwardRight.unexport();
      motorEnableForwardLeft.unexport();

    })
