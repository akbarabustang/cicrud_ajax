<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Pegawai_model', 'pm');
 	}

	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('pegawai/index');
		$this->load->view('layout/footer');
	}

	public function tampilkanPegawai()
	{
		$result = $this->pm->daftar();
		echo json_encode($result);
	}

	public function tambahkanPegawai()
	{
		$result = $this->pm->tambah();
		$pesan['success'] = false;
		$pesan['type'] = 'add';
		if ($result) {
			$pesan['success'] = true;
		}
		echo json_encode($pesan);
	}

	public function editPegawai()
	{
		$result = $this->pm->edit();
		echo json_encode($result);
	}

	public function updatePegawai()
	{
		$result = $this->pm->update();
		$pesan['success'] = false;
		$pesan['type'] = 'update';
		if ($result) {
			$pesan['success'] = true;
		}
		echo json_encode($pesan); 
	}

	public function hapusPegawai()
	{
		$result = $this->pm->hapus();
		$pesan['success'] = false;
		if ($result) {
			$pesan['success'] = true;
		}
		echo json_encode($pesan);
	}
}
