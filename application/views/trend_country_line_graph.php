<script type = "text/javascript">

    var lineData = <?= $lineData ?>; 

    var ctx = document.getElementById("myLineGraph").getContext("2d");
    var myLineGraph = new Chart(ctx,{
            type: 'line',
            data: lineData
        }); 
</script>