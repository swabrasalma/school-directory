<script type = "text/javascript">

    var subjectLineData = <?= $subjectLineData ?>; 

    var ctx = document.getElementById("mySubjectLineGraph").getContext("2d");
    var myLineGraph = new Chart(ctx,{
            type: 'line',
            data: subjectLineData
        }); 
</script>