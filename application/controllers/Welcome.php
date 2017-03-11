<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_controller {

	public function __construct(){  
        parent::__construct();
        $this->load->model('results_model');
        $this->load->model('students_model');
        $this->load->model('school_model');
        $this->load->model('search_model');
        $this->load->model('subject_model');
        $this->load->library('Googlemaps');

    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	/**
	 * [getPerformanceBySex description]
	 * @return [type] [description]
	 */
	public function getPerformanceBySex()
	{
		$yearData = $this->results_model->getAcademicYear();
        $allYears = array();

        foreach ($yearData as $value) {
            array_push($allYears, $value);
        }

        $schoolData['schools'] = $this->school_model->getAllSchools();
        $schoolData['years'] = $this->results_model->array_flatten($allYears);
        $sex = array('F', 'M');
        $division1 = 0;
        $pie = array();

        
		foreach ($sex as $key => $gender) {
			foreach ($allYears as $year) {
				$data = $this->students_model->as_array()->where(array('academic_year' => $year, 'sex' => $gender))->get_all();
				foreach ($data as $student) {
					$results = $this->students_model->getStudentResult($student['stud_reg_no'], $student['academic_year']);
					if ($student['entry'] == 1) {
						$a = (int)$results['finalGrade'];	
					}
					if ( 8 <= $a && $a <= 31) {
						$division1++;
					}
				} 
				
			}
        	array_push($pie, array('gender' => $this->students_model->gender($gender), 'count' => $division1)); 
        } 
        
        $pieChartData = array();
        $totalCount = array();

        foreach ($pie as $key => $data1) { 
        	array_push($totalCount, $data1['count']);      
        }

        foreach ($pie as $key => $data1) {
            $pieChartData['labels'][] = $data1['gender'];
            $pieChartData['datasets'][0]['data'][] = round((($data1['count'] /array_sum($totalCount)) * 100), 0);      
        }
        $pieChartData['datasets'][0]['backgroundColor'] = [
            "#FF6384",
            "#36A2EB"
        ];
        $pieChartData['datasets'][0]['hoverBackgroundColor'] = [
            "#DB7093",
            "#4169E1"
        ];
 
        return json_encode($pieChartData, true);;
	}



	/**
	 * [getPerformanceBySex description]
	 * @return [type] [description]
	 */
	public function getPerformanceByDistrict()
	{
		$allYears = array_reverse($this->getYears());
		$districts = $this->getDistricts();
        $pieDistrict = [];
		foreach ($districts as $key => $district) {
			$count = [];
			foreach ($allYears as $year) {
				$data = $this->school_model->as_array()->where(['district' => $district])->get_all();
				foreach ($data as $school) {
					$students = $this->students_model->where(['sch_reg_no' => $school['sch_reg_no']])->get_all();
					$division1 = [];
					if(!empty($students)) {
						foreach ($students as $student) {
							$results = $this->students_model->getStudentResult($student['stud_reg_no'], $year);
							if(!empty($results)) {
								if ($student['entry'] == 1) {
									$a = (int)$results['finalGrade'];	
								}
								if ( 8 <= $a && $a <= 31) {
									array_push($division1, [1]);
								}
							}
						}
					}
					array_push($count, count($division1));

				} 
				
			}
        	array_push($pieDistrict, ['district' => $district, 'count' => array_sum($count)]);
        }
        $pieChartData = [];
        $totalCount = [];

        foreach ($pieDistrict as $key => $data1) {
        	array_push($totalCount, $data1['count']);  
        }

        foreach ($pieDistrict as $key => $data1) {
            $pieChartData['labels'][] = $data1['district'];
            $pieChartData['datasets'][0]['data'][] = round((($data1['count'] /array_sum($totalCount)) * 100), 0);        
        }
        $pieChartData['datasets'][0]['backgroundColor'] = [
            "#7FFF00",
            "#FFA500",
            "#DA70D6",
            "#008080"

        ];
        $pieChartData['datasets'][0]['hoverBackgroundColor'] = [
            "#808000",
            "#FF4500",
            "#DDA0DD",
            "#2E8B57",
        ];

        return json_encode($pieChartData, true);;
	}

	/**
	 * [getPerformanceBySubject description]
	 * @return [type] [description]
	 */
    public function getPerformanceBySubject($sch_reg_no)
    {
        $yearData = $this->results_model->getAcademicYear();
        $allYears = [];

        foreach ($yearData as $value) {
            array_push($allYears, $value);
        }

        $subjects = $this->subject_model->as_array()->where(['entry' => 1])->get_all();
       
        $performanceData = [];

        foreach($subjects as $subject) {
            
            foreach ($allYears as $year) {
                $divisionCount = 0;
                $performance = [];
                $students = $this->getSubjectsStudents($year, $subject['paper_code']);
                foreach ($students as $key => $student) {
                   
                     $results = $this->results_model->where(['stud_reg_no' => $student['stud_reg_no'], 'sch_reg_no' => $sch_reg_no, 'paper_code' => $subject['paper_code'], 'academic_year' => $year])->get_all();
                    if (count($results) == 1) {
                        $grade = $results[0]['aggreagate'];
                    } else {
                        $papers = [];
                        foreach ($results as $value11) {
                            if ($value !== null) {
                               array_push($papers, $value11['aggreagate']); 
                            }
                        }
                        $grade = $this->students_model->getGrade($papers);
                    }

                    if ($grade == 1) {
                        $divisionCount++;
                    }
                }

                array_push($performanceData, ['year' => $year, 'subject' => $subject['name'], 'count' => $divisionCount]);
               
            }
        }

        $data['subject'] = $subjects;
        $data['years'] = $allYears;
        $data['data'] = $performanceData;
        return  $data;
    }

    /**
     * [getSubjectsStudents description]
     * @param  [type] $academicYear [description]
     * @param  [type] $paperCode    [description]
     * @return [type]               [description]
     */
    public function getSubjectsStudents($academicYear, $paperCode)
    {
        $studentData = $this->results_model->fields('stud_reg_no')->where(['academic_year' => $academicYear, 'paper_code' => $paperCode])->get_all();

        return $studentData;
    }

	/**
	 * [search description]
	 * @return [type] [description]
	 */
	public function search()
	{
		if($_POST) {  
			$searchType = $this->input->post('search_type', true);
	        $searchValue = $this->input->post('search_value', true);
			$student = ['name', 'stud_reg_no'];
			$school = ['name', 'district'];
			$finalData = [];
			if ($searchType == 1) {
				$finalData['search_results'] = $this->search_model->get_results($searchType, $school[0], $searchValue);
				if (empty($finalData['search_results'] )) {
					$finalData['search_results'] = $this->search_model->get_results($searchType, $school[1], $searchValue);
				}

				$results = count($finalData['search_results']);

				if ($results >= 1 ) {
					foreach ($finalData['search_results'] as $key => $school) {
						$data = $this->students_model->where('sch_reg_no', $school['sch_reg_no'])->get_all();
						$finalData['search_results'][$key]['student'] = $data;
						$finalData['search_results'][$key]['total_students'] = count($data);
						$finalData['total_count'] = count($finalData['search_results']);
					}
				}
				$finalData['search_term'] = $searchValue;
				$finalData['search_type'] = $searchType;

			} else {
				$finalData['search_results'] = $this->search_model->get_results($searchType, $student[0], $searchValue);
				if (empty($finalData['search_results'] )) {
					$finalData['search_results'] = $this->search_model->get_results($searchType, $student[1], $searchValue);
					
				}
				$results = count($finalData['search_results']);
				if ($results >= 1 ) {
					foreach ($finalData['search_results'] as $key => $student) {
						$data = $this->school_model->where('sch_reg_no', $student['sch_reg_no'])->get();
						$finalData['search_results'][$key]['school'] = $data;
						$finalData['total_count'] = count($finalData['search_results']);
					}
				}
				$finalData['search_term'] = $searchValue;
				$finalData['search_type'] = $searchType;
			}
			$this->load->view('search_results', $finalData);
		}
	}

	/**
	 * [searchDetailsSchool description]
	 * @param  [type] $sch_reg_no [description]
	 * @return [type]             [description]
	 */
	public function searchDetailsSchool($sch_reg_no)  
	{
		$data['school'] = $this->school_model->where('sch_reg_no', $sch_reg_no)->get();
		$studentData = $this->students_model->where('sch_reg_no', $sch_reg_no)->get_all();
		$data['subjectData'] = $this->getPerformanceBySubject($sch_reg_no);
		$data['genderData'] = $this->getPerformanceBySex();
		$data['districtPerformanceData'] = $this->getPerformanceByDistrict();
		$data['lineData'] = $this->getTrendByCountry();
		$data['subjectLineData'] = $this->getTrendBySubjectDataOlevel($sch_reg_no);
		$data['count'] = count($studentData);
		$this->googlemaps->initialize();
        $data['map'] = $this->googlemaps->create_map();

		$this->load->view('search_school_details', $data);
	}

	/**
	 * [searchDetailsStudent description]
	 * @param  [type] $school  [description]
	 * @param  [type] $stud_no [description]
	 * @return [type]          [description]
	 */
	public function searchDetailsStudent($school, $stud_no) 
    {
        $stud_reg_no = $school . '/' . $stud_no;

		$data['studentData'] = $this->students_model->viewStudent($stud_reg_no);
		if ($data['studentData']['entry'] == 2) {
			$data['courses'] = $this->students_model->getStudentCourseList($stud_reg_no, $data['studentData']['academic_year']);
		}
		$data['studentData']['type'] = $data['studentData']['entry'];
		$data['studentData']['sex'] = $this->students_model->gender($data['studentData']['sex']);
        $data['studentData']['entry'] = $this->students_model->entry($data['studentData']['entry']);
		$data['subjectData'] = $this->getPerformanceBySubject($data['studentData']['sch_reg_no']);
		$data['genderData'] = $this->getPerformanceBySex();
		$data['lineData'] = $this->getTrendByCountry();
		$data['districtPerformanceData'] = $this->getPerformanceByDistrict();
		$data['subjectLineData'] = $this->getTrendBySubjectDataOlevel($data['studentData']['sch_reg_no']);

		$this->googlemaps->initialize();
        $data['map'] = $this->googlemaps->create_map();

		$this->load->view('search_student_details', $data);
	}

	/**
	 * [getBestStudent description]
	 * @return [type] [description]
	 */
	public function getBestPerformanceData() 
	{
		$yearData = $this->results_model->getAcademicYear();
        $allYears = [];
        $finalBestStudent = [];
        $entry = ['1', '2'];

        foreach ($yearData as $value) {
            array_push($allYears, $value);
        }
        $resultsData = [];
        $score = [];
        foreach ($entry as $entryValue) {
        	foreach ($allYears as $year) {
        		$studentData = $this->students_model->with_school()->where(['academic_year' => $year, 
        			'entry' => $entryValue])->get_all();
        		foreach ($studentData as $key => $student) {
        			$results = $this->students_model->getStudentResult($student['stud_reg_no'], $year);
        			if ($entryValue == 1) {
        				if ($results['finalGrade'] >= 8) {
        					$total = $results['finalGrade'];
        				}
        			} elseif ($entryValue == 2) {
        				if ($results['finalPoints'] <= 20) {
        					$total = $results['finalPoints'];
        				}
        			} 
    				array_push($resultsData, [
    					'school' => $student['school']['name'],
    					'district' => $student['school']['district'],
    					'student' => $student['name'],
    					'entry' => $entryValue,
    					'year' => $year,
    					'result' => $total
    				]);

    				array_push($score, [$entryValue => [$year => [$total]]]);
        		}
	        }
        }

        $finalPerformanceData['data'] = $resultsData;
        $finalPerformanceData['score'] = $score;

        return $finalBestStudent;
	}

	public function getYears() 
	{
		$yearData = $this->results_model->getAcademicYear();
        $allYears = [];

        foreach ($yearData as $value) {
            array_push($allYears, $value);
        }

        return $allYears;
	}

	public function getBestStudent() {
		/*asort($score, SORT_REGULAR);
    	$best = array_values($score);
    
    	foreach ($resultsData as $key => $winner) {
    		//vdebug($winner);
    		if ($winner['result'] == $best[0] && $best[0]) {
    			array_push($finalBestStudent, [ $entryValue => ['year' => $year, 'student' => $resultsData[$key]]]);	
    		}
    	}*/
	}

	/**
	 * Get trend performance over the years
	 * @return object
	 */
	public function getTrendByCountry()
	{
		$allYears = array_reverse($this->getYears()); 
        $entry = ['1', '2'];
        $lineGraph = [];
		foreach ($entry as $entryValue) {
			foreach ($allYears as $year) {
				$data = $this->students_model->as_array()->where(['academic_year' => $year, 'entry' => $entryValue])->get_all();
				$division1 = 0;
				if(!empty($data)) {
					foreach ($data as $student) {
						$results = $this->students_model->getStudentResult($student['stud_reg_no'], $student['academic_year']);
						if ($student['entry'] == 1) {
							$a = (int)$results['finalGrade'];	
							if ( 8 <= $a && $a <= 31) {
								$division1++;
							}
						} else {
							$a = (int)$results['finalPoints'];	
							if ( 16 <= $a && $a <= 20) {
								$division1++;
							}
						}
					}	
				}
				 
				array_push($lineGraph, ['entry' => $entryValue, 'count' => $division1]);	
			} 
        }

        $lineGraphData = [];
        
        $olevel = [];
        $alevel = [];

        foreach ($lineGraph as $key => $line) { 	
	    	if($line['entry'] == 1) {
	    		array_push($olevel, $line['count']);
	    	}

	    	if($line['entry'] == 2) {
	    		array_push($alevel, $line['count']);
	    	}
	    }

        $lineGraphData['labels'] = $allYears;
        foreach ($entry as $key => $entryValue) {
        	$color = $this->colorGenerator();

            if($entryValue == 1) {
	    		$lineData = $olevel;
	    		$lineGraphData['datasets'][$key]['label'] = $this->students_model->entry($entryValue) . ' [Number of Distinction One]';
	    	}

	    	if($entryValue == 2) {
	    		$lineData = $alevel;
	    		$lineGraphData['datasets'][$key]['label'] = $this->students_model->entry($entryValue) . ' [Total Points > 16]';
	    	}

	    	
	    	$lineGraphData['datasets'][$key]['fill'] = false;
            $lineGraphData['datasets'][$key]['lineTension'] = 0.1; 
            $lineGraphData['datasets'][$key]['backgroundColor'] = 'rgba(' .  $color . ',0.4)';
            $lineGraphData['datasets'][$key]['borderColor'] = 'rgba(' .  $color . ',1)';
            $lineGraphData['datasets'][$key]['borderCapStyle'] = 'butt';
            $lineGraphData['datasets'][$key]['borderDash'] = [];
            $lineGraphData['datasets'][$key]['borderDashOffset'] = 0.0;
            $lineGraphData['datasets'][$key]['borderJoinStyle'] = 'miter';
            $lineGraphData['datasets'][$key]['pointBorderColor'] = 'rgba(' .  $color . ',1)';
            $lineGraphData['datasets'][$key]['pointBackgroundColor'] = "#fff";
            $lineGraphData['datasets'][$key]['pointBorderWidth'] = 1;
            $lineGraphData['datasets'][$key]['pointHoverRadius'] = 5;
            $lineGraphData['datasets'][$key]['pointHoverBackgroundColor'] = 'rgba(' .  $color .',1)';
            $lineGraphData['datasets'][$key]['pointHoverBorderColor'] = "rgba(220,220,220,1)";
            $lineGraphData['datasets'][$key]['pointHoverBorderWidth'] = 2;
            $lineGraphData['datasets'][$key]['pointRadius'] = 1;
            $lineGraphData['datasets'][$key]['pointHitRadius'] = 10;
	        $lineGraphData['datasets'][$key]['data'] = $lineData;
	        $lineGraphData['datasets'][$key]['spanGaps'] = false;
        }

        return json_encode($lineGraphData, true);
	}

	public function getTrendBySubjectDataOlevel($sch_reg_no)
	{
		$allYears = array_reverse($this->getYears());
		$entry = ['1', '2'];
		$trendData = [];
		$subjectsResults = [];
		$subjectData = $this->getTrendBySubjectData($sch_reg_no , 1);
		foreach ($subjectData as $key => $subjectsResult) {
			array_push($subjectsResults, $subjectData[$key]['subject']);
		}

		$this->load->model('subject_model');
        $subjects = $this->subject_model->where(['entry' => 1])->get_all();
        foreach ($allYears as $year) {
	        foreach ($subjects as $id => $subject) {
	        	$paperCount = [];
	        	foreach ($subjectsResults as $key => $result) {
	        		if($subject['paper_code'] == $result[$id]['paper_code'] && $result[$id]['year'] == $year) {
	        			if ($result[$id]['aggregate'] == 1) {
	        				array_push($paperCount, $result[$id]['aggregate']);
	        			}
	        		} 
	        	}

	        	array_push($trendData, ['year' => $year, 'subject' => $subject['name'], 'paper_code' => $subject['paper_code'], 'count' => count($paperCount)]);
		    }
		}

		$subData = [];
		$lineGraphData = [];
		$lineGraphData['labels'] = $allYears;
    	foreach ($subjects as $id => $subject) {
    		$subjectCount = [];
    		foreach ($trendData as $key => $lineData) {
        		
        		if ($subject['paper_code'] == $lineData['paper_code']) {
        			array_push($subjectCount, $lineData['count']);
        		}
	        	
		    }

		    array_push($subData, ['subject' => $subject['name'], 'count' => $subjectCount]);
        }

        foreach ($subData as $key => $lineData) { 

    		$color = $this->colorGenerator();

	    	$lineGraphData['datasets'][$key]['label'] = $lineData['subject'];
	    	$lineGraphData['datasets'][$key]['fill'] = false;
            $lineGraphData['datasets'][$key]['lineTension'] = 0.1; 
            $lineGraphData['datasets'][$key]['backgroundColor'] = 'rgba(' .  $color . ',0.4)';
            $lineGraphData['datasets'][$key]['borderColor'] = 'rgba(' .  $color . ',1)';
            $lineGraphData['datasets'][$key]['borderCapStyle'] = 'butt';
            $lineGraphData['datasets'][$key]['borderDash'] = [];
            $lineGraphData['datasets'][$key]['borderDashOffset'] = 0.0;
            $lineGraphData['datasets'][$key]['borderJoinStyle'] = 'miter';
            $lineGraphData['datasets'][$key]['pointBorderColor'] = 'rgba(' .  $color . ',1)';
            $lineGraphData['datasets'][$key]['pointBackgroundColor'] = "#fff";
            $lineGraphData['datasets'][$key]['pointBorderWidth'] = 1;
            $lineGraphData['datasets'][$key]['pointHoverRadius'] = 5;
            $lineGraphData['datasets'][$key]['pointHoverBackgroundColor'] = 'rgba(' .  $color .',1)';
            $lineGraphData['datasets'][$key]['pointHoverBorderColor'] = "rgba(220,220,220,1)";
            $lineGraphData['datasets'][$key]['pointHoverBorderWidth'] = 2;
            $lineGraphData['datasets'][$key]['pointRadius'] = 1;
            $lineGraphData['datasets'][$key]['pointHitRadius'] = 10;
	        $lineGraphData['datasets'][$key]['data'] = $lineData['count'];
	        $lineGraphData['datasets'][$key]['spanGaps'] = false;
	    }

		return json_encode($lineGraphData);

	}

	protected function colorGenerator() 
	{
		$spread = 25;

		for ($row = 0; $row < 100; ++$row) {
	        for($c = 0; $c < 3; ++$c) {
	        	$color[$c] = rand(0+$spread,255-$spread);
		    } 
		    for($i = 0; $i < 2; ++$i) {
			    $r = rand($color[0]-$spread, $color[0]+$spread);
			    $g = rand($color[1]-$spread, $color[1]+$spread);
			    $b = rand($color[2]-$spread, $color[2]+$spread);

			    return $r . ',' . $g . ',' . $b;
		    } 
		}
	}

	protected function rgb2hex($rgb) {
	   $hex = "#";
	   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

	   return $hex; // returns the hex value including the number sign (#)

	}

	protected function getTrendBySubjectData($sch_reg_no, $entry) {
		$allYears = array_reverse($this->getYears());
        $lineGraph = [];
        $allStudents = [];
        $results = [];
		foreach ($allYears as $year) {
			$data = $this->students_model->as_array()->where(['sch_reg_no' => $sch_reg_no, 'academic_year' => $year, 'entry' => $entry])->get_all();
			array_push($allStudents, ['year' => $year, 'student' => $data]);
			if (!empty($allStudents[0]['student'])) {
				foreach ($allStudents[0]['student'] as $student) {
					$studentData = $this->students_model->getStudentResult($student['stud_reg_no'], $year);
					if(!empty($studentData)) {
						array_push($results, ['year' => $year, 'subject' => $studentData['subject']]);
					}
				}
			} else {
				return [];
			}
			
		}

		return $results;
    }

    protected function getDistricts() 
    {
    	$school = [];
    	$schoolDetails = $this->school_model->get_all(); 

    	$schoolCount = count($schoolDetails);
    	for($i = 0; $i < $schoolCount; $i++) {
    		array_push($school, $schoolDetails[$i]['district']);
    	}

    	return $school;
    }
}
