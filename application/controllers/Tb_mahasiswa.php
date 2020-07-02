<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tb_mahasiswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tb_mahasiswa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'tb_mahasiswa/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'tb_mahasiswa/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'tb_mahasiswa/index.html';
            $config['first_url'] = base_url() . 'tb_mahasiswa/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Tb_mahasiswa_model->total_rows($q);
        $tb_mahasiswa = $this->Tb_mahasiswa_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tb_mahasiswa_data' => $tb_mahasiswa,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('tb_mahasiswa/tb_mahasiswa_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Tb_mahasiswa_model->get_by_id($id);
        if ($row) {
            $data = array(
		'No' => $row->No,
		'Npm' => $row->Npm,
		'Nama' => $row->Nama,
		'Jk' => $row->Jk,
		'prodi' => $row->prodi,
	    );
            $this->load->view('tb_mahasiswa/tb_mahasiswa_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_mahasiswa'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tb_mahasiswa/create_action'),
	    'No' => set_value('No'),
	    'Npm' => set_value('Npm'),
	    'Nama' => set_value('Nama'),
	    'Jk' => set_value('Jk'),
	    'prodi' => set_value('prodi'),
	);
        $this->load->view('tb_mahasiswa/tb_mahasiswa_form', $data);
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

            $this->Tb_mahasiswa_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tb_mahasiswa'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tb_mahasiswa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tb_mahasiswa/update_action'),
		'No' => set_value('No', $row->No),
		'Npm' => set_value('Npm', $row->Npm),
		'Nama' => set_value('Nama', $row->Nama),
		'Jk' => set_value('Jk', $row->Jk),
		'prodi' => set_value('prodi', $row->prodi),
	    );
            $this->load->view('tb_mahasiswa/tb_mahasiswa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_mahasiswa'));
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

            $this->Tb_mahasiswa_model->update($this->input->post('No', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tb_mahasiswa'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tb_mahasiswa_model->get_by_id($id);

        if ($row) {
            $this->Tb_mahasiswa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tb_mahasiswa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tb_mahasiswa'));
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

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tb_mahasiswa.xls";
        $judul = "tb_mahasiswa";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Npm");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Jk");
	xlsWriteLabel($tablehead, $kolomhead++, "Prodi");

	foreach ($this->Tb_mahasiswa_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Npm);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Jk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->prodi);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tb_mahasiswa.doc");

        $data = array(
            'tb_mahasiswa_data' => $this->Tb_mahasiswa_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tb_mahasiswa/tb_mahasiswa_doc',$data);
    }

}

/* End of file Tb_mahasiswa.php */
/* Location: ./application/controllers/Tb_mahasiswa.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-06-22 10:33:19 */
/* http://harviacode.com */