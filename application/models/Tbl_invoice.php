<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tbl_invoice model
 */
class Tbl_invoice extends CI_Model
{
	/**
	*-----------------
	* Method insert new invoice
	*-----------------
	* @param From method user/deposit/goDeposit
	*/
	public function insertInvoiceUser($data)
	{
		return $this->db->insert('invoice', $data);
	}

	/**
	*-----------------
	* Method get not read admin
	*-----------------
	* inisial on core_controller
	*/
	public function getNotRead()
	{
		$this->db->where('status_read', 0);
		return $this->db->get('invoice');
	}

	/**
	*-----------------
	* Method get all invoice
	*-----------------
	* admin/invoice/index
	*/
	public function getAll($limit, $offset)
	{
		$this->db->select('invoice_type.name AS invoice_type,
						   user.name AS user_name,
						   deposit.name AS deposit_name,
						   deposit.nomor,
						   invoice.nominal,
						   invoice.status_server AS status_user,
						   invoice.id,
						   invoice.from_sended
						   ');
		$this->db->from('invoice');
		$this->db->join('user', 'invoice.user_id = user.id');	
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->order_by('invoice.id','desc');	
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}

	/**
	*-----------------
	* Method doneRead
	*-----------------
	* use on admin/invoice/detail
	*/
	public function doneRead($id_update_invoice)
	{
		$this->db->set('status_read', 1);
		$this->db->where('id', $id_update_invoice);
		$this->db->where('status_read', 0);
		return $this->db->update('invoice');
	}

	/**
	 * Method join portal_pulsa
	 */
	public function joinPortalPulsa($invoice_id) {
		$this->db->select('invoice.user_id, portal_pulsa.price');
		$this->db->from('invoice');
		$this->db->join('portal_pulsa', 'invoice.portal_pulsa_id = portal_pulsa.id');
		return $this->db->get();
	}

	/**
	 * Method get invoice pulsa
	 */
	public function getInvoicePulsa($id) {
		$this->db->select('portal_pulsa.*, invoice.nomor, invoice.created_on, invoice.id AS trxid');
		$this->db->from('invoice');
		$this->db->join('portal_pulsa', 'invoice.portal_pulsa_id = portal_pulsa.id');
		$this->db->where('user_id', $id);
		$this->db->where('invoice_type_id', 2);
		$this->db->order_by('invoice.id', 'DESC');
		$this->db->limit(5);
		return $this->db->get();
	}

	/**
	*-----------------
	* Method get log
	*-----------------
	*/
	public function getLog($id_user)
	{
		$this->db->select(' invoice.id,
							invoice.status_server AS status,
						   	invoice.created_on,
							invoice.nominal,
							invoice.expired_on,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							deposit_method.method_name
						');

		$this->db->from('invoice');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
		$this->db->where('invoice.user_id', $id_user);
		$this->db->where('invoice_type.id', 1); //show only deposit
        $this->db->order_by('invoice.id','desc');
        return $this->db->get();
	}

	/**
	*-----------------
	* Method detail for detail only
	*-----------------
	*/
	public function getById_User($id_invoice, $id_user)
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
        $this->db->where('invoice.id', $id_invoice);
        $this->db->where('invoice.user_id', $id_user);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method getById_Just_Pending
	*-----------------
	*/
	public function getById_Just_Pending($id_invoice, $id_user)
	{
	
	    $this->db->select('	invoice.id,
	    					invoice.status_server AS status,
							invoice.created_on,
							invoice.nominal,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							');
		$this->db->from('invoice');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
        $this->db->order_by('invoice.id','desc');
        $this->db->where('invoice.id', $id_invoice);
        $this->db->where('invoice.status_server', 1);
        $this->db->where('invoice.user_id', $id_user);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method update to check on user / sudah bayar
	*-----------------
	*/
	public function updateSudahBayarUser($id_invoice)
	{
	
	   
        $this->db->where('invoice.id', $id_invoice);
        $this->db->where('invoice.status_server', 1);
        $this->db->set('invoice.status_server', 2);
        return $this->db->update('invoice');
	}

	/**
	*-----------------
	* Method detail for detail only
	*-----------------
	*/
	public function getById($id_invoice)
	{
	
	    $this->db->select(' invoice.id,
	    					invoice.id AS invoice_id,
	    					user.id AS user_id,
	    					user.name,
	    					user.email,
	    					user.saldo,
	    					invoice.status_server AS status,
							invoice.created_on,
							invoice.nominal,
							invoice_type.name AS type_transaksi,
							deposit.name AS name_transfer_to,
							deposit.nomor AS rek_transfer_to,
							deposit.pemilik AS atas_nama,
							deposit_method.method_name
							');
		$this->db->from('invoice');
		$this->db->join('invoice_type', 'invoice.invoice_type_id = invoice_type.id');
		$this->db->join('deposit', 'invoice.deposit_id = deposit.id');
		$this->db->join('user', 'invoice.user_id = user.id');
		$this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
        $this->db->order_by('invoice.id','desc');
        $this->db->where('invoice.id', $id_invoice);
        return $this->db->get();
	}

	/**
	*-----------------
	* Method update to Accept admin deposit
	*-----------------
	*/
	public function updateAccept($id_invoice)
	{
		//get this invoice
		$invoice = $this->db->get_where('invoice', ['id' => $id_invoice])->row();
		if ($invoice->status_server == 1) {
			//update time to 0
			$this->db->set('expired_on', '');
			//update status_server to 3
			$this->db->set('status_server', 3);
			//update status_read to 1
			$this->db->set('status_read', 1);
			// where id param
			$this->db->where('id', $id_invoice);

			return $this->db->update('invoice');
		}elseif($invoice->status_server == 2){
			//update time to 0
			$this->db->set('expired_on', '');
			//update status_server to 3
			$this->db->set('status_server', 3);
			//update status_read to 1
			$this->db->set('status_read', 1);
			// where id param
			$this->db->where('id', $id_invoice);

			return $this->db->update('invoice');
		}else{
			return false;
		}
	}

	/**
	*-----------------
	* Method update to deny admin deposit
	*-----------------
	*/
	public function updateDeny($id_invoice)
	{
		//update time to 0
		$this->db->set('expired_on', '');
		// update status_server to 0
		$this->db->set('status_server', 0);
		// update status_read to 1
		$this->db->set('status_read', 1);
		// where invoice.id is $id_invoice
		$this->db->where('id', $id_invoice);

		return $this->db->update('invoice');		
	}

	/**
	*-----------------
	* Method check user have pending
	*-----------------
	*/
	public function checkHavePending($user_id)
	{	
        $this->db->where('invoice.user_id', $user_id);
        $this->db->where('status_server', 1);
        return $this->db->get('invoice');
	}

	/**
	*-----------------
	* Method check user have check
	*-----------------
	*/
	public function checkHaveCheck($user_id)
	{	
        $this->db->where('invoice.user_id', $user_id);
        $this->db->where('status_server', 2);
        return $this->db->get('invoice');
	}

	/**
	*-----------------
	* Method get yesterday and today
	*-----------------
	*/
	public function getYestToday($nominal, $fromSend)
	{	
        
        $yesterday 	= date('y-m-d', strtotime("-1 days"));
        $today 		= date('y-m-d', time());

        $idArray = [];
        foreach ($this->db->get('invoice')->result() as $data) {
        	$dataCreate = date('y-m-d', $data->created_on);
        	if ($dataCreate == $yesterday || $dataCreate == $today ) {
        		array_push($idArray, $data);
        	}
        }

        //apa ini request depo pulsa
        if (empty($fromSend)) {
	        $count = 0;
	        foreach ($idArray as $datArray) {
	        	if ($datArray->nominal == $nominal) {
	        		$count += 1;
	        	}
	        }
	        return $count;
        }else{
        	$count = 0;
	        foreach ($idArray as $datArray) {
	        	if ($datArray->nominal == $nominal && $datArray->from_sended == $fromSend) {
	        		$count += 1;
	        	}
	        }
	        return $count;
        }

	}

}