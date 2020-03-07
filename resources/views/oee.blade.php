@extends('layouts.admin_layout')
@section('custom_css')
    <link rel="stylesheet" href="{{asset('remark/assets/examples/css/charts/chartjs.css')}}">
    <style>

        .paused_circle {
            width: 100px;
            height: 100px;
            background: #0070C0;
            border-radius: 50%;
            display: inline-block;
            float: left;
            margin-right: 100px;
            text-align: center;
            color: white;
            font-size: 14pt;
            padding-top: 100px;
            font-weight: bold;
        }


        .arrival_circle {
            width: 100px;
            height: 100px;
            background: #FFFF00;
            border-radius: 50%;
            display: inline-block;
            float: left;
            margin-right: 20px;
            text-align: center;
            color: white;
            font-size: 14pt;
            padding-top: 20px;
            font-weight: bold;
        }

        .normal_circle {
            width: 100px;
            height: 100px;
            background: #92D050;
            border-radius: 50%;
            display: inline-block;
            float: left;
            margin-right: 20px;
            text-align: center;
            color: white;
            font-size: 14pt;
            padding-top: 20px;
            font-weight: bold;
        }

        .downtime_circle {
            width: 100px;
            height: 100px;
            background: #FF0000;
            border-radius: 50%;
            display: inline-block;
            float: left;
            margin-right: 20px;
            text-align: center;
            color: white;
            font-size: 14pt;
            padding-top: 20px;
            font-weight: bold;
        }
    </style>
@endsection

@section('page_content')
    <!-- Page -->
    <div class="page animsition margin-0">
        <div class="page-content container-fluid padding-bottom-0">
            <div class="row-lg">
                <div class="col-md-8 col-sm-8">
                    <!-- Example Bar -->
                    <div class="example-wrap margin-bottom-5">
                        <div class="text-center padding-0" style="color: black; font-weight: bold; font-size: 10pt">
                            Yearly OEE Indicators <div class="margin-left-30 inline"  style="font-size: 8pt; font-family: normal"><span class="badge badge-radius badge-default" style="background-color: #0070C0; height: 15px; width: 15px; margin-right: 2px">.</span>Downtime</div>
                           <div class="margin-left-5 inline" style="font-size: 8pt; font-family: normal"><span class="badge badge-radius badge-default" style="background-color: #FF0000; height: 15px; width: 15px; margin-right: 2px">.</span>MTTR</div>
                           <div class="margin-left-5 inline" style="font-size: 8pt; font-family: normal"><span class="badge badge-radius badge-default" style="background-color: #92D050; height: 15px; width: 15px; margin-right: 2px">.</span>Uptime</div>
                           <div class="margin-left-5 inline" style="font-size: 8pt; font-family: normal"><span class="badge badge-radius badge-default" style="background-color: #8064A2; height: 15px; width: 15px; margin-right: 2px">.</span>SLT</div>
                        </div>
                        <div class="example text-center margin-0">
                            <canvas id="exampleChartjsBar" height="45" width="350"></canvas>
                        </div>
                    </div>
                    <!-- End Example Bar -->
                </div>



                <div class="col-md-4 col-sm-4">
                    <div class="example-wrap">
                        <div class="text-center padding-0 invisible"
                             style="color: black; font-weight: bold; font-size: 12pt">Yearly OEE Indicators
                        </div>
                        <div class="example text-center margin-0 pull-right">
                            <div class="panel inline-block margin-left-10"
                                 style="height: 80px; width: 160px; background-color: #0070C0">
                                <h3 class="white" id="lineHealthy"></h3>
                                <h5 class="white">Line Healthy(%)</h5>
                            </div>

                            <div class="panel inline-block  margin-left-10"
                                 style="height: 80px; width: 160px; background-color: #0070C0">
                                <h3 class="white" id="factoryHealthy"></h3>
                                <h5 class="white">Factory Healthy(%)</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 text-center text-bottom" style="margin-top: 60px">
                <span class="font-size-26 black" style="font-weight: bold" id="machine_name">Line 1 (Controller 1)</span>
            </div>
        </div>

        <div class="page-content">
            <div id="machine_container" class="row"></div>
        </div>


    </div>


@endsection

@section('custom_scripts')
    <script>

        /*!
     * remark (http://getbootstrapadmin.com/remark)
     * Copyright 2015 amazingsurge
     * Licensed under the Themeforest Standard Licenses
     */
        (function (document, window, $) {
            'use strict';
            var Site = window.Site;
            $(document).ready(function ($) {
                Site.run();
            });
            Chart.defaults.global.responsive = true;
            // Example Chartjs Bar
            // --------------------
            (function () {

                var mttr = JSON.parse('{{$mttr}}');
                var downtime = JSON.parse('{{$downtime}}');
                var uptime = JSON.parse('{{$uptime}}');
                var slt = JSON.parse('{{$slt}}');

                console.log(mttr);

                var barChartData = {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    scaleShowGridLines: true,
                    scaleShowVerticalLines: false,
                    scaleGridLineColor: "#ebedf0",
                    barShowStroke: false,
                    datasets: [

                        {
                        fillColor: '#FF0000',
                        strokeColor: '#FF0000',
                        highlightFill: '#FF0000',
                        highlightStroke: '#FF0000',
                        data: mttr,
                        },
                        {
                            fillColor: '#0070C0',
                            strokeColor: '#0070C0',
                            highlightFill: '#0070C0',
                            highlightStroke: '#0070C0',
                            data: downtime
                        },
                        {
                            fillColor: '#92D050',
                            strokeColor: '#92D050',
                            highlightFill: '#92D050',
                            highlightStroke: '#92D050',
                            data: uptime
                        },

                        {
                            fillColor: '#8064A2',
                            strokeColor: '#8064A2',
                            highlightFill: '#8064A2',
                            highlightStroke: '#8064A2',
                            data: slt
                        }
                    ]
                };
                var myBar = new Chart(document.getElementById("exampleChartjsBar").getContext("2d")).Bar(barChartData);
            })();

            var machineContainer = $('#machine_container');
            var idCategoryName = $('#machine_name');

            var groupCategories = [];
            var categoryLength = 0;
            var i = 0;

            getGroups();

            function getMachines(category) {
                $.ajax({
                    type: "POST",
                    url: '{{url('getMachines')}}',
                    data: {
                        _token : '{{csrf_token()}}',
                        category: category
                    },
                    dataType: 'json',
                    success: function (data) {
                        machineContainer.empty();
                        data.results.map((item) => {

                            var out = '<div class="col-md-3">';
                            out += '<div class="panel panel-bordered">';
                            out += '<div class="panel-body padding-15">';

                            switch (item.status) {
                                case "Open":
                                    out += '<div class="downtime_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Downtime</span>';
                                    break;
                                case "WIP":
                                    out += '<div class="arrival_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Arrival</span>';
                                    break;
                                case "Pause":
                                    out += '<div class="paused_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Paused</span>';
                                    break;

                                case "Resume":
                                    out += '<div class="normal_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Resume</span>';
                                    break;

                                case "Resolved":
                                    out += '<div class="normal_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Resolved</span>';
                                    break;

                                default:
                                    out += '<div class="normal_circle">'+ item.machine_name +'</div>';
                                    out += '<div style="float: left">';
                                    out += '<span class="block black font-size-15" style="font-weight: bold">Pending</span>';

                            }
                            out += '<span class="block black font-size-15">MTTR:'+ item.mttr +'</span>';
                            out += '<span class="block black font-size-15">AT: '+ item.at +'</span>';
                            out += '<span class="block black font-size-15">SLT: '+ item.slt +'</span>';
                            out += '</div>';
                            out += '</div>';
                            out += '</div>';
                            out += '</div>';
                            machineContainer.append(out);
                        });
                    },
                    error: function(){}
                });

            }


            async function getGroups() {
                $.ajax({
                    type: "POST",
                    url: '{{url('getGroups')}}',
                    data: {
                        _token : '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: await function (data) {
                        groupCategories = data.results;
                        categoryLength = groupCategories.length;

                    },
                    error: function () {}
                });
            }

            var firstInterVal =  setInterval(function() {
                getMachines(groupCategories[i]);
                getLineHealthy(groupCategories[i]);
                idCategoryName.text(groupCategories[i].category);
                factoryHealthy();
                i++;
                clearInterval(firstInterVal);
            }, 1000);


            var x = setInterval(function() {
                getMachines(groupCategories[i]);
                getLineHealthy(groupCategories[i]);
                idCategoryName.text(groupCategories[i].category);
                if (i === categoryLength - 1){
                    getGroups();
                    factoryHealthy();
                    i = -1;
                }
                i++;
            }, 1000 * 60);




            function getLineHealthy(category) {
                $.ajax({
                    type: "POST",
                    url: '{{url('getLineHealthy')}}',
                    data: {
                        _token : '{{csrf_token()}}',
                        category: category
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#lineHealthy').text(data.results + '%');
                    },
                    error: function () {}
                });
            }



            function factoryHealthy() {
                $.ajax({
                    type: "POST",
                    url: '{{url('factoryHealthy')}}',
                    data: {
                        _token : '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#factoryHealthy').text(data.results + "%");
                    },
                    error: function () {}
                });
            }





        })(document, window, jQuery);
    </script>

@endsection


