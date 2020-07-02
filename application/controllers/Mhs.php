<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mhs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_mhs');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'mhs/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'mhs/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'mhs/index.html';
            $config['first_url'] = base_url() . 'mhs/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->M_mhs->total_rows($q);
        $mhs = $this->M_mhs->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mhs_data' => $mhs,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
         $this->load->view('Tugas/artikel');
        $this->load->view('mhs/tb_mahasiswa_list', $data);
    }

    public function read($id) 
    {
        $row = $this->M_mhs->get_by_id($id);
        if ($row) {
            $data = array(
		'No' => $row->No,
		'Npm' => $row->Npm,
		'Nama' => $row->Nama,
		'Jk' => $row->Jk,
		'prodi' => $row->prodi,
	    );

            $this->load->view('mhs/tb_mahasiswa_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mhs'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('mhs/create_action'),
	    'No' => set_value('No'),
	    'Npm' => set_value('Npm'),
	    'Nama' => set_value('Nama'),
	    'Jk' => set_value('Jk'),
	    'prodi' => set_value('prodi'),
	);
         $this->load->view('Tugas/artikel');
        $this->load->view('mhs/tb_mahasiswa_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'Npm' => $this->input->post('Npm',TRUE),
		'Nama' => $this->input->post('Nama',TRUE),
		'Jk' => $this->input->post('Jk',TRUE),
		'prodi' => $this->input->post('prodi',TRUE),
	    );

            $this->M_mhs->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('mhs'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->M_mhs->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('mhs/update_action'),
		'No' => set_value('No', $row->No),
		'Npm' => set_value('Npm', $row->Npm),
		'Nama' => set_value('Nama', $row->Nama),
		'Jk' => set_value('Jk', $row->Jk),
		'prodi' => set_value('prodi', $row->prodi),
	    );
             $this->load->view('Tugas/artikel');
            $this->load->view('mhs/tb_mahasiswa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mhs'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('No', TRUE));
        } else {
            $data = array(
		'Npm' => $this->input->post('Npm',TRUE),
		'Nama' => $this->input->post('Nama',TRUE),
		'Jk' => $this->input->post('Jk',TRUE),
		'prodi' => $this->input->post('prodi',TRUE),
	    );

            $this->M_mhs->update($this->input->post('No', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mhs'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->M_mhs->get_by_id($id);

        if ($row) {
            $this->M_mhs->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mhs'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mhs'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('Npm', 'npm', 'trim|required');
	$this->form_validation->set_rules('Nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('Jk', 'jk', 'trim|required');
	$this->form_validation->set_rules('prodi', 'prodi', 'trim|required');

	$this->form_validation->set_rules('No', 'No', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Mhs.php */
/* Location: ./application/controllers/Mhs.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-22 10:32:04 */
/* http://harviacode.com */