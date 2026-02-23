<?php

class ContactsController extends Controller {
    private $ContactsModel;

    public function __construct() {
        $this->ContactsModel = $this->model('ContactsModel');
    }

    public function index() {
        $contacts = $this->ContactsModel->all();
        $this->view('admin/contacts/index', ['contacts' => $contacts]); 
    }

    public function them() {
      
        $this->view('admin/contacts/them', []); 
    }

    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $this->ContactsModel->create(['full_name' => $full_name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message]);
        
            $this->redirect('http://localhost:8000/contacts/index'); 
        }
    }

    public function edit($id) {
        $contacts = $this->ContactsModel->find($id);

        $this->view('admin/contacts/edit', ['contacts' => $contacts]); 
    }

    public function update($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $subject = $_POST['subject'];
            $message = $_POST['fullname'];

            $this->ContactsModel->update(['full_name' => $full_name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message], $id);
            $this->redirect('http://localhost:8000/contacts/index');
        }
    }

    public function delete($id) {
        $this->ContactsModel->delete($id);

        $this->redirect('http://localhost:8000/contacts/index');
    }
}