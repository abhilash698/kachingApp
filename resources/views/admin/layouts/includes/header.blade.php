    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Kaching - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />

    {!! Html::style('assets/plugins/pace/pace-theme-flash.css') !!}
    {!! Html::style('assets/plugins/boostrapv3/css/bootstrap.min.css') !!}
    {!! Html::style('assets/plugins/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('assets/plugins/jquery-scrollbar/jquery.scrollbar.css') !!}
    {!! Html::style('assets/plugins/bootstrap-select2/select2.css') !!}
    {!! Html::style('assets/plugins/switchery/css/switchery.min.css') !!}
    {!! Html::style('assets/plugins/nvd3/nv.d3.min.css') !!}
    {!! Html::style('assets/plugins/mapplic/css/mapplic.css') !!}
    {!! Html::style('assets/plugins/bootstrap-datepicker/css/datepicker3.css') !!}
    {!! Html::style('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
    {!! Html::style('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css') !!}
    {!! Html::style('assets/plugins/jquery-metrojs/MetroJs.css') !!}
    {!! Html::style('pages/css/pages-icons.css') !!}
    {!! Html::style('pages/css/pages.css') !!}
    {!! Html::style('assets/css/style.css') !!}

<style type="text/css">
.flip {
  -webkit-perspective: 800;
  -ms-perspective: 800;
  -moz-perspective: 800;
  -o-perspective: 800;
   width: 100%;
   height: 180px;
   position: relative;
}
.flip .card.flipped {
  transform:rotatey(-180deg);
  -ms-transform:rotatey(-180deg); /* IE 9 */
  -moz-transform:rotatey(-180deg); /* Firefox */
  -webkit-transform:rotatey(-180deg); /* Safari and Chrome */
  -o-transform:rotatey(-180deg); /* Opera */
}
.flip .card {
  width: 100%;
  height: 100%;
  -webkit-transform-style: preserve-3d;
  -webkit-transition: 0.5s;
  -moz-transform-style: preserve-3d;
  -moz-transition: 0.5s;
  -ms-transform-style: preserve-3d;
  -ms-transition: 0.5s;
  -o-transform-style: preserve-3d;
  -o-transition: 0.5s;
  transform-style: preserve-3d;
  transition: 0.5s;
}
.flip .card .face {
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 2;
  font-family: Georgia;
  font-size: 3em;
  text-align: center;
  line-height: normal;
  backface-visibility: hidden;  /* W3C */
  -webkit-backface-visibility: hidden; /* Safari & Chrome */
  -moz-backface-visibility: hidden; /* Firefox */
  -ms-backface-visibility: hidden; /* Internet Explorer */
  -o-backface-visibility: hidden; /* Opera */

}
.flip .card .face p {
  text-align: left;
}


.flip .card .front {
  position: absolute;
  z-index: 1;
  background: ;
  color: black;
  cursor: pointer;
}
.flip .card .back {
    background: blue;
    background: white;
    color: black;
    cursor: pointer;
    
  transform:rotatey(-180deg);
  -ms-transform:rotatey(-180deg); /* IE 9 */
  -moz-transform:rotatey(-180deg); /* Firefox */
  -webkit-transform:rotatey(-180deg); /* Safari and Chrome */
  -o-transform:rotatey(-180deg); /* Opera */

}

.flip .card .front hr{
  margin-bottom: 0px !important;
  margin-top: 15px !important;
}

.head-offer{
  margin: 10px 0px 0px 10px;
  left: 2px;
  font-size: 13px;
  font-weight: bold;
}

.offer-txt{
  font-size: 12px !important;
  margin-left: 10px;
  margin-top: 18px;
  color: #737373;
}

.icon-new {
    width:15px; 
    height:15px;
    position: relative;
    margin: 0px auto;
    display: inline-block;
}
.txt {
    padding:-10px 0 0 10px;
    font-size:11px;
}

.fineprint{
  list-style-type:disc; 
  font-size:12px; 
  text-align:left; 
  margin-left:10px;
}
</style>

 
<!--[if lte IE 9]>
    <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript">
window.onload = function()
{
  // fix for windows 8
  if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
}
</script>