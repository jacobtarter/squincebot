var express = require('express');
var router = express.Router();
var Gpio = require('onoff').Gpio,
  trigger = new Gpio(4, 'out'),
  echo = new Gpio(17, 'in');
var stats = require("stats-analysis")

router.get('/', function(req, res) {
    var exec = require('child_process').exec;
    var cmd = 'sudo python ultrasonic_2.py';

    exec(cmd, function(error, stdout, stderr) {
    var distances=(stdout);
    var distanceArray=distances.split(" ");
    noOutliers=stats.filterOutliers(distanceArray);
    var total=0;
    for(var i=0; i<noOutliers.length; i++)
    {
      total+=parseFloat(noOutliers[i]);
    }
    var response = total/noOutliers.length;
    var inches=(response*(1/2.54)).toFixed(2);

    res.json(inches);
  });

});


module.exports = router;
