<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 * 
 * Copyright (c) 2020 Ronald M. Marasigan
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 4
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/**
* ------------------------------------------------------
*  Class Model / ORM
* ------------------------------------------------------
 */
class Model {  
    /**
     * Table Name of the Database
     *
     * @var string
     */
    protected $table = '';

    /**
     * Primary Key of the Database Column
     *
     * @var string
     */
    protected $primary_key = 'id';

    /**
     * Column name to use for Soft Delete
     *
     * @var string
     */
    protected $soft_delete_column;

    /**
     * Allow Soft Delete of Rows (It will be added in config/config.php later on)
     *
     * @var boolean
     */
    protected $has_soft_delete;

      /**
     * Class Constructor
     * @return void
     */
    public function __construct()
    {
        //Allow Soft Delete
        $this->has_soft_delete = config_item('soft_delete');
        
        //Soft Delete Column
        $this->soft_delete_column = config_item('soft_delete_column');
    }

    /**
     * Filter input data to only include fillable attributes
     * 
     * @param array $data Input data array
     * @param array $mergeFillable Additional fillable fields for this operation
     * @return array Filtered data array
     */
    protected function fillable_attributes(array $data, array $merge_fillable = [])
    {
        // Determine which fields are fillable
        $fillable = !empty($merge_fillable) 
            ? array_merge($this->fillable, $merge_fillable)
            : $this->fillable;
        
        // If no fillable fields are defined, return empty array (strict mode)
        // To allow all fields when empty, change to: return empty($fillable) ? $data : ...
        if (empty($fillable)) {
            return [];
        }
        
        // Filter the input data
        return array_intersect_key($data, array_flip($fillable));
    }

    /**
     * Find Single Record
     *
     * @param integer $id
     * @param boolean $with_deleted
     * @return void
     */
    public function find($id, $with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->where($this->primary_key, $id)->get();
    }

    /**
     * Row Count
     *
     * @param boolean $with_deleted
     * @return void
     */
    public function count($with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->count();
    }

    /**
     * Find First Record
     *
     * @param boolean $with_deleted
     * @return void
     */
    public function first($with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->order_by($this->primary_key, 'ASC')->limit(1)->get();
    }

    /**
     * Find Last Record
     *
     * @param boolean $with_deleted
     * @return void
     */
    public function last($with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->order_by($this->primary_key, 'DESC')->limit(1)->get();
    }

    /**
     * Return all Rows from the Database
     *
     * @param boolean $with_deleted
     * @return void
     */
    public function all($with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->get_all();
    }

    /**
     * Restore Soft Deleted Row
     *
     * @param int $id
     * @return void
     */
    public function restore($id) {
        if ($this->has_soft_delete) {
            return $this->update($id, [$this->soft_delete_column => NULL]);
        }
        return false;
    }

    /**
     * Check if record exists
     *
     * @param mixed $id_or_conditions
     * @param bool $with_deleted
     * @return bool
     */
    public function exists($conditions = [], $with_deleted = false)
    {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return !empty($this->db->where($conditions)->get_all());
    }

    /**
     * Paginate results
     *
     * @param int $per_page
     * @param int $page
     * @param array $conditions
     * @param bool $with_deleted
     * @return array
     */
    public function paginate($per_page = 10, $page = 1, $conditions = [], $with_deleted = false)
    {
        $offset = ($page - 1) * $per_page;
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        
        $total = $this->db->count();
        $results = $this->db->table($this->table)->limit($per_page, $offset)->get_all();
        
        return [
            'data' => $results,
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $page,
            'last_page' => ceil($total / $per_page)
        ];
    }

    /**
     * Empty Table
     *
     * @return void
     */
    public function truncate() {
        return $this->db->table($this->table)->delete();
    }

    /**
     * Order By
     *
     * @param string $column
     * @param string $order
     * @return void
     */
    public function order_by($column, $order = 'ASC', $with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->order_by($column, $order)->get_all();
    }

    /**
     * Limit
     *
     * @param int $number
     * @return void
     */
    public function limit($number, $with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->limit($number)->get_all();
    }
    
    /**
     * Get Table Columns
     *
     * @return void
     */
    public function get_columns() {
        $stmt = $this->db->raw("SHOW COLUMNS FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Bulk Insert
     *
     * @param array $data
     * @return void
     */
    public function bulk_insert($data) {
        if (!empty($data)) {
            return $this->db->table($this->table)->bulk_insert($data);
        }
        return false;
    }

    /**
     * Bulk Update
     *
     * @param array $data
     * @param int $key
     * @return void
     */
    public function bulk_update($data, $key = 'id') {
        if (!empty($data)) {
            return $this->db->table($this->table)->bulk_update($data, $key);
        }
        return false;
    }

    /**
     * Insert Record to the Database
     *
     * @param array $data
     * @return void
     */
    public function insert($data) {
        $this->db->table($this->table)->insert($data);
        return $this->db->last_id();
    }

    /**
     * Update Record from the Database
     *
     * @param integer $id
     * @param array $data
     * @return void
     */
    public function update($id, $data) {
        return $this->db->table($this->table)->where($this->primary_key, $id)->update($data);
    }

    /**
     * Soft Delete. Check the column name to be added in the table. Check protected $soft_delete_column = 'deleted_at';
     *
     * @param integer $id
     * @return void
     */
    public function soft_delete($id) {
        if ($this->has_soft_delete) {
            return $this->update($id, [$this->soft_delete_column => date('Y-m-d H:i:s')]);
        }
        return $this->delete($id);
    }

    /**
     * Delete Records from the Database
     *
     * @param integer $id
     * @return void
     */
    public function delete($id) {
        return $this->db->table($this->table)->where($this->primary_key, $id)->delete();
    }

    /**
     * Filter using where Clause
     *
     * @param array $conditions
     * @param boolean $with_deleted
     * @return void
     */
    public function filter($conditions = [], $with_deleted = false) {
        $this->db->table($this->table);
        $this->apply_soft_delete($with_deleted);
        return $this->db->where($conditions);
    }

    /**
     * Group by clause
     *
     * @param string $column
     * @return $this
     */
    public function group_by($column)
    {
        $this->db->table($this->table);
        $this->db->group_by($column);
        return $this;
    }

    /**
     * Having clause
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return $this
     */
    public function having($column, $operator, $value)
    {
        $this->db->table($this->table);
        $this->db->having($column, $operator, $value);
        return $this;
    }

    /**
     * Raw SQL Query
     *
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function raw($sql, $params = []) {
        return $this->db->raw($sql, $params);
    }
    /**
     * Apply Soft Delete when Displaying Records
     *
     * @param boolean $with_deleted
     * @return void
     */
    protected function apply_soft_delete($with_deleted) {
        if (!$with_deleted && $this->has_soft_delete) {
            $this->db->where_null($this->soft_delete_column);
        }
    }

    /**
     * ORM Has Many Relationship
     *
     * @param string $related_model
     * @param string $foreign_key
     * @param mixed $current_id
     * @return boolean
     */
    public function has_many($related_model, $foreign_key, $current_id) {
        $this->call->model($related_model);

        if ($current_id) {
            return $this->{$related_model}->where([$foreign_key => $current_id])->get_all();
        }
    
        return false;
    }

    /**
     * ORM Has One Relationship
     *
     * @param string $related_model
     * @param string $foreign_key
     * @param mixed $current_id
     * @return boolean
     */
    public function has_one($related_model, $foreign_key, $current_id) {
        $this->call->model($related_model);
    
        if ($current_id) {
            return $this->{$related_model}->where([$foreign_key => $current_id])->get();
        }
    
        return false;
    }

    /**
     * Many To Many Relationship
     *
     * @param string $related_model
     * @param string $pivot_table
     * @param string $current_key
     * @param string $related_key
     * @param mixed $current_id
     * @return void
     */
    public function many_to_many($related_model, $pivot_table, $current_key, $related_key, $current_id) {
        if (!$current_id) {
            return [];
        }
        
        $this->call->model($related_model);
        $query = "SELECT r.* FROM {$this->{$related_model}->table} r
                 JOIN {$pivot_table} p ON r.{$this->{$related_model}->primary_key} = p.{$related_key}
                 WHERE p.{$current_key} = ?";
        
        return $this->db->raw($query, [$current_id])
               ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Belong To Relationship
     *
     * @param string $related_model
     * @param string $foreign_key
     * @param mixed $foreign_key_value
     * @return void
     */
    public function belongs_to($related_model, $foreign_key, $foreign_key_value) {
        if (!$foreign_key_value) {
            return null;
        }
        
        $this->call->model($related_model);
        return $this->{$related_model}->find($foreign_key_value);
    }
    
    /**
     * Scope query
     *
     * @param callable $callback
     * @return $this
     */
    public function scope($callback)
    {
        call_user_func($callback, $this->db);
        return $this;
    }

    /**
     * Begin Transaction
     *
     * @return void
     */
    public function transaction()
    {
        $this->db->transaction();
    }

    /**
     * Commit
     *
     * @return void
     */
    public function commit()
    {
        $this->db->commit();
    }

    /**
     * Rollback
     *
     * @return void
     */
    public function rollback()
    {
        $this->db->rollback();
    }

     /**
     * magic __get
     *
     * @param string $key
     * @return void
     */
    public function __get($key)
    {
        return lava_instance()->$key;
    }
}