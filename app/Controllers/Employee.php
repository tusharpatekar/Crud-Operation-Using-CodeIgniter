<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EmployeesModel;
use Config\Services\Request;

class Employee extends Controller {

    private $employeesModel;
    protected $request;

    public function __construct() {
        // Load the model
        $this->employeesModel = new EmployeesModel();
        $this->load = service('load'); // Load the helper
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
    }

    public function index() {
        $data['employees'] = $this->employeesModel->get_all_employees();
        $data['countries'] = $this->employeesModel->get_countries();
        return view('employee_list', $data);
    }

    public function create() {
        $data['countries'] = $this->employeesModel->get_countries();
        return view('employee_create', $data);
    }

    public function store() {
        // Define validation rules
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            // Add more rules as required
        ];

        // Run validation
        if ($this->validation->setRules($rules)->withRequest($this->request)->run() === false) {
            // Validation failed, return to the create form with validation errors
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        } else {
            // Validation passed, proceed with storing the data
            $data = [
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'phone' => $this->request->getVar('phone'),
                'city_id' => $this->request->getVar('city'),
                'state_id' => $this->request->getVar('state'),
                'country_id' => $this->request->getVar('country'),
                'gender' => $this->request->getVar('gender'),
                'education' => $this->request->getVar('education'),
                'hobbies' => $this->request->getVar('hobbies')
            ];
            $this->employeesModel->add_employee($data);
            return redirect()->to('/');
        }
    }


    public function update($id) {
        // Define validation rules
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required',
            // Add more rules as required
        ];

        // Run validation
        if ($this->validation->setRules($rules)->withRequest($this->request)->run() === false) {
            // Validation failed, return to the edit form with validation errors
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        } else {
            // Validation passed, proceed with updating the data
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'city_id' => $this->request->getPost('city'),
                'state_id' => $this->request->getPost('state'),
                'country_id' => $this->request->getPost('country'),
                'gender' => $this->request->getPost('gender'),
                'education' => $this->request->getPost('education'),
                'hobbies' => $this->request->getPost('hobbies')
            ];
            $this->employeesModel->update_employee($id, $data);
            return redirect()->to('/');
        }
    }



    public function edit($id)
    {
        $employee = $this->employeesModel->get_employee($id);
        if ($employee) {
            return $this->response->setJSON($employee);
        } else {
            return $this->response->setJSON(['error' => 'Employee not found'], 404);
        }
    }
    


    public function delete($id) {
        $this->employeesModel->delete_employee($id);
        return json_encode(['status' => 'success']);
    }

    public function get_states() {
        $country_id = $this->request->getPost('country_id');
        $states = $this->employeesModel->get_states($country_id);
        return json_encode($states);
    }

    public function get_cities() {
        $state_id = $this->request->getPost('state_id');
        $cities = $this->employeesModel->get_cities($state_id);
        return json_encode($cities);
    }
}
