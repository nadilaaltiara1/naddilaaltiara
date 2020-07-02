<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_biodata_nadilaaltiara extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tb_biodata_nadilaaltiara_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tb_biodata_nadilaaltiara/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tb_biodata_nadilaaltiara/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tb_biodata_nadilaaltiara/index.html';
            $config['first_url'] = base_url() . 'tb_biodata_nadilaaltiara/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tb_biodata_nadilaaltiara_model->total_rows($q);
        $tb_biodata_nadilaaltiara = $this->Tb_biodata_nadilaaltiara_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tb_biodata_nadilaaltiara_data' => $tb_biodata_nadilaaltiara,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('tb_biodata_nadilaaltiara/tb_biodata_nadilaaltiara_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tb_biodata_nadilaaltiara_model->get_by_id($id);
        if ($row) {
            $data = array(
		'nama' => $row->nama,
		'npm' => $row->npm,
		'kelas' => $row->kelas,
		'jurusan' => $row->jurusan,
	    );
            $this->load->view('tb_biodata_nadilaaltiara/tb_biodata_nadilaaltiara_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tb_biodata_nadilaaltiara/create_action'),
	    'nama' => set_value('nama'),
	    'npm' => set_value('npm'),
	    'kelas' => set_value('kelas'),
	    'jurusan' => set_value('jurusan'),
	);
        $this->load->view('tb_biodata_nadilaaltiara/tb_biodata_nadilaaltiara_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'jurusan' => $this->input->post('jurusan',TRUE),
	    );

            $this->Tb_biodata_nadilaaltiara_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tb_biodata_nadilaaltiara_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tb_biodata_nadilaaltiara/update_action'),
		'nama' => set_value('nama', $row->nama),
		'npm' => set_value('npm', $row->npm),
		'kelas' => set_value('kelas', $row->kelas),
		'jurusan' => set_value('jurusan', $row->jurusan),
	    );
            $this->load->view('tb_biodata_nadilaaltiara/tb_biodata_nadilaaltiara_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('npm', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'kelas' => $this->input->post('kelas',TRUE),
		'jurusan' => $this->input->post('jurusan',TRUE),
	    );

            $this->Tb_biodata_nadilaaltiara_model->update($this->input->post('npm', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tb_biodata_nadilaaltiara_model->get_by_id($id);

        if ($row) {
            $this->Tb_biodata_nadilaaltiara_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_biodata_nadilaaltiara'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('kelas', 'kelas', 'trim|required');
	$this->form_validation->set_rules('jurusan', 'jurusan', 'trim|required');

	$this->form_validation->set_rules('npm', 'npm', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Tb_biodata_nadilaaltiara.php */
/* Location: ./application/controllers/Tb_biodata_nadilaaltiara.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-22 09:43:57 */
/* http://harviacode.com */