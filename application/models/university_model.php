<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class University_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    public $table = 'university';
    public $primary_key = 'id';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
         $this->has_many['course'] = array('foreign_model' => 'course_model', 'foreign_table' => 'course', 'foreign_key'=>'university_id', 'local_key' => 'id');
        $this->return_as = 'array';
    }

    public $rules = array(
        'insert' => array(
            'name' => array(
            'field'=>'name',
            'label'=>'name',
            'rules'=>'trim|required'
            ),

            'co_ordinates' => array(
            'field'=>'co_ordinates',
            'label'=>'co_ordinates',
            'rules'=>'trim|required'
            ),

            'district' => array(
            'field'=>'district',
            'label'=>'district',
            'rules'=>'trim|required'
            )
        ),
                    
    );
     /**
     * Views a single universities
     * @param  int $id university id
     * @return array
     */
    public function viewUniversity($id) {
        $data = $this->university_model->as_array()->where(['id' => $id])->get();
        return $data;
    }

    /**
     * List Universities
     * @return void
     */
    public function listUniversity() {
        $data = $this->university_model->as_array()->get_all();
        return $data;
    }

    /**
     * Deletes a university
     * @param  int $id university id.
     * @return void
     */
    public function deleteUniversity($id) {
        $this->university_model->delete($id);
    }
}