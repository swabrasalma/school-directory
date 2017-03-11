<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_one = array('Posts_model','foreign_key','another_local_key');
    public $table = 'course';
    public $primary_key = 'course_code';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
        $this->has_one['university'] = array('foreign_model' => 'university_model', 'foreign_table' => 'university', 'foreign_key'=>'id', 'local_key' => 'university_id');
        $this->return_as = 'array';
    }

    /**
     * Gets all courses
     * @return array
     */
    public function getCourseList() {
        $data = $this->course_model->with_university()->get_all();
        return $data;
    }
}