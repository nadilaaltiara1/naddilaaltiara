<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pekerjaan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_pekerjaan');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pekerjaan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pekerjaan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pekerjaan/index.html';
            $config['first_url'] = base_url() . 'pekerjaan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->M_pekerjaan->total_rows($q);
        $pekerjaan = $this->M_pekerjaan->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pekerjaan_data' => $pekerjaan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('Adminlte/header');
        $this->load->view('Adminlte/navbar');
        $this->load->view('Adminlte/sidebar');
        $this->load->view('pekerjaan/tb_pekerjaan_list', $data);
        $this->load->view('Adminlte/footer');
    }

    public function read($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pekerjaan' => $row->id_pekerjaan,
		'pekerjaan' => $row->pekerjaan,
	    );
            $this->load->view('Adminlte/header');
            $this->load->view('Adminlte/navbar');
            $this->load->view('Adminlte/sidebar'); 
            $this->load->view('pekerjaan/tb_pekerjaan_read', $data);
            $this->load->view('Adminlte/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pekerjaan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pekerjaan/create_action'),
	    'id_pekerjaan' => set_value('id_pekerjaan'),
	    'pekerjaan' => set_value('pekerjaan'),
	);
         $this->load->view('Adminlte/header');
         $this->load->view('Adminlte/navbar');
         $this->load->view('Adminlte/sidebar');
         $this->load->view('pekerjaan/tb_pekerjaan_form', $data);
         $this->load->view('Adminlte/footer');
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'pekerjaan' => $this->input->post('pekerjaan',TRUE),
	    );

            $this->M_pekerjaan->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pekerjaan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pekerjaan/update_action'),
		'id_pekerjaan' => set_value('id_pekerjaan', $row->id_pekerjaan),
		'pekerjaan' => set_value('pekerjaan', $row->pekerjaan),
	    );
            $this->load->view('Adminlte/header');
            $this->load->view('Adminlte/navbar');
            $this->load->view('Adminlte/sidebar'); 
            $this->load->view('pekerjaan/tb_pekerjaan_form', $data);
            $this->load->view('Adminlte/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pekerjaan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pekerjaan', TRUE));
        } else {
            $data = array(
		'pekerjaan' => $this->input->post('pekerjaan',TRUE),
	    );

            $this->M_pekerjaan->update($this->input->post('id_pekerjaan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pekerjaan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->M_pekerjaan->get_by_id($id);

        if ($row) {
            $this->M_pekerjaan->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pekerjaan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pekerjaan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'trim|required');

	$this->form_validation->set_rules('id_pekerjaan', 'id_pekerjaan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tb_pekerjaan.xls";
        $judul = "tb_pekerjaan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Pekerjaan");

	foreach ($this->M_pekerjaan->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->pekerjaan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tb_pekerjaan.doc");

        $data = array(
            'tb_pekerjaan_data' => $this->M_pekerjaan->get_all(),
            'start' => 0
        );
            $this->load->view('Adminlte/header');
            $this->load->view('Adminlte/navbar');
            $this->load->view('Adminlte/sidebar'); 
            $this->load->view('pekerjaan/tb_pekerjaan_doc',$data);
            $this->load->view('Adminlte/footer');
    }

}

/* End of file Pekerjaan.php */
/* Location: ./application/controllers/Pekerjaan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-01 15:11:31 */
/* http://harviacode.com */