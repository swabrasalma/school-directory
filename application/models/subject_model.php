<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_many = array('foreign_model' => 'student_model', 'foreign_table' => 'student', 'foreign_key' => 'sch_reg_no');
    public $table = 'subject';
    public $primary_key = 'paper_code';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
        $this->return_as = 'array';
    }

    public $rules = array(
            'insert' => array(

                    'paper_code' => array(
                        'field'=>'paper_code',
                        'label'=>'paper_code',
                        'rules'=>'trim|required'
                    ),

                    'paper' => array(
                        'field'=>'paper',
                        'label'=>'paper',
                        'rules'=>'trim|required'
                    ),

                    'entry' => array(
                        'field'=>'entry',
                        'label'=>'entry',
                        'rules'=>'trim|required'
                    )

            ),

            'update' => array(
                'paper_code' => array(
                    'field'=>'paper_code',
                    'label'=>'paper_code',
                    'rules'=>'trim|required'
                ),

                'paper' => array(
                    'field'=>'paper',
                    'label'=>'paper',
                    'rules'=>'trim|required'
                ),

                'entry' => array(
                    'field'=>'entry',
                    'label'=>'entry',
                    'rules'=>'trim|required'
                ),
            )                    
    );

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
    public function getExcelData($excelFile, $type){
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
          
        $subjectData = array_values($resultsValues);
        $finalData = [];

        foreach ($subjectData as $results) {
             
            array_push($finalData, [
                'paper_code' => $results['A'],
                'name' =>  $results['B'],
                'entry' => $type,
                
            ]); 
        }

        foreach ($finalData as $studentDetails) {
            $this->subject_model->insert($studentDetails);
        }

        return true;
    }

    /**
     * Views a single school
     * @param  int $id school center number
     * @return array
     */
    public function viewSubject($id) {
        $data = $this->subject_model->where(['paper_code' => $id])->get();
        return $data;
    }

    /**
     * List schools
     * @return void
     */
    public function listSubject() {
        $data = $this->subject_model->as_array()->get_all();
        return $data;
    }

    /**
     * Deletes a school
     * @param  int $id school center number or registration.
     * @return void
     */
    public function deleteSubject($id) {
        $this->subject_model->delete($id);
    }

    /**
     * Get All Schools
     * @return void
     */
    public function getAllSchools() 
    {
        $this->load->model('results_model');
        $data = $this->subject_model->get_all();
        $schoolData = [];

        foreach ($data as $key => $value) {
            array_push($schoolData, [
                $value['sch_reg_no'] => $value['name']
            ]);
        }

        $data = $this->results_model->array_flatten($schoolData);
        return $data;
    }

}