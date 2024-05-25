<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeesModel extends Model {

    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'city_id', 'state_id', 'country_id', 'gender', 'education', 'hobbies', 'created_at'];

    public function get_all_employees() {
        return $this->db->table('employees')
            ->select('employees.*, countries.name as country_name, states.name as state_name, cities.name as city_name')
            ->join('countries', 'countries.id = employees.country_id')
            ->join('states', 'states.id = employees.state_id')
            ->join('cities', 'cities.id = employees.city_id')
            ->get()
            ->getResultArray();
    }

    public function add_employee($data) {
        return $this->db->table('employees')->insert($data);
    }

    public function update_employee($id, $data) {
        return $this->db->table('employees')->update($data, ['id' => $id]);
    }

    public function delete_employee($id) {
        return $this->db->table('employees')->delete(['id' => $id]);
    }

    public function get_employee($id) {
        return $this->db->table('employees')->where('id', $id)->get()->getRowArray();
    }

    public function get_countries() {
        return $this->db->table('countries')->get()->getResultArray();
    }

    public function get_states($country_id) {
        return $this->db->table('states')->where('country_id', $country_id)->get()->getResultArray();
    }

    public function get_cities($state_id) {
        return $this->db->table('cities')->where('state_id', $state_id)->get()->getResultArray();
    }
}
