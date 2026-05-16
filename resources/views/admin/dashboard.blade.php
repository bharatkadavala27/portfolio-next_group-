@extends('layouts.admin')

@section('content')



<body onload="startTime()">

<div class="page-title">
  <div class="row">
    <div class="col-6">
      <h3>Default</h3>
    </div>
    <div class="col-6">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
        <li class="breadcrumb-item">Dashboard</li>
        <li class="breadcrumb-item active">Default</li>
      </ol>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row second-chart-list third-news-update">
    <div class="col-xl-4 col-lg-12 xl-50 morning-sec box-col-12">
      <div class="card o-hidden profile-greeting">
        <div class="card-body">
          <div class="media">
            <div class="badge-groups w-100">
              <div class="badge f-12"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock me-1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><span id="txt">10:20 AM</span></div>
              <div class="badge f-12"><i class="fa fa-spin fa-cog f-14"></i></div>
            </div>
          </div>
          <div class="greeting-user text-center">
            <div class="profile-vector"><img class="img-fluid" src="../assets/images/dashboard/welcome.png" alt=""></div>
            <h4 class="f-w-600"><span id="greeting">Good Morning</span> <span class="right-circle"><i class="fa fa-check-circle f-14 middle"></i></span></h4>
            <p><span> Today's earrning is $405 &amp; your sales increase rate is 3.7 over the last 24 hours</span></p>
            <div class="whatsnew-btn"><a class="btn btn-primary">Whats New !</a></div>
            <div class="left-icon"><i class="fa fa-bell"> </i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0">
          <div class="row m-0">
            <div class="col-xl-3 earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>Dashboard</h5>
                  <p class="font-roboto">Overview of last month</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>$4055.56 </h5>
                  <p class="font-roboto">This Month Earning</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>$1004.11</h5>
                  <p class="font-roboto">This Month Profit</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>90%</h5>
                  <p class="font-roboto">This Month Sale</p>
                </div>
                <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">Summary</a></div>
              </div>
            </div>
            <div class="col-xl-9 p-0">
              <div class="chart-right">
                <div class="row m-0 p-tb">
                  <div class="col-xl-8 col-md-8 col-sm-8 col-12 p-0">
                    <div class="inner-top-left">
                      <ul class="d-flex list-unstyled">
                        <li>Daily</li>
                        <li class="active">Weekly</li>
                        <li>Monthly</li>
                        <li>Yearly</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md-4 col-sm-4 col-12 p-0 justify-content-end">
                    <div class="inner-top-right">
                      <ul class="d-flex list-unstyled justify-content-end">
                        <li>Online</li>
                        <li>Store</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-12">
                    <div class="card-body p-0">
                      <div class="current-sale-container" style="position: relative;">
                        <div id="chart-currently" style="min-height: 255px;"><div id="apexcharts8l1quwm3" class="apexcharts-canvas apexcharts8l1quwm3 light" style="width: 949px; height: 240px;"><svg id="SvgjsSvg1224" width="949" height="240" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1226" class="apexcharts-inner apexcharts-graphical" transform="translate(0, -10)"><defs id="SvgjsDefs1225"><clipPath id="gridRectMask8l1quwm3"><rect id="SvgjsRect1230" width="953" height="229" x="-2" y="-2" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMask8l1quwm3"><rect id="SvgjsRect1231" width="951" height="227" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><linearGradient id="SvgjsLinearGradient1237" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1238" stop-opacity="0.7" stop-color="rgba(115,102,255,0.7)" offset="0"></stop><stop id="SvgjsStop1239" stop-opacity="0.5" stop-color="rgba(255,255,255,0.5)" offset="0.8"></stop><stop id="SvgjsStop1240" stop-opacity="0.5" stop-color="rgba(255,255,255,0.5)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1246" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1247" stop-opacity="0.7" stop-color="rgba(247,49,100,0.7)" offset="0"></stop><stop id="SvgjsStop1248" stop-opacity="0.5" stop-color="rgba(255,255,255,0.5)" offset="0.8"></stop><stop id="SvgjsStop1249" stop-opacity="0.5" stop-color="rgba(255,255,255,0.5)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1229" x1="0" y1="0" x2="0" y2="225" stroke="#b6b6b6" stroke-dasharray="3" class="apexcharts-xcrosshairs" x="0" y="0" width="1" height="225" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1252" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1253" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1255" class="apexcharts-grid"><line id="SvgjsLine1257" x1="0" y1="225" x2="949" y2="225" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1256" x1="0" y1="1" x2="0" y2="225" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1233" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1243" class="apexcharts-series" seriesName="series2" data:longestSeries="true" rel="2" data:realIndex="1"><path id="SvgjsPath1250" d="M 0 225L 0 217.5C 27.679166666666664 217.5 51.40416666666667 142.5 79.08333333333333 142.5C 106.76249999999999 142.5 130.48749999999998 93.75 158.16666666666666 93.75C 185.84583333333333 93.75 209.57083333333333 105 237.25 105C 264.9291666666667 105 288.65416666666664 75 316.3333333333333 75C 344.0125 75 367.7375 131.25 395.4166666666667 131.25C 423.09583333333336 131.25 446.8208333333333 37.5 474.5 37.5C 502.1791666666667 37.5 525.9041666666667 82.5 553.5833333333334 82.5C 581.2625 82.5 604.9875 67.5 632.6666666666666 67.5C 660.3458333333333 67.5 684.0708333333333 120 711.75 120C 739.4291666666667 120 763.1541666666667 150 790.8333333333334 150C 818.5125 150 842.2375 56.25 869.9166666666666 56.25C 897.5958333333333 56.25 921.3208333333333 225 949 225C 949 225 949 225 949 225M 949 225z" fill="url(#SvgjsLinearGradient1246)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMask8l1quwm3)" pathTo="M 0 225L 0 217.5C 27.679166666666664 217.5 51.40416666666667 142.5 79.08333333333333 142.5C 106.76249999999999 142.5 130.48749999999998 93.75 158.16666666666666 93.75C 185.84583333333333 93.75 209.57083333333333 105 237.25 105C 264.9291666666667 105 288.65416666666664 75 316.3333333333333 75C 344.0125 75 367.7375 131.25 395.4166666666667 131.25C 423.09583333333336 131.25 446.8208333333333 37.5 474.5 37.5C 502.1791666666667 37.5 525.9041666666667 82.5 553.5833333333334 82.5C 581.2625 82.5 604.9875 67.5 632.6666666666666 67.5C 660.3458333333333 67.5 684.0708333333333 120 711.75 120C 739.4291666666667 120 763.1541666666667 150 790.8333333333334 150C 818.5125 150 842.2375 56.25 869.9166666666666 56.25C 897.5958333333333 56.25 921.3208333333333 225 949 225C 949 225 949 225 949 225M 949 225z" pathFrom="M -1 225L -1 225L 79.08333333333333 225L 158.16666666666666 225L 237.25 225L 316.3333333333333 225L 395.4166666666667 225L 474.5 225L 553.5833333333334 225L 632.6666666666666 225L 711.75 225L 790.8333333333334 225L 869.9166666666666 225L 949 225"></path><path id="SvgjsPath1251" d="M 0 217.5C 27.679166666666664 217.5 51.40416666666667 142.5 79.08333333333333 142.5C 106.76249999999999 142.5 130.48749999999998 93.75 158.16666666666666 93.75C 185.84583333333333 93.75 209.57083333333333 105 237.25 105C 264.9291666666667 105 288.65416666666664 75 316.3333333333333 75C 344.0125 75 367.7375 131.25 395.4166666666667 131.25C 423.09583333333336 131.25 446.8208333333333 37.5 474.5 37.5C 502.1791666666667 37.5 525.9041666666667 82.5 553.5833333333334 82.5C 581.2625 82.5 604.9875 67.5 632.6666666666666 67.5C 660.3458333333333 67.5 684.0708333333333 120 711.75 120C 739.4291666666667 120 763.1541666666667 150 790.8333333333334 150C 818.5125 150 842.2375 56.25 869.9166666666666 56.25C 897.5958333333333 56.25 921.3208333333333 225 949 225" fill="none" fill-opacity="1" stroke="#f73164" stroke-opacity="1" stroke-linecap="butt" stroke-width="4" stroke-dasharray="0" class="apexcharts-area" index="1" clip-path="url(#gridRectMask8l1quwm3)" pathTo="M 0 217.5C 27.679166666666664 217.5 51.40416666666667 142.5 79.08333333333333 142.5C 106.76249999999999 142.5 130.48749999999998 93.75 158.16666666666666 93.75C 185.84583333333333 93.75 209.57083333333333 105 237.25 105C 264.9291666666667 105 288.65416666666664 75 316.3333333333333 75C 344.0125 75 367.7375 131.25 395.4166666666667 131.25C 423.09583333333336 131.25 446.8208333333333 37.5 474.5 37.5C 502.1791666666667 37.5 525.9041666666667 82.5 553.5833333333334 82.5C 581.2625 82.5 604.9875 67.5 632.6666666666666 67.5C 660.3458333333333 67.5 684.0708333333333 120 711.75 120C 739.4291666666667 120 763.1541666666667 150 790.8333333333334 150C 818.5125 150 842.2375 56.25 869.9166666666666 56.25C 897.5958333333333 56.25 921.3208333333333 225 949 225" pathFrom="M -1 225L -1 225L 79.08333333333333 225L 158.16666666666666 225L 237.25 225L 316.3333333333333 225L 395.4166666666667 225L 474.5 225L 553.5833333333334 225L 632.6666666666666 225L 711.75 225L 790.8333333333334 225L 869.9166666666666 225L 949 225"></path><g id="SvgjsG1244" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1263" r="0" cx="0" cy="0" class="apexcharts-marker wzunw9vcb no-pointer-events" stroke="#f73164" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1245" class="apexcharts-datalabels"></g></g><g id="SvgjsG1234" class="apexcharts-series" seriesName="series1" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1241" d="M 0 225L 0 202.5C 27.679166666666664 202.5 51.40416666666667 150 79.08333333333333 150C 106.76249999999999 150 130.48749999999998 168.75 158.16666666666666 168.75C 185.84583333333333 168.75 209.57083333333333 75 237.25 75C 264.9291666666667 75 288.65416666666664 157.5 316.3333333333333 157.5C 344.0125 157.5 367.7375 150 395.4166666666667 150C 423.09583333333336 150 446.8208333333333 157.5 474.5 157.5C 502.1791666666667 157.5 525.9041666666667 138.75 553.5833333333334 138.75C 581.2625 138.75 604.9875 157.5 632.6666666666666 157.5C 660.3458333333333 157.5 684.0708333333333 93.75 711.75 93.75C 739.4291666666667 93.75 763.1541666666667 112.5 790.8333333333334 112.5C 818.5125 112.5 842.2375 18.75 869.9166666666666 18.75C 897.5958333333333 18.75 921.3208333333333 225 949 225C 949 225 949 225 949 225M 949 225z" fill="url(#SvgjsLinearGradient1237)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask8l1quwm3)" pathTo="M 0 225L 0 202.5C 27.679166666666664 202.5 51.40416666666667 150 79.08333333333333 150C 106.76249999999999 150 130.48749999999998 168.75 158.16666666666666 168.75C 185.84583333333333 168.75 209.57083333333333 75 237.25 75C 264.9291666666667 75 288.65416666666664 157.5 316.3333333333333 157.5C 344.0125 157.5 367.7375 150 395.4166666666667 150C 423.09583333333336 150 446.8208333333333 157.5 474.5 157.5C 502.1791666666667 157.5 525.9041666666667 138.75 553.5833333333334 138.75C 581.2625 138.75 604.9875 157.5 632.6666666666666 157.5C 660.3458333333333 157.5 684.0708333333333 93.75 711.75 93.75C 739.4291666666667 93.75 763.1541666666667 112.5 790.8333333333334 112.5C 818.5125 112.5 842.2375 18.75 869.9166666666666 18.75C 897.5958333333333 18.75 921.3208333333333 225 949 225C 949 225 949 225 949 225M 949 225z" pathFrom="M -1 225L -1 225L 79.08333333333333 225L 158.16666666666666 225L 237.25 225L 316.3333333333333 225L 395.4166666666667 225L 474.5 225L 553.5833333333334 225L 632.6666666666666 225L 711.75 225L 790.8333333333334 225L 869.9166666666666 225L 949 225"></path><path id="SvgjsPath1242" d="M 0 202.5C 27.679166666666664 202.5 51.40416666666667 150 79.08333333333333 150C 106.76249999999999 150 130.48749999999998 168.75 158.16666666666666 168.75C 185.84583333333333 168.75 209.57083333333333 75 237.25 75C 264.9291666666667 75 288.65416666666664 157.5 316.3333333333333 157.5C 344.0125 157.5 367.7375 150 395.4166666666667 150C 423.09583333333336 150 446.8208333333333 157.5 474.5 157.5C 502.1791666666667 157.5 525.9041666666667 138.75 553.5833333333334 138.75C 581.2625 138.75 604.9875 157.5 632.6666666666666 157.5C 660.3458333333333 157.5 684.0708333333333 93.75 711.75 93.75C 739.4291666666667 93.75 763.1541666666667 112.5 790.8333333333334 112.5C 818.5125 112.5 842.2375 18.75 869.9166666666666 18.75C 897.5958333333333 18.75 921.3208333333333 225 949 225" fill="none" fill-opacity="1" stroke="#7366ff" stroke-opacity="1" stroke-linecap="butt" stroke-width="4" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask8l1quwm3)" pathTo="M 0 202.5C 27.679166666666664 202.5 51.40416666666667 150 79.08333333333333 150C 106.76249999999999 150 130.48749999999998 168.75 158.16666666666666 168.75C 185.84583333333333 168.75 209.57083333333333 75 237.25 75C 264.9291666666667 75 288.65416666666664 157.5 316.3333333333333 157.5C 344.0125 157.5 367.7375 150 395.4166666666667 150C 423.09583333333336 150 446.8208333333333 157.5 474.5 157.5C 502.1791666666667 157.5 525.9041666666667 138.75 553.5833333333334 138.75C 581.2625 138.75 604.9875 157.5 632.6666666666666 157.5C 660.3458333333333 157.5 684.0708333333333 93.75 711.75 93.75C 739.4291666666667 93.75 763.1541666666667 112.5 790.8333333333334 112.5C 818.5125 112.5 842.2375 18.75 869.9166666666666 18.75C 897.5958333333333 18.75 921.3208333333333 225 949 225" pathFrom="M -1 225L -1 225L 79.08333333333333 225L 158.16666666666666 225L 237.25 225L 316.3333333333333 225L 395.4166666666667 225L 474.5 225L 553.5833333333334 225L 632.6666666666666 225L 711.75 225L 790.8333333333334 225L 869.9166666666666 225L 949 225"></path><g id="SvgjsG1235" class="apexcharts-series-markers-wrap"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1264" r="0" cx="0" cy="0" class="apexcharts-marker w7qufew3y no-pointer-events" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="0.9" default-marker-size="0"></circle></g></g><g id="SvgjsG1236" class="apexcharts-datalabels"></g></g></g><line id="SvgjsLine1258" x1="0" y1="0" x2="949" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1259" x1="0" y1="0" x2="949" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1260" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1261" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1262" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1228" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect><g id="SvgjsG1254" class="apexcharts-yaxis" rel="0" transform="translate(-21, 0)"></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(115, 102, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(247, 49, 100);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom light"><div class="apexcharts-xaxistooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div></div></div></div>
                      <div class="resize-triggers"><div class="expand-trigger"><div style="width: 950px; height: 256px;"></div></div><div class="contract-trigger"></div></div></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row border-top m-0">
                <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
                  <div class="media p-0">
                    <div class="media-left"><i class="icofont icofont-crown"></i></div>
                    <div class="media-body">
                      <h6>Referral Earning</h6>
                      <p>$5,000.20</p>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-6">
                  <div class="media p-0">
                    <div class="media-left bg-secondary"><i class="icofont icofont-heart-alt"></i></div>
                    <div class="media-body">
                      <h6>Cash Balance</h6>
                      <p>$2,657.21</p>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-12 pe-0">
                  <div class="media p-0">
                    <div class="media-left"><i class="icofont icofont-cur-dollar"></i></div>
                    <div class="media-body">
                      <h6>Sales forcasting</h6>
                      <p>$9,478.50     </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-9 xl-100 chart_data_left box-col-12">
      <div class="card">
        <div class="card-body p-0">
          <div class="row m-0 chart-main">
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>1001</h4><span>Purchase </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart1 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="55.5" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="55.5" y2="31.200000000000003" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>1005</h4><span>Sales</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart2 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="39.3" y2="31.199999999999996" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>100</h4><span>Sales return</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media border-none align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart3 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="39.3" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="33.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="39.3" y2="33.9" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>101</h4><span>Purchase ret</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 xl-50 chart_data_right box-col-12">
      <div class="card">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="media-body right-chart-content">
              <h4>$95,900<span class="new-box">Hot</span></h4><span>Purchase Order Value</span>
            </div>
            <div class="knob-block text-center">
              <div style="display:inline;width:65px;height:65px;"><canvas width="81" height="81" style="width: 65px; height: 65px;"></canvas><input class="knob1" data-width="10" data-height="70" data-thickness=".3" data-angleoffset="0" data-linecap="round" data-fgcolor="#7366ff" data-bgcolor="#eef5fb" value="60" style="width: 36px; height: 21px; position: absolute; vertical-align: middle; margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 13px Arial; text-align: center; color: rgb(115, 102, 255); padding: 0px; appearance: none;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 xl-50 chart_data_right second d-none"> 
      <div class="card">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="media-body right-chart-content"> 
              <h4>$95,000<span class="new-box">New</span></h4><span>Product Order Value</span>
            </div>
            <div class="knob-block text-center">
              <div style="display:inline;width:65px;height:65px;"><canvas width="81" height="81" style="width: 65px; height: 65px;"></canvas><input class="knob1" data-width="50" data-height="70" data-thickness=".3" data-fgcolor="#7366ff" data-linecap="round" data-angleoffset="0" value="60" style="width: 36px; height: 21px; position: absolute; vertical-align: middle; margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 13px Arial; text-align: center; color: rgb(115, 102, 255); padding: 0px; appearance: none;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-50 news box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">News &amp; Update</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="news-update">
            <h6>36% off For pixel lights Couslations Types.</h6><span>Lorem Ipsum is simply dummy...</span>
          </div>
          <div class="news-update">
            <h6>We are produce new product this</h6><span> Lorem Ipsum is simply text of the printing... </span>
          </div>
          <div class="news-update">
            <h6>50% off For COVID Couslations Types.</h6><span>Lorem Ipsum is simply dummy...</span>
          </div>
        </div>
        <div class="card-footer">
          <div class="bottom-btn"><a href="#">More...</a></div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-50 appointment-sec box-col-6">
      <div class="row"> 
        <div class="col-xl-12 appointment">
          <div class="card">
            <div class="card-header card-no-border">
              <div class="header-top">
                <h5 class="m-0">appointment</h5>
                <div class="card-header-right-icon">
                  <div class="dropdown">
                    <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="appointment-table table-responsive">
                <table class="table table-bordernone">
                  <tbody>
                    <tr>
                      <td><img class="img-fluid img-40 rounded-circle mb-3" src="../assets/images/appointment/app-ent.jpg" alt="Image description">
                        <div class="status-circle bg-primary"></div>
                      </td>
                      <td class="img-content-box"><span class="d-block">Venter Loren</span><span class="font-roboto">Now</span></td>
                      <td>
                        <p class="m-0 font-primary">28 Sept</p>
                      </td>
                      <td class="text-end">
                        <div class="button btn btn-primary">Done<i class="fa fa-check-circle ms-2"></i></div>
                      </td>
                    </tr>
                    <tr>
                      <td><img class="img-fluid img-40 rounded-circle" src="../assets/images/appointment/app-ent.jpg" alt="Image description">
                        <div class="status-circle bg-primary"></div>
                      </td>
                      <td class="img-content-box"><span class="d-block">John Loren</span><span class="font-roboto">11:00</span></td>
                      <td>
                        <p class="m-0 font-primary">22 Sept</p>
                      </td>
                      <td class="text-end">
                        <div class="button btn btn-danger">Pending<i class="fa fa-clock-o ms-2"></i></div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12 alert-sec">
          <div class="card bg-img">
            <div class="card-header">
              <div class="header-top">
                <h5 class="m-0">Alert  </h5>
                <div class="dot-right-icon"><i class="fa fa-ellipsis-h"></i></div>
              </div>
            </div>
            <div class="card-body">
              <div class="body-bottom">
                <h6>  10% off For drama lights Couslations...</h6><span class="font-roboto">Lorem Ipsum is simply dummy...It is a long established fact that a reader will be distracted by  </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-50 notification box-col-6">
      <div class="card">
        <div class="card-header card-no-border">
          <div class="header-top">
            <h5 class="m-0">notification</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday  </a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="media">
            <div class="media-body">
              <p>20-04-2020 <span>10:10</span></p>
              <h6>Updated Product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <p>20-04-2020<span class="ps-1">Today</span><span class="badge badge-secondary">New</span></p>
              <h6>Tello just like your product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna... </span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <div class="d-flex mb-3">
                <div class="inner-img"><img class="img-fluid" src="../assets/images/notification/1.jpg" alt="Product-1"></div>
                <div class="inner-img"><img class="img-fluid" src="../assets/images/notification/2.jpg" alt="Product-2"></div>
              </div><span class="mt-3">Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-50 appointment box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Market Value</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Year</button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Year</a><a class="dropdown-item" href="#">Month</a><a class="dropdown-item" href="#">Day</a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-Body">
          <div class="radar-chart" style="position: relative;">
            <div id="marketchart" style="min-height: 395px;"><div id="apexcharts6mk2zjpi" class="apexcharts-canvas apexcharts6mk2zjpi light" style="width: 503px; height: 380px;"><svg id="SvgjsSvg1267" width="503" height="380" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1269" class="apexcharts-inner apexcharts-graphical" transform="translate(12, 30)"><defs id="SvgjsDefs1268"><clipPath id="gridRectMask6mk2zjpi"><rect id="SvgjsRect1272" width="484" height="313" x="-1.5" y="-1.5" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath><clipPath id="gridRectMarkerMask6mk2zjpi"><rect id="SvgjsRect1273" width="495" height="324" x="-7" y="-7" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"></rect></clipPath></defs><g id="SvgjsG1322" class="apexcharts-grid"><line id="SvgjsLine1324" x1="0" y1="310" x2="481" y2="310" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1323" x1="0" y1="1" x2="0" y2="310" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1275" class="apexcharts-radar-series" data:innerTranslateX="240.5" data:innerTranslateY="130" transform="translate(240.5, 155)"><polygon id="SvgjsPolygon1302" points="0,-140 109.45640754552417,-87.28857226022271 136.4899077054553,31.152930753884007 60.74372347645815,126.13564150633866 -60.74372347645812,126.13564150633869 -136.4899077054553,31.152930753884043 -109.45640754552419,-87.28857226022268 " fill="#fcf8ff" stroke="#e8e8e8"></polygon><polygon id="SvgjsPolygon1303" points="0,-112 87.56512603641934,-69.83085780817817 109.19192616436425,24.922344603107206 48.594978781166525,100.90851320507093 -48.594978781166496,100.90851320507095 -109.19192616436425,24.922344603107234 -87.56512603641934,-69.83085780817814 " fill="#f7eeff" stroke="#e8e8e8"></polygon><polygon id="SvgjsPolygon1304" points="0,-84 65.6738445273145,-52.373143356133625 81.89394462327319,18.691758452330404 36.44623408587489,75.6813849038032 -36.44623408587487,75.6813849038032 -81.89394462327319,18.691758452330426 -65.67384452731451,-52.3731433561336 " fill="#fcf8ff" stroke="#e8e8e8"></polygon><polygon id="SvgjsPolygon1305" points="0,-56 43.78256301820967,-34.91542890408908 54.595963082182124,12.461172301553603 24.297489390583262,50.454256602535466 -24.297489390583248,50.45425660253547 -54.595963082182124,12.461172301553617 -43.78256301820967,-34.91542890408907 " fill="#f7eeff" stroke="#e8e8e8"></polygon><polygon id="SvgjsPolygon1306" points="0,-28 21.891281509104836,-17.45771445204454 27.297981541091062,6.2305861507768014 12.148744695291631,25.227128301267733 -12.148744695291624,25.227128301267737 -27.297981541091062,6.2305861507768086 -21.891281509104836,-17.457714452044534 " fill="#fcf8ff" stroke="#e8e8e8"></polygon><polygon id="SvgjsPolygon1307" points="0,0 0,0 0,0 0,0 0,0 0,0 0,0 " fill="#f7eeff" stroke="#e8e8e8"></polygon><line id="SvgjsLine1295" x1="0" y1="-140" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1296" x1="109.45640754552417" y1="-87.28857226022271" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1297" x1="136.4899077054553" y1="31.152930753884007" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1298" x1="60.74372347645815" y1="126.13564150633866" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1299" x1="-60.74372347645812" y1="126.13564150633869" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1300" x1="-136.4899077054553" y1="31.152930753884043" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><line id="SvgjsLine1301" x1="-109.45640754552419" y1="-87.28857226022268" x2="0" y2="0" stroke="#e8e8e8" stroke-dasharray="0"></line><g id="SvgjsG1314" class="apexcharts-datalabels"><text id="SvgjsText1315" font-family="Helvetica, Arial, sans-serif" x="0" y="-150" text-anchor="middle" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="0" cy="-150" style="font-family: Helvetica, Arial, sans-serif;">Sunday</text><text id="SvgjsText1316" font-family="Helvetica, Arial, sans-serif" x="119.45640754552417" y="-87.28857226022271" text-anchor="start" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="119.45640754552417" cy="-87.28857226022271" style="font-family: Helvetica, Arial, sans-serif;">Monday</text><text id="SvgjsText1317" font-family="Helvetica, Arial, sans-serif" x="146.4899077054553" y="31.152930753884007" text-anchor="start" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="146.4899077054553" cy="31.152930753884007" style="font-family: Helvetica, Arial, sans-serif;">Tuesday</text><text id="SvgjsText1318" font-family="Helvetica, Arial, sans-serif" x="70.74372347645814" y="126.13564150633866" text-anchor="start" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="70.74372347645814" cy="126.13564150633866" style="font-family: Helvetica, Arial, sans-serif;">Wednesday</text><text id="SvgjsText1319" font-family="Helvetica, Arial, sans-serif" x="-70.74372347645811" y="126.13564150633869" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="-70.74372347645811" cy="126.13564150633869" style="font-family: Helvetica, Arial, sans-serif;">Thursday</text><text id="SvgjsText1320" font-family="Helvetica, Arial, sans-serif" x="-146.4899077054553" y="31.152930753884043" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="-146.4899077054553" cy="31.152930753884043" style="font-family: Helvetica, Arial, sans-serif;">Friday</text><text id="SvgjsText1321" font-family="Helvetica, Arial, sans-serif" x="-119.45640754552419" y="-87.28857226022268" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#a8a8a8" class="apexcharts-datalabel" cx="-119.45640754552419" cy="-87.28857226022268" style="font-family: Helvetica, Arial, sans-serif;">Saturday</text></g><g id="SvgjsG1276" class="apexcharts-yaxis"><text id="SvgjsText1308" font-family="Helvetica, Arial, sans-serif" x="0" y="-134" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;">100</text><text id="SvgjsText1309" font-family="Helvetica, Arial, sans-serif" x="0" y="-106" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;"></text><text id="SvgjsText1310" font-family="Helvetica, Arial, sans-serif" x="0" y="-78" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;">60</text><text id="SvgjsText1311" font-family="Helvetica, Arial, sans-serif" x="0" y="-50" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;"></text><text id="SvgjsText1312" font-family="Helvetica, Arial, sans-serif" x="0" y="-22" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;">20</text><text id="SvgjsText1313" font-family="Helvetica, Arial, sans-serif" x="0" y="6" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="regular" fill="#373d3f" style="font-family: Helvetica, Arial, sans-serif;"></text></g><g id="SvgjsG1277" class="apexcharts-series" seriesName="Marketxvalue" rel="1" data:realIndex="0"><path id="SvgjsPath1279" d="M 0 -28L 0 -28L 109.45640754552417 -87.28857226022271L 54.595963082182124 12.461172301553603L 18.223117042937446 37.8406924519016L -30.37186173822906 63.06782075316934L -109.19192616436425 24.922344603107234L -36.12061449002299 -28.805228845873483Z" fill="none" fill-opacity="1" stroke="#7366ff" stroke-opacity="1" stroke-linecap="butt" stroke-width="3" stroke-dasharray="0" class="apexcharts-radar" index="0" pathTo="M 0 -28L 0 -28L 109.45640754552417 -87.28857226022271L 54.595963082182124 12.461172301553603L 18.223117042937446 37.8406924519016L -30.37186173822906 63.06782075316934L -109.19192616436425 24.922344603107234L -36.12061449002299 -28.805228845873483Z" pathFrom="M 0 0"></path><path id="SvgjsPath1280" d="M 0 -28L 0 -28L 109.45640754552417 -87.28857226022271L 54.595963082182124 12.461172301553603L 18.223117042937446 37.8406924519016L -30.37186173822906 63.06782075316934L -109.19192616436425 24.922344603107234L -36.12061449002299 -28.805228845873483Z" fill="rgba(115,102,255,0.2)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-radar" index="0" pathTo="M 0 -28L 0 -28L 109.45640754552417 -87.28857226022271L 54.595963082182124 12.461172301553603L 18.223117042937446 37.8406924519016L -30.37186173822906 63.06782075316934L -109.19192616436425 24.922344603107234L -36.12061449002299 -28.805228845873483Z" pathFrom="M 0 0"></path><g id="SvgjsG1278" class="apexcharts-series-markers-wrap"><g id="SvgjsG1282" class="apexcharts-series-markers"><circle id="SvgjsCircle1281" r="6" cx="0" cy="-28" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="0" j="0" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1284" class="apexcharts-series-markers"><circle id="SvgjsCircle1283" r="6" cx="109.45640754552417" cy="-87.28857226022271" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="1" j="1" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1286" class="apexcharts-series-markers"><circle id="SvgjsCircle1285" r="6" cx="54.595963082182124" cy="12.461172301553603" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="2" j="2" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1288" class="apexcharts-series-markers"><circle id="SvgjsCircle1287" r="6" cx="18.223117042937446" cy="37.8406924519016" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="3" j="3" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1290" class="apexcharts-series-markers"><circle id="SvgjsCircle1289" r="6" cx="-30.37186173822906" cy="63.06782075316934" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="4" j="4" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1292" class="apexcharts-series-markers"><circle id="SvgjsCircle1291" r="6" cx="-109.19192616436425" cy="24.922344603107234" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="5" j="5" index="0" default-marker-size="6"></circle></g><g id="SvgjsG1294" class="apexcharts-series-markers"><circle id="SvgjsCircle1293" r="6" cx="-36.12061449002299" cy="-28.805228845873483" class="apexcharts-marker" stroke="#7366ff" fill="#ffffff" fill-opacity="1" stroke-width="3" stroke-opacity="1" rel="6" j="6" index="0" default-marker-size="6"></circle></g></g></g></g><line id="SvgjsLine1325" x1="0" y1="0" x2="481" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1326" x1="0" y1="0" x2="481" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1327" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1328" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1329" class="apexcharts-point-annotations"></g></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip light"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-marker" style="background-color: rgb(115, 102, 255);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label"></span><span class="apexcharts-tooltip-text-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div></div></div>
          <div class="resize-triggers"><div class="expand-trigger"><div style="width: 504px; height: 396px;"></div></div><div class="contract-trigger"></div></div></div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-100 chat-sec box-col-6">
      <div class="card chat-default">
        <div class="card-header card-no-border">
          <div class="media media-dashboard">
            <div class="media-body"> 
              <h5 class="mb-0">Live Chat</h5>
            </div>
            <div class="icon-box"><i class="fa fa-ellipsis-h"></i></div>
          </div>
        </div>
        <div class="card-body chat-box">
          <div class="chat">
            <div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile"> <img class="img-fluid" src="../assets/images/user.jpg" alt="Profile"></div>
                <div class="main-chat">
                  <div class="message-main"><span class="mb-0">Hi deo, Please send me link.</span></div>
                  <div class="sub-message message-main"><span class="mb-0">Right Now</span></div>
                </div>
              </div>
              <p class="f-w-400">7:28 PM</p>
            </div>
            <div class="media right-side-chat">
              <p class="f-w-400">7:28 PM</p>
              <div class="media-body text-end">
                <div class="message-main pull-right"><span class="mb-0 text-start">How can do for you</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile"> <img class="img-fluid" src="../assets/images/user.jpg" alt="Profile"></div>
                <div class="main-chat">
                  <div class="sub-message message-main mt-0"><span>It's argently</span></div>
                </div>
              </div>
              <p class="f-w-400">7:28 PM</p>
            </div>
            <div class="media right-side-chat">
              <div class="media-body text-end">
                <div class="message-main pull-right"><span class="loader-span mb-0 text-start" id="wave"><span class="dot"></span><span class="dot"></span><span class="dot"></span></span></div>
              </div>
            </div>
            <div class="input-group">
              <input class="form-control" id="mail" type="text" placeholder="Type Your Message..." name="text">
              <div class="send-msg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-lg-12 xl-50 calendar-sec box-col-6">
      <div class="card gradient-primary o-hidden">
        <div class="card-body">
          <div class="setting-dot">
            <div class="setting-bg-primary date-picker-setting position-set pull-right"><i class="fa fa-spin fa-cog"></i></div>
          </div>
          <div class="default-datepicker">
            <div class="datepicker-here" data-language="en"><div class="datepicker-inline"><div class="datepicker"><i class="datepicker--pointer"></i><nav class="datepicker--nav"><div class="datepicker--nav-action" data-action="prev"><svg><path d="M 17,12 l -5,5 l 5,5"></path></svg></div><div class="datepicker--nav-title">November,  <i> 2024  </i></div><div class="datepicker--nav-action" data-action="next"><svg><path d="M 14,12 l 5,5 l -5,5"></path></svg></div></nav><div class="datepicker--content"><div class="datepicker--days datepicker--body active"><div class="datepicker--days-names"><div class="datepicker--day-name -weekend-">S</div><div class="datepicker--day-name">M</div><div class="datepicker--day-name">T</div><div class="datepicker--day-name">W</div><div class="datepicker--day-name">T</div><div class="datepicker--day-name">F</div><div class="datepicker--day-name -weekend-">S</div></div><div class="datepicker--cells datepicker--cells-days"><div class="datepicker--cell datepicker--cell-day -weekend- -other-month-" data-date="27" data-month="9" data-year="2024">27</div><div class="datepicker--cell datepicker--cell-day -other-month-" data-date="28" data-month="9" data-year="2024">28</div><div class="datepicker--cell datepicker--cell-day -other-month-" data-date="29" data-month="9" data-year="2024">29</div><div class="datepicker--cell datepicker--cell-day -other-month-" data-date="30" data-month="9" data-year="2024">30</div><div class="datepicker--cell datepicker--cell-day -other-month-" data-date="31" data-month="9" data-year="2024">31</div><div class="datepicker--cell datepicker--cell-day" data-date="1" data-month="10" data-year="2024">1</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="2" data-month="10" data-year="2024">2</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="3" data-month="10" data-year="2024">3</div><div class="datepicker--cell datepicker--cell-day" data-date="4" data-month="10" data-year="2024">4</div><div class="datepicker--cell datepicker--cell-day" data-date="5" data-month="10" data-year="2024">5</div><div class="datepicker--cell datepicker--cell-day" data-date="6" data-month="10" data-year="2024">6</div><div class="datepicker--cell datepicker--cell-day" data-date="7" data-month="10" data-year="2024">7</div><div class="datepicker--cell datepicker--cell-day" data-date="8" data-month="10" data-year="2024">8</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="9" data-month="10" data-year="2024">9</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="10" data-month="10" data-year="2024">10</div><div class="datepicker--cell datepicker--cell-day" data-date="11" data-month="10" data-year="2024">11</div><div class="datepicker--cell datepicker--cell-day" data-date="12" data-month="10" data-year="2024">12</div><div class="datepicker--cell datepicker--cell-day" data-date="13" data-month="10" data-year="2024">13</div><div class="datepicker--cell datepicker--cell-day" data-date="14" data-month="10" data-year="2024">14</div><div class="datepicker--cell datepicker--cell-day" data-date="15" data-month="10" data-year="2024">15</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="16" data-month="10" data-year="2024">16</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="17" data-month="10" data-year="2024">17</div><div class="datepicker--cell datepicker--cell-day" data-date="18" data-month="10" data-year="2024">18</div><div class="datepicker--cell datepicker--cell-day" data-date="19" data-month="10" data-year="2024">19</div><div class="datepicker--cell datepicker--cell-day" data-date="20" data-month="10" data-year="2024">20</div><div class="datepicker--cell datepicker--cell-day" data-date="21" data-month="10" data-year="2024">21</div><div class="datepicker--cell datepicker--cell-day" data-date="22" data-month="10" data-year="2024">22</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="23" data-month="10" data-year="2024">23</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="24" data-month="10" data-year="2024">24</div><div class="datepicker--cell datepicker--cell-day" data-date="25" data-month="10" data-year="2024">25</div><div class="datepicker--cell datepicker--cell-day" data-date="26" data-month="10" data-year="2024">26</div><div class="datepicker--cell datepicker--cell-day" data-date="27" data-month="10" data-year="2024">27</div><div class="datepicker--cell datepicker--cell-day" data-date="28" data-month="10" data-year="2024">28</div><div class="datepicker--cell datepicker--cell-day -current-" data-date="29" data-month="10" data-year="2024">29</div><div class="datepicker--cell datepicker--cell-day -weekend-" data-date="30" data-month="10" data-year="2024">30</div></div></div></div></div></div></div>
          </div><span class="default-dots-stay overview-dots full-width-dots"><span class="dots-group"><span class="dots dots1"></span><span class="dots dots2 dot-small"></span><span class="dots dots3 dot-small"></span><span class="dots dots4 dot-medium"></span><span class="dots dots5 dot-small"></span><span class="dots dots6 dot-small"></span><span class="dots dots7 dot-small-semi"></span><span class="dots dots8 dot-small-semi"></span><span class="dots dots9 dot-small">                </span></span></span>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

@endsection