<?php

class Dashboard extends CI_Controller {
   public function index(){
   	   $this->load->view('Adminlte/header');
   	   $this->load->view('Adminlte/navbar');
   	   $this->load->view('Adminlte/sidebar');
   	   $this->load->view('Adminlte/content');
   	   $this->load->view('Adminlte/footer');
   }
 }  	     