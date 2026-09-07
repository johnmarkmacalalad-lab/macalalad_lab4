<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserController
 * 
 * Automatically generated via CLI.
 */
class UserController extends Controller {
   
    public function show_users() {
       $lab_users = $this->db->table('lab_users')->get_all();
       $this->call->view('users', ['lab_users' => $lab_users]);
    }
}