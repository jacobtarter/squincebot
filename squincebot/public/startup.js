var usonic=require('mmm-usonic');
usonic.init(function (error) {
    if (error) {
       console.log("error");
    } else {
       console.log(" no error");
var sensorf=usonic.createSensor(6,20,750);
var distancef=sensorf();
console.log("front" + distancef + " cm");
var sensorl=usonic.createSensor(13,16,950);
var distancel=sensorl();
console.log("left" + distancel + " cm");
//var sensorr=usonic.createSensor(17,27,750);
//var distancer=-1;
//console.log
//console.log(distancer)
//while(distancer<0)
//{
//  distancer=sensorr();
//  console.log(distancer);
//}
//console.log("right: " + distancer + " cm.");
//    }
}});
