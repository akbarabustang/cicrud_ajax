<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model {

	public function daftar()
	{
		$this->db->order_by('created_at', 'desc');
		$query = $this->db->get('tbl_pegawai');
		if ($query->num_rows() > 0) {
			return $query->result();
				
		}else{
			return false;
		}
	}

	public function tambah()
	{
		$field = array(
					'nama_pegawai' => $this->input->post('nama_pegawai'),
					'alamat' => $this->input->post('alamat'),
					'created_at' => date('Y-m-d H:i:s')
					);
		$this->db->insert('tbl_pegawai', $field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function edit()
	{
		$id = $this->input->get('id');
		$this->db->where('id_pegawai',$id);
		$query = $this->db->get('tbl_pegawai');
		if ($query->num_rows() > 0) {
			return $query->row();
		}else{
			return false;
		}
	}

	public function update()
	{
		$id = $this->input->post('id_pegawai');
		$field = array(
					'nama_pegawai' => $this->input->post('nama_pegawai'),
					'alamat' => $this->input->post('alamat'),
					'updated_at' => date('Y-m-d H:i:s')
					);
		$this->db->where('id_pegawai', $id);
		$this->db->update('tbl_pegawai', $field);
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	 function hapus()
	{
		$id = $this->input->get('id');
		$this->db->where('id_pegawai',$id);
		$this->db->delete('tbl_pegawai');
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}


}
