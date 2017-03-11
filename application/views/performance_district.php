<script type = "text/javascript">

    var districtPerformanceData = <?= $districtPerformanceData ?>; 

    var ctx = document.getElementById("myPerformanceChart").getContext("2d");
    var myLineGraph = new Chart(ctx,{
            type: 'pie',
            data: districtPerformanceData
        }); 
</script>