<!doctype html>
<html lang="en">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Hello, world!</title>

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <style>
      body {
        background-color: lightgray;
      }
      </style>
  
  </head>
  <body>
      <div class="row">
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div class="col-4"></div>
      </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
   

  <div class="container">
  <center><b><h1><p class="bg-danger text-white">PULSE OXIMETER</p></h1></b></center>
    <div class="row">
      <div class="col-6">
        <canvas id="myChart"width="400" height="200"></canvas>
      </div>

    </div>
    <div class="row">
      <div class="col-6">
        <canvas id="myChart1"width="400" height="200"></canvas>
      </div>
  </div>

  <div class="row">
        <div class="col-3">
          <div class="row">
            <div class="col-4">
              <b>Heart Rate</b>
            </div>
            <div class="col-8">
              <span id="lastHearRate"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <b>SP02</b>
            </div>
            <div class="col-8">
              <span id="lastSP02"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-4">update </div>
            <div class="col-8">
              <span id="lastUpdate"></span>
            </div>

          </div>
        </div>
      
      <script>
        function HeartRateChart(data){
          var ctx = document.getElementById("myChart").getContext("2d");
          var myChart = new Chart(ctx,{
              type:'line',
              data:{
                  labels:data.xlabel,
                  datasets:[{
                      label:data.label,
                      data:data.data,
                      backgroundColor: 'rgb(201, 16, 16)',
                      borderColor: 'rgb(19, 129, 38)',
                     
                  }]
              }
          });
      }
      function SP02Chart(data_2){
        var ctxy = document.getElementById("myChart1").getContext("2d");
        var myChart = new Chart(ctxy,{
            type:'line',
            data:{
                labels:data_2.xlabel,
                datasets:[{
                    label:data_2.label,
                    data:data_2.data,
                    backgroundColor: 'rgb(201, 16, 16)',
                    borderColor: 'rgb(19, 129, 38)',
                    
                }]
            }
        });
    }
    $(()=>{
        let url = "https://api.thingspeak.com/channels/1490529/feeds.json?results=20";
        $.getJSON(url)
            .done(function(data){
                let feed = data.feeds;
                let chan = data.channel;


                const d = new Date(feed[19].created_at);
                    const monthNames = ["January","February","March","April","May","July","August","September","October","November","December"];
                    let dateStr = d.getDate()+" "+monthNames[d.getMonth()]+" "+d.getFullYear();
                    dateStr += " "+d.getHours()+":"+d.getMinutes();

              
              $("#lastHearRate").text(feed[19].field1+ " C");
                $("#lastSP02").text(feed[19].field2+ " %");
                $("#lastUpdate").text(dateStr);

                var plot = Object();
                var xlabel = [];
                var HR = [];
                var SPO = [];
                
                $.each(feed,(k,v)=>{
                    xlabel.push(v.created_at);
                    HR.push(v.field1);
                    SPO.push(v.field2);
                   
                });
                var data = new Object();
                data.xlabel = xlabel;
                data.data = HR;
                data.label = chan.field1;
                
                var data_2 = new Object();
                data_2.xlabel = xlabel;
                data_2.data = SPO;
                data_2.label = chan.field2;
               
            
               
                HeartRateChart(data);
                SP02Chart(data_2);
               



            });
    });
     
</script>
  </html>
