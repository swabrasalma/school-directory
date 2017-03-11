<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {


    public function get_results($table, $tableField, $search_term=null)
    {
        $this->load->model('students_model');
        $tableName = ['', 'school', 'student'];
        // Use the Active Record class for safer queries.
        $this->db->select('*');
        $this->db->from($tableName[$table]);
        $this->db->like($tableField, $search_term);

        // Execute the query.
        $query = $this->db->get();

        $data = $query->result_array();

        if ($tableName[$table]== 'student') {
           foreach ($data as $key => $value) {
                $data[$key]['sex'] = $this->students_model->gender($value['sex']);
                $data[$key]['entry'] = $this->students_model->entry($value['entry']);
            } 
        }
        
        // Return the results.
        return $data;
    }

}