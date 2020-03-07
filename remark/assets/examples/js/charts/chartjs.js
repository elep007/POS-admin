/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(document, window, $) {
  'use strict';
  var Site = window.Site;

  $(document).ready(function($) {
    Site.run();
  });

  Chart.defaults.global.responsive = true;

  // Example Chartjs Bar
  // --------------------
  (function() {
    var barChartData = {
      labels: ["January", "February", "March", "April", "May"],
      scaleShowGridLines: true,
      scaleShowVerticalLines: false,
      scaleGridLineColor: "#ebedf0",
      barShowStroke: false,
      datasets: [{
        fillColor: $.colors("blue", 500),
        strokeColor: $.colors("blue", 500),
        highlightFill: $.colors("blue", 500),
        highlightStroke: $.colors("blue", 500),
        data: [65, 45, 75, 50, 60]
      }, {
        fillColor: $.colors("grey", 400),
        strokeColor: $.colors("grey", 400),
        highlightFill: $.colors("grey", 400),
        highlightStroke: $.colors("grey", 400),
        data: [30, 20, 40, 25, 45]
      }]
    };

    var myBar = new Chart(document.getElementById("exampleChartjsBar").getContext("2d")).Bar(barChartData);
  })();


})(document, window, jQuery);
