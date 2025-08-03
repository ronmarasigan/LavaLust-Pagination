<?php
    defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

    class Author_model extends Model {
        
        protected $table = '';
        protected $primary_key = 'id';
        
        public function __construct()
        {
            parent::__construct();
        }

        public function page($q, $records_per_page = null, $page = null) {
        if(is_null($page)) {
            return $this->db->table('authors')->get_all();
        } else {
            $data['records'] = $this->db->table('authors')
                        ->like('id', '%'.$q.'%')
                        ->or_like('first_name', '%'.$q.'%')
                        ->or_like('last_name', '%'.$q.'%')
                        ->or_like('birthdate', '%'.$q.'%')
                        ->or_like('email', '%'.$q.'%')
                        ->or_like('added', '%'.$q.'%')
                        ->pagination($records_per_page, $page)
                        ->get_all();
            $data['total_rows'] = $this->db->raw("select count(*) from authors where id like :id or first_name like :first_name or last_name like :last_name or birthdate like :birthdate or email like :email or added like :address", array('%'.$q.'%', '%'.$q.'%', '%'.$q.'%', '%'.$q.'%', '%'.$q.'%', '%'.$q.'%'))->fetchColumn();
            return $data;
        }

    }
        
    }
    ?>
    