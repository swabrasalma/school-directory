<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class School_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_many = array('foreign_model' => 'student_model', 'foreign_table' => 'student', 'foreign_key' => 'sch_reg_no');
    public $table = 'school';
    public $primary_key = 'sch_reg_no';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
        $this->has_many['students'] = array('foreign_model' => 'Students_model', 'foreign_table' => 'student', 'foreign_key'=>'sch_reg_no', 'local_key' => 'sch_reg_no');
        $this->return_as = 'array';
    }

    public $rules = array(
            'insert' => array(

                    'sch_reg_no' => array(
                        'field'=>'sch_reg_no',
                        'label'=>'sch_reg_no',
                        'rules'=>'trim|required'
                    ),

                    'name' => array(
                        'field'=>'name',
                        'label'=>'name',
                        'rules'=>'trim|required'
                    ),

                    'year' => array(
                        'field'=>'year',
                        'label'=>'year',
                        'rules'=>'trim|required'
                    ),

                    'school_type' => array(
                        'field'=>'school_type',
                        'label'=>'school_type',
                        'rules'=>'trim|required'
                    ),

                    'district' => array(
                        'field'=>'district',
                        'label'=>'district',
                        'rules'=>'trim|required'
                    ),

                    'latitude' => array(
                        'field'=>'latitude',
                        'label'=>'latitude',
                        'rules'=>'trim|required'
                    ),

                    'longitude' => array(
                        'field'=>'longitude',
                        'label'=>'longitude',
                        'rules'=>'trim|required'
                    ),



            ),

            'update' => array(
                    'sch_reg_no' => array(
                        'field'=>'sch_reg_no',
                        'label'=>'sch_reg_no',
                        'rules'=>'trim|required'
                    ),

                    'name' => array(
                        'field'=>'name',
                        'label'=>'name',
                        'rules'=>'trim|required'
                    ),

                    'year' => array(
                        'field'=>'year',
                        'label'=>'year',
                        'rules'=>'trim|required'
                    ),

                    'school_type' => array(
                        'field'=>'school_type',
                        'label'=>'school_type',
                        'rules'=>'trim|required'
                    ),

                    'district' => array(
                        'field'=>'district',
                        'label'=>'district',
                        'rules'=>'trim|required'
                    ),

                    'latitude' => array(
                        'field'=>'latitude',
                        'label'=>'latitude',
                        'rules'=>'trim|required'
                    ),

                    'longitude' => array(
                        'field'=>'longitude',
                        'label'=>'longitude',
                        'rules'=>'trim|required'
                    ),
                    'id' => array(
                        'field'=>'id',
                        'label'=>'ID',
                        'rules'=>'trim|is_natural_no_zero|required'
                    ),
            )                    
    );

    /**
     * Views a single school
     * @param  int $id school center number
     * @return array
     */
    public function viewSchool($id) {
        $data = $this->school_model->as_array()->where(['sch_reg_no' => $id])->get();
        return $data;
    }

    /**
     * List schools
     * @return void
     */
    public function listSchool() {
        $data = $this->school_model->as_array()->get_all();
        return $data;
    }

    /**
     * Deletes a school
     * @param  int $id school center number or registration.
     * @return void
     */
    public function deleteSchool($id) {
        $this->school_model->delete($id);
    }

    /**
     * Get All Schools
     * @return void
     */
    public function getAllSchools() 
    {
        $this->load->model('results_model');
        $data = $this->school_model->as_array()->get_all();
        $schoolData = [];

        foreach ($data as $key => $value) {
            array_push($schoolData, [
                $value['sch_reg_no'] => $value['name']
            ]);
        }

        $data = $this->results_model->array_flatten($schoolData);
        return $data;
    }

    /**
     * @param int $value  value
     * @return string
     */
    public static function schoolType($value = null)
    {
        $options = [
            self::GOVERMENT_SCHOOL => __('Goverment', true),
            self::PRIVATE_SHOOL => __('Private', true),
        ];
        return self::enum($value, $options);
    }

    // Constants for school type attributes attribute 
    const GOVERMENT_SCHOOL = '1';

    const PRIVATE_SHOOL = '2';
}