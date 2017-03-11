<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Essential_model extends MY_Model
{
    //public $soft_deletes = TRUE;
    //public $has_one = array('Posts_model','foreign_key','another_local_key');
    public $table = 'subject_essential';
    public $primary_key = 'course_code';
    public $timestamps = FALSE;
    public $protected = array('id');

    function __construct()
    {
        parent::__construct();
         $this->return_as = 'array';
    }
}