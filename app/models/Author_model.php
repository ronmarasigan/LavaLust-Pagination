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
            if (is_null($page)) {
                return $this->db->table('authors')->get_all();
            } else {
                $query = $this->db->table('authors');
                
                // Build LIKE conditions
                $query->like('id', '%'.$q.'%')
                    ->or_like('first_name', '%'.$q.'%')
                    ->or_like('last_name', '%'.$q.'%')
                    ->or_like('birthdate', '%'.$q.'%')
                    ->or_like('email', '%'.$q.'%')
                    ->or_like('added', '%'.$q.'%');

                // Clone before pagination
                $countQuery = clone $query;

                $data['total_rows'] = $countQuery->select_count('*', 'count')
                                                ->get()['count'];

                $data['records'] = $query->pagination($records_per_page, $page)
                                        ->get_all();

                return $data;
            }
        }

    }
?>