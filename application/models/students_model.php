<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_one = array('school' => 'school_model');
    public $table = 'student';
    public $primary_key = 'id';
    public $timestamps = FALSE;
    public $protected = array('id');

    public function __construct()
    {
        parent::__construct();
        $this->has_one['school'] = array('foreign_model' => 'School_model', 'foreign_table' => 'school', 'foreign_key'=>'sch_reg_no', 'local_key' => 'sch_reg_no');
        $this->has_one['result'] = array('foreign_model' => 'Results_model', 'foreign_table' => 'result', 'foreign_key'=>'stud_reg_no', 'local_key' => 'stud_reg_no');
        $this->return_as = 'array';
    }

    /**
     * Views a single school
     * @param  int $id school center number
     * @return array
     */
    public function viewStudent($id) {
        $data = $this->students_model->with_school()->as_array()->where(['stud_reg_no' => $id])->get();
        return $data;
    }

    /**
     * List schools
     * @return void
     */
    public function listStudent() {
        $data = $this->students_model->as_array()->get_all();
        return $data;
    }

    /**
     * Deletes a school
     * @param  int $id school center number or registration.
     * @return void
     */
    public function deleteStudent($id) {
        $this->students_model->delete($id);
    }

     /**
     * Reads from the excel and inserts to the database
     * @return void
     */
    
    /**
     * Inserts students to the database
     * @param  string $excelFile file name
     * @param  int $type entry type['O'level, A'level]
     * @return boolean
     */
    public function getExcelData($excelFile, $type, $academicYear){
        $file = './files/'. $excelFile;
        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        //extract to a PHP readable array format
        foreach ($cell_collection as $key => $cell) {

            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            if ($row > 1) {
                $resultsValues[$row][$column] = $data_value;
            }
        }
          
        $studentsData = array_values($resultsValues);
        $finalData = [];

        foreach ($studentsData as $results) {
            if ($results['F'] != $academicYear) {
                return false;
                break;
            } else {
                array_push($finalData, [
                    'stud_reg_no' => $results['D'],
                    'sch_reg_no' =>  $results['E'],
                    'name' =>  $results['B'],
                    'sex' =>  $results['C'],
                    'academic_year' => $results['F'],
                    'entry' => $type,
                    
                ]);
            }
        }

        foreach ($finalData as $studentDetails) {
            $this->students_model->insert($studentDetails);
        }

        return true;
    }

    public function getStudents($school, $academicYear, $type)
    {
        $data = $this->students_model->with_school(array('fields'=>'name'))->where(['sch_reg_no' => $school, 'academic_year' => $academicYear, 'entry' => $type])->get_all();
        if ($data == false) {
            $data = [];
        } else {
            foreach ($data as $key => $value) {
                $data[$key]['sex'] = $this->gender($value['sex']);
                $data[$key]['entry'] = $this->entry($value['entry']);
            }
        }
        return $data;
    }

    public function getStudentResult($stud_reg_no, $academicYear)
    {
        $data = $this->results_model->with_student(['where' => ['academic_year' => $academicYear]])->with_school()->where(['stud_reg_no' => $stud_reg_no, 'academic_year' => $academicYear])->get();

        $entry = $data['results_type_id'];
        if ($entry == 2) {
            return $this->getAlevelResults($stud_reg_no, $academicYear);
        } elseif ($entry == 1) {

            $resultsData = [];
            $this->load->model('subject_model');
            $subjects = $this->subject_model->where(['entry' => $entry])->get_all();

            foreach ($subjects as $key => $subject) {
                $papers = [];
                $results = $this->results_model->where(['stud_reg_no' => $stud_reg_no, 'paper_code' => $subject['paper_code'], 'academic_year' => $academicYear])->get_all();

                foreach ($results as $key => $value) {
                    if ($value !== null) {
                       array_push($papers, $value['aggreagate']); 
                    }
                    
                }
                array_push(
                    $resultsData,
                    ['subject' => $subject['name'],
                    'paper_code' => $subject['paper_code'],
                    'aggregate' => $this->getGrade($papers),
                    'year' => $academicYear
                    ]
                );
                
            }

            $finalGrade = [];
            foreach ($resultsData as $key => $value) { 
                array_push($finalGrade, $value['aggregate']);
            }
            asort($finalGrade, SORT_REGULAR);

            $studentData['school'] = $data['school'];
            $studentData['student'] = $data['student'];

            if ($entry == 1 ) {
                $studentData['subject'] = $resultsData;
                $finalScore = array_sum(array_slice($finalGrade, 0, 8));
                $studentData['finalGrade'] = $finalScore;
            }

            return $studentData;
        } else {
            return [];
        }
    }

    public function getAlevelResults($stud_reg_no, $academicYear) {
        $studentData = [];
        $paperCodes = $this->getStudentPapers($stud_reg_no, $academicYear);
        $studentDetails = $this->students_model->with_school()->where(['stud_reg_no' => $stud_reg_no, 'academic_year' => $academicYear])->get();

        $aLevelGradeScore = [
            'A' => 6,
            'B' => 5,
            'C' => 4,
            'D' => 3,
            'E' => 2,
            'O' => 1,
            'F' => 0
        ];

        $resultsData = [];
        foreach ($paperCodes as $paper) {

            $this->load->model('subject_model');
            $subjects = $this->subject_model->where(['paper_code' => $paper])->get();

            if (count($subjects) > 1) {
                $papers = [];
                $results = $this->results_model->where(['stud_reg_no' => $stud_reg_no, 'paper_code' => $paper, 'academic_year' => $academicYear])->get_all();
                
               foreach ($results as $key => $result) {
                    if ($result !== null) {
                       array_push($papers, $aLevelGradeScore[strtoupper($result['grade'])]); 
                    }
                    
                }
                array_push(
                    $resultsData, [
                    'subject' => $subjects['name'],
                    'paper_code' => $paper,
                    'aggregate' => $this->getGrade($papers),
                    'year' => $academicYear
                    ]
                );
            } 
                
        }
        
        $totalPoints = 0;
        $score =  array_flip($aLevelGradeScore);
        foreach ($resultsData as $key => $value) {
            if (strtok($value['subject'], ' ') == 'General') {
                $resultsData[$key]['grade'] = 'O';
                $totalPoints += $aLevelGradeScore['O'];
            } elseif (strtok($value['subject'], ' ') == 'Subsidiary') {
                $resultsData[$key]['grade'] = 'O';
                $totalPoints += $aLevelGradeScore['O'];
            } elseif (strtok($value['subject'], ' ') == 'ICT') {
                $resultsData[$key]['grade'] = 'O';
                $totalPoints += $aLevelGradeScore['O'];
            } else {
               $resultsData[$key]['grade'] = $score[$value['aggregate']];
               $totalPoints += $aLevelGradeScore[$score[$value['aggregate']]];
            }
        }

        $studentData['school'] = $studentDetails['school'];
        $studentData['student'] = $studentDetails;
        $studentData['subject'] = $resultsData;
        $studentData['finalPoints'] = $totalPoints;

        return $studentData;

    }

    /**
     * Get list students who qualify for a given courser
     * @param  int $course_code course code for the university cours eg. BSSE 3450
     * @param  int $universitId University Id.
     * @return array
     */
    public function getCourseList($course_code, $universityId, $academicYear) {
        $students = $this->students_model->with_school()->where(['academic_year' => $academicYear, 'entry' => 2])->get_all();
        $studentList = [];
        foreach ($students as $student) {
            $studentCourseList = $this->getStudentCourseList($student['stud_reg_no'], $academicYear);
            array_push($studentList, ['student' => $student, 'list' => $studentCourseList]);
        }

        $studentFinalList = [];
        foreach ($studentList as $studentDetail) {
            $courses = array_column($studentList, 'list');
            foreach ($courses as $courseDetail) { 
                foreach ($courseDetail['allowed'] as $record) {
                    if ($course_code == $record['course_code'] && $universityId == $record['university_id']) {
                        array_push($studentFinalList, $studentDetail);
                    }
                } 
            }
        }
        vdebug($studentFinalList);
    }

    /**
     * Get list of courses a student can and can't qualify for in a given university
     * @param  string $stud_reg_no the student number
     * @param  int $academicYear The year of sitting of the student. 
     * @return array
     */
    public function getStudentCourseList($stud_reg_no, $academicYear) {
            $this->load->model('course_model');
            $this->load->model('essential_model');
            $courseList = $this->course_model->getCourseList();
            $studentResults = $this->getAlevelResults($stud_reg_no, $academicYear); 
            $allowedCourse = [];
            $notAllowedCourse = [];
            foreach ($courseList as $key => $course) {
                $essentialPaperCodes = $this->essential_model->where(['course_code' => $course['course_code']])->get_all(); 
                $totalWeights = [];
                $totalCutoffPoints = [];
                foreach ($essentialPaperCodes as $essentialPaper) {
                    $essentialPaperCount = 0;
                    foreach ($studentResults['subject'] as $key => $subject) {
                       if ($subject['paper_code'] == $essentialPaper['paper_code'] && $essentialPaper['course_code'] == $course['course_code']) {
                            if ($essentialPaper['required'] == 1 ) {
                                $weight = $this->getTotalWeight($subject['aggregate'], $essentialPaper['required']);
                                array_push($totalCutoffPoints, $weight);
                                $essentialPaperCount++;
                            } else {
                                 $weight = $this->getTotalWeight($subject['aggregate'], $essentialPaper['required']);
                                array_push($totalCutoffPoints, $weight);
                            }
                        } 
                    }
                }
                array_push($totalWeights, array_sum(array_unique(array_values($totalCutoffPoints))));

                if ($essentialPaperCount >= 0) { 
                    if (!empty($totalWeights)) {
                        if ((int)$totalWeights[0] >= (int)$course['cut_off_points']) {
                            array_push($allowedCourse, [
                                'course_name' => $course['course_name'],
                                'course_code' => $course['course_code'],
                                'university' => $course['university']['name'],
                                'university_id' => $course['university_id'],
                                'cut_off_points' => $totalWeights[0]
                            ]);
                        } else {
                            array_push($notAllowedCourse, [
                                'course_name' => $course['course_name'],
                                'course_code' => $course['course_code'],
                                'university' => $course['university']['name'],
                                'university_id' => $course['university_id'],
                                'cut_off_points' => (int)$totalWeights[0]
                            ]);
                        }
                    }
                } else {
                    array_push($notAllowedCourse, [
                        'course_name' => $course['course_name'],
                        'course_code' => $course['course_code'],
                        'university_id' => $course['university_id'],
                        'cut_off_points' => (int)$totalWeights[0]
                    ]);
                }
                
            }
            $studentCourseList['allowed'] = $allowedCourse;
            $studentCourseList['notAllowed'] = $notAllowedCourse;
                
            return $studentCourseList;
    }

    /**
     * [getTotalWeight description]
     * @param  [type] $aggregate       [description]
     * @param  [type] $essentialNumber [description]
     * @return [type]                  [description]
     */
    public function getTotalWeight($aggregate, $essentialNumber) {

            $essential = ['', '3', '2', '1'];
            $weight = $aggregate * $essential[$essentialNumber];
            return $weight;
    }

    /**
     * Gets the students papers
     * @param  string $stud_reg_no  student registration number
     * @param  int $academicYear Academic year of the student
     * @return array
     */
    public function getStudentPapers($stud_reg_no, $academicYear) {
        $studResults = $this->results_model->where(['stud_reg_no' => $stud_reg_no, 'academic_year' => $academicYear])->get_all();

        
        $paperCode = [];
        foreach ($studResults as $paper) {
            array_push($paperCode, $paper['paper_code']);
        }

        $papers = array_unique($paperCode);
        rsort($papers, SORT_NUMERIC);

        return $papers;

    }

    /**
     * Get the average of the results of the students papers
     * @param  array $papers [paper1, paper2, paper3]
     * @return int
     */
    public function getGrade($papers)
    {
        $totalPapers = count($papers);
        $finalAggreagate = array_sum(array_values($papers)) / $totalPapers;

        return (int)round($finalAggreagate);
    }

    /**
     * @param int $value  value (F, M)
     * @return string
     */
    public static function gender($value = null)
    {
        if (self::GENDER_MALE == $value) {
            return 'Male';
        }

        if (self::GENDER_FEMALE == $value) {
            return 'Female';
        }  
    }

    

    /**
     * @param int $value  value (1, 2)
     * @return string
     */
    public static function entry($value = null)
    {
        if (self::O_LEVEL == $value) {
            return "O'Level";
        }

        if (self::A_LEVEL == $value) {
            return "A'Level";
        }  
    }

    // Constants for gender attribute 
    const GENDER_MALE = 'M';

    const GENDER_FEMALE = 'F';

    // Constants for entry
    const O_LEVEL = '1';

    const A_LEVEL = '2';
}