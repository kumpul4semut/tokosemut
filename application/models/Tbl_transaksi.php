<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Transaksi model
 */
class Tbl_transaksi extends MY_Model
{
	/**
	*-----------------
	* Method get all
	*-----------------
	*$query = "SELECT `*`,`name`
				  FROM `transaksi` JOIN `type_transaksi`
				  ON `transaksi`.`type_id` = `type_transaksi`.`id`
				  ORDER BY `transaksi`.`id` desc
				";
	*/
	public function getByUser($id_user, $limit, $offset)
	{
		$this->db->select('	transaksi.id,
							transaksi.status,
							invoice.created_on,
							invoice.nominal,
							invoice.expired_on,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							deposit_method.method_name
							');
		$this->db->from('transaksi');
		$this->db->join('invoice', 'transaksi.invoice_id = invoice.id');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
		$this->db->where('invoice.user_id', $id_user);
        $this->db->order_by('transaksi.id','desc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method get log
	*-----------------
	*/
	public function getLog($id_user)
	{
		$this->db->select('	transaksi.id,
							transaksi.status,
							invoice.created_on,
							invoice.nominal,
							invoice.expired_on,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							deposit_method.method_name
							');
		$this->db->from('transaksi');
		$this->db->join('invoice', 'transaksi.invoice_id = invoice.id');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
		$this->db->where('invoice.user_id', $id_user);
		$this->db->where('invoice_type.id', 1); //show only deposit
        $this->db->order_by('transaksi.id','desc');
        $this->db->limit(5);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method insert
	*-----------------
	*/
	public function insert($data)
	{
	
	    return $this->db->insert('transaksi', $data);
	}

	/**
	*-----------------
	* Method detail for detail only
	*-----------------
	*/
	public function getById_User($id_transaksi, $id_user)
	{
	
	    $this->db->select(' invoice.id,
	    					invoice.status_server AS status,
							invoice.created_on,
							invoice.nominal,
							invoice_type.name AS type_transaksi,
							invoice.expired_on,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							deposit_method.method_name
							');
		$this->db->from('invoice');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
        $this->db->order_by('invoice.id','desc');
        $this->db->where('invoice.id', $id_transaksi);
        $this->db->where('invoice.user_id', $id_user);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method detail for detail only
	*-----------------
	*/
	public function getById($id_transaksi)
	{
	
	    $this->db->select(' transaksi.id,
	    					transaksi.invoice_id,
	    					user.id AS user_id,
	    					user.name,
	    					user.email,
	    					user.saldo,
	    					transaksi.status,
							invoice.created_on,
							invoice.nominal,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							');
		$this->db->from('transaksi');
		$this->db->join('invoice', 'transaksi.invoice_id = invoice.id');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('user', 'invoice.user_id = user.id');
        $this->db->order_by('transaksi.id','desc');
        $this->db->where('transaksi.id', $id_transaksi);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method getById_Just_Pending
	*-----------------
	*/
	public function getById_Just_Pending($id_transaksi, $id_user)
	{
	
	    $this->db->select(' transaksi.status,
							invoice.created_on,
							invoice.nominal,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							');
		$this->db->from('transaksi');
		$this->db->join('invoice', 'transaksi.invoice_id = invoice.id');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
        $this->db->order_by('transaksi.id','desc');
        $this->db->where('transaksi.id', $id_transaksi);
        $this->db->where('transaksi.status', 1);
        $this->db->where('invoice.user_id', $id_user);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method update to check on user / sudah bayar
	*-----------------
	*/
	public function updateSudahBayarUser($id_transaksi)
	{
	
	   
        $this->db->where('transaksi.id', $id_transaksi);
        $this->db->where('transaksi.status', 1);
        $this->db->set('transaksi.status', 2);
        return $this->db->update('transaksi');
	}

	/**
	*-----------------
	* Method check user have pending
	*-----------------
	*/
	public function checkHavePending($user_id)
	{
	
	   	$this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('invoice', 'transaksi.invoice_id = invoice.id');
        $this->db->where('invoice.user_id', $user_id)->where('transaksi.status', 1 OR 'transaksi.status', 2);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method update to Accept admin deposit
	*-----------------
	*/
	public function updateAccept($id_transaksi, $id_invoice)
	{
		//update transaaksi to success	   
        $this->db->set('a.status', 3);
        $this->db->where('a.status', 1);
        $this->db->or_where('a.status', 2);
        $this->db->where('a.id', $id_transaksi);
        $this->db->update('transaksi AS a');

        //update invoice empaty expired_on
        $this->db->where('b.id', $id_invoice);
        $this->db->set('b.expired_on', '');
        $this->db->update('invoice AS b');
        return true;
	}

	/**
	*-----------------
	* Method update to deny admin deposit
	*-----------------
	*/
	public function updateDeny($id_transaksi, $id_invoice)
	{
		//update transaaksi to success	   
        $this->db->set('a.status', 0);
        $this->db->where('a.status', 1);
        $this->db->or_where('a.status', 2);
        $this->db->where('a.id', $id_transaksi);
        $this->db->update('transaksi AS a');

        //update invoice empaty expired_on
        $this->db->where('b.id', $id_invoice);
        $this->db->set('b.expired_on', '');
        $this->db->update('invoice AS b');
        return true;
	}
}