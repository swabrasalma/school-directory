<?php $this->load->view('header/header.php') ?>
<style type="text/css">
    
.ibox-content {
    background-color: #FFFFFF;
    color: inherit;
    padding: 15px 20px 20px 20px;
    border-color: #E7EAEC;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 0px;
}

.search-form {
    margin-top: 10px;
}

.search-result h3 {
    margin-bottom: 0;
    color: #1E0FBE;
}

.search-result .search-link {
    color: #006621;
}

.search-result p {
    font-size: 12px;
    margin-top: 5px;
}

.hr-line-dashed {
    border-top: 1px dashed #E7EAEC;
    color: #ffffff;
    background-color: #ffffff;
    height: 1px;
    margin: 20px 0;
}

h2 {
    font-size: 24px;
    font-weight: 100;
}

                    
</style>
<?php
    //vdebug($search_results);
?>
<div class="container bootstrap snippet" style="margin-top:100px; min-height:780px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                <?php
                    if(!empty($studentData)) {
                ?>
                    <h1 style="font-size:26px; font-weight:bold;">Personal Details: <?php echo $studentData['name']; ?></h1><br>
                    <table class="table table-striped">
                      <tbody> 
                        <tr>
                            <td> Registration No: <?php echo $studentData['stud_reg_no']; ?> </td>
                        </tr>
                        <tr>
                            <td> Name: <?php echo $studentData['school']['name']; ?> </td>
                        </tr>
                        <tr>
                            <td> Name: <?php echo $studentData['name']; ?> </td>
                        </tr>
                        <tr>
                            <td> Year: <?php echo $studentData['sex']; ?> </td>
                        </tr>
                        <tr>
                            <td> Academic Year: <?php echo $studentData['academic_year']; ?> </td>
                        </tr>
                        <tr>
                            <td> Entry: <?php echo $studentData['entry']; ?> </td>
                        </tr>
                      </tbody>
                    </table>
                <?php
                    } else {
                        ?>
                        <h3>No Record was found</h3>
                        <?php
                    }
                ?>

                <?php 
                    if($studentData['type'] == 2) {
                ?>
                        <div class="hr-line-dashed"></div>
                        <h1 style="font-size:26px; font-weight:bold;">University</h1><br/>
                        <div class="list-group">
                          <a href="#" class="list-group-item active">
                            Recommended courses you qualify for:
                          </a>
                          
                           <?php
                                if(!empty($courses['allowed'])) {
                                    foreach ($courses['allowed'] as $course) {
                            ?>
                                <a href="#" class="list-group-item"><strong><?php echo $course['course_name']; ?></strong><Br/><Br/><?php echo $course['university']; ?></a>
                        <?php
                                }
                           } else {
                                ?>

                                <a href="#" class="list-group-item"><strong>Not Found</strong></a>
                            <?php
                            }
                        ?>
                        </div>
                        <br>
                        <br>
                        <div class="list-group">
                          <a href="#" class="list-group-item active">
                            Courses you <strong>DO NOT</strong> qualify for:
                          </a>
                           <?php
                                if(!empty($courses['notAllowed'])) {
                                    foreach ($courses['notAllowed'] as $course) {
                            ?>
                                <a href="#" class="list-group-item"><strong><?php echo $course['course_name']; ?></strong><br/><Br/><?php echo $course['university']; ?></a>
                        <?php
                                }
                            } else {
                                ?>

                                <a href="#" class="list-group-item"><strong>Not Found</strong></a>
                            <?php
                            }
                        ?>
                        </div>
                        <br>
                        <br>
                    <?php } ?>


                <h1 style="font-size:26px; font-weight:bold;">Location Of
                <?php if(!empty($studentData)) {
                    echo $studentData['school']['name'];
                }?></h1><br>
                <?php echo $map['js']; ?>
                <?php echo $map['html']; ?>
                <div class="hr-line-dashed"></div>
                 
                <div style="margin-top:30px;">
                <h1 style="font-size:26px; font-weight:bold;">Statistics Of <?php if(!empty($studentData)) {
                    echo $studentData['school']['name'];
                }?></h1><br>

                    <table class="table table-bordered">
                        <caption style="font-weight:bold;">O'level Performance by subject based number of Distinction One's</caption>
                        <thead>
                            <tr>
                              <th>
                            <?php
                                if(!empty($subjectData)) {
                                    foreach ($subjectData['subject'] as $subject) {
                        ?>
                                  
                                        <td colspan="7" style="font-weight:bold;"><?php echo $subject['name']; ?></td>
                                    
                                <?php } ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($subjectData['years'] as $year) { ?> 
                                    
                                <tr>
                                    <td rowspan="2" style="position:relative; top:0px; font-weight:bold;"><?php echo $year; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        foreach ($subjectData['data'] as $dataCount) {
                                            if ($year == $dataCount['year']) {
                                    ?> 
                                            <td colspan="7">
                                                <?php echo $dataCount['count']; ?>
                                            </td>
                                    <?php
                                         }
                                     } 
                                    ?>
                                </tr>
                                <?php } 
                            } else {
                                ?>
                                <h1>No Statistics Found For Subjects</h1>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
                <Br>
                <Br>
                 <Br />
                <Br />
                <div class="row" style="margin-top:20px; margin-left:-20px; margin-bottom:50px;">  
                    <div  class="col-md-6">
                        <h1 style="font-size:18px; font-weight:bold;">Performance of Males and Females based on the number of distinction one's</h1>  
                        <div style="width:350px;">
                            <canvas id="myChart" width="200" height="200"></canvas>
                        </div> 
                    </div>
                    <div  class="col-md-6">
                        <h1 style="font-size:18px; font-weight:bold;">Performance of  districts on the number of distinction one's</h1>  
                        <div style="width:350px;">
                            <canvas id="myPerformanceChart" width="200" height="200"></canvas>
                        </div> 
                    </div>
                </div>
                <div class="row" style="margin-top:20px; margin-left:-20px; margin-bottom:50px;">  
                    <div  class="col-md-6">
                        <h1 style="font-size:18px; font-weight:bold;">Performance of the entire country over the years </h1>
                        <canvas id="myLineGraph" width="200" height="200"></canvas>
                    </div>  
                    <div  class="col-md-6">
                          <h1 style="font-size:18px; font-weight:bold;">Trend of performance in subjects over the years</h1> 
                        <canvas id="mySubjectLineGraph" width="200" height="200"></canvas>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<Br>
                <Br><Br>
                <Br><Br>
                <Br>
<script src="<?php echo base_url()?>js/vendor/Chart.min.js"></script>
<script src="<?php echo base_url()?>js/graph.js"></script>
<script type = "text/javascript">

    var genderData = <?= $genderData ?>; 
    
    var options = {
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].labels){%><%=segments[i].label%><%}%> [ <%=segments[i].value%> ]</li><%}%></ul>"
    }
    var ctx = document.getElementById("myChart").getContext("2d");
    var myGenderPie = new Chart(ctx,{
            type: 'pie',
            data: genderData,
            //options: options
        }); 
</script>
<?php $this->load->view('performance_district.php'); ?>
<?php $this->load->view('trend_country_line_graph.php'); ?>
<?php $this->load->view('trend_subject_line_graph.php'); ?>
<?php $this->load->view('footer/footer.php') ?>
                    