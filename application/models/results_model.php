<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Results_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_one = array('Posts_model','foreign_key','another_local_key');
    public $table = 'results';
    public $primary_key = 'id';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
        $this->has_one['student'] = array('foreign_model' => 'Students_model', 'foreign_table' => 'student', 'foreign_key'=>'stud_reg_no', 'local_key' => 'stud_reg_no');
        $this->has_one['school'] = array('foreign_model' => 'School_model', 'foreign_table' => 'school', 'foreign_key'=>'sch_reg_no', 'local_key' => 'sch_reg_no');
        $this->return_as = 'array';
    }

     
    /**
     * Reads from the excel and inserts to the database
     * @param  string $excelFile    file name
     * @param  string $sch_reg_no   school registration number
     * @param  int $academicYear academic year [2010,2011,2013]
     * @param  int $type results type [eg. O'level and A'level]
     * @return boolean
     */
    public function getExcelData($excelFile, $sch_reg_no, $academicYear, $type){
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

            if ($row > 0 &&  $row <= 7) {
                $schoolDetails[$row] = $data_value;
            }

            if ($row > 8) {
                $resultsValues[$row][$column] = $data_value;
            }
        }
         
        $schoolData = array_values($schoolDetails);
        $data = [
            'name' => $schoolData[0],
            'sch_reg_no' => $schoolData[1],
            'district' => $schoolData[2],
            'academic_year' => $schoolData[3],
            'subject' => $schoolData[4],
            'paper' => $schoolData[5],
            'paperCode' => $schoolData[6]
        ];

        $schoolResultsData = array_values($resultsValues);
        $resultsData = [];

        foreach ($schoolResultsData as $key => $results) {
            array_push($resultsData, [
                'stud_reg_no' => $results['D'],
                'sch_reg_no' =>  $data['sch_reg_no'],
                'paper_code' =>  $data['paperCode'],
                'paper' => $data['paper'],
                'score' => $results['E'],
                'aggreagate' => $results['F'],
                'academic_year' => $data['academic_year'],
                'district_of_origin' => $results['H'],
                'results_type_id' => $type
            ]);

            if($type == 2) {
                $resultsData[$key]['grade'] = $results['G'];
            }
        }

        if ($data['sch_reg_no'] == $sch_reg_no && $data['academic_year'] == $academicYear) {
            foreach ($resultsData as $studentResults) {
                $this->results_model->insert($studentResults);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Flattens array to key value formart
     * @param  array $array 
     * @return viod
     */
    public function array_flatten($array)
    { 
        return iterator_to_array(
            new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array))
        );
    }

    /**
     * Gets the academic years of results
     * @return array
     */
    public function getAcademicYear() {

        $years = [];
        $allYears = $this->results_model->as_array()->fields('academic_year')->get_all();

        foreach ($allYears as $year) {
            array_push($years, $year['academic_year']);
        }

        $yearData = array_unique($years);
        rsort($yearData, SORT_NUMERIC);

        return $yearData;
    }
}
