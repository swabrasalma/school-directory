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
                    <h2>
                        <?php if(!empty($total_count)) {

                            echo $total_count; 
                        } else {
                            echo '0';
                        }

                        ?> results found for: <span class="text-navy"><?php echo $search_term; ?></span>
                    </h2>
                    <small>Request time  (0.23 seconds)</small>
        
                    <div class="search-form">
                        <?php $this->load->view('search_form.php') ?>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <?php if($search_type == 1 ) {
                        if (!empty($search_results)) {
                            foreach ($search_results as $key => $school) {
                        ?>

                            
                                <div class="search-result">
                                    <h3><a href="<?php echo base_url()?>search/school/details/<?php echo $school['sch_reg_no'];?>"><?php echo $school['name']; ?></a></h3>
                                    <p><strong>School:</strong> &nbsp; <?php  echo $school['district'];?></p>
                                    <p><strong>Year:</strong> &nbsp; <?php  echo $school['year'];?></p>
                                    <a href="<?php echo base_url()?>/search/school/details/<?php echo $school['sch_reg_no'];?>" class="search-link">View details</a>
                                    <p>
                                    </p>
                                </div>
                                <div class="hr-line-dashed"></div>

                        <?php

                            } 
                        } else {
                        ?>

                            <div class="search-result">
                                <h1>No Records found</h1>
                            </div>
                        <?php
                        }
                    } elseif($search_type == 2 ) { 
                         if (!empty($search_results)) {
                            foreach ($search_results as $key => $student) {
                        ?> 
                                <div class="search-result">
                                    <h3><a href="<?php echo base_url()?>search/student/details/<?php echo $student['stud_reg_no'];?>"><?php echo $student['name']; ?></a></h3>
                                    <p><strong>School:</strong> &nbsp; <?php  echo $student['school']['name'];?></p>
                                    <p><strong>Year:</strong> &nbsp; <?php  echo $student['academic_year'];?></p>
                                    <p><strong>Entry:</strong> &nbsp; <?php  echo $student['entry'];?></p>
                                    <a href="<?php echo base_url()?>/search/student/details/<?php echo $student['stud_reg_no'];?>" class="search-link">View details</a>
                                    <p>
                                    </p>
                                </div>
                                <div class="hr-line-dashed"></div>
                        <?php

                            } 
                        } else {
                        ?>

                            <div class="search-result">
                                <h1>No Records found</h1>
                            </div>
                        <?php
                        }
                    }
                    ?>
                    
                    <div class="text-center">
                        <div class="btn-group">
                            <button class="btn btn-white" type="button"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            <button class="btn btn-white">1</button>
                            <button class="btn btn-white  active">2</button>
                            <button class="btn btn-white">3</button>
                            <button class="btn btn-white">4</button>
                            <button class="btn btn-white">5</button>
                            <button class="btn btn-white">6</button>
                            <button class="btn btn-white">7</button>
                            <button class="btn btn-white" type="button"><i class="glyphicon glyphicon-chevron-right"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer/footer.php') ?>
                    