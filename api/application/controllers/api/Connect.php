<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Connect extends CI_Controller {
	use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    private function updateSaldoUser($user_id, $count)
    {
        $this->db->where('id', $user_id);
        $this->db->set('saldo', $count);
        return $this->db->update('user');
    }

    // function __construct(){
    //     parent::__construct();
    //     // $this->load->library('Digiflazz');
    //     $this->load->model('Tbl_trx_produk');
    // }

	public function index_post() {
        $inquiry = $this->post('inquiry');

        if ($inquiry == 'saldo') {
            $this->_saldo();
            
        }elseif ($inquiry == 'produk') {
            $this->_produk();
            
        }elseif ($inquiry == 'beli') {
            $this->_beli();
            
        }elseif ($inquiry == 'cektrx') {
            $this->_cektrx();
            
        }else{
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'No inquiry were found'
            ], 404); // NOT_FOUND (404) being the HTTP response code
        }


	}

    private function _saldo() {
        $token = $this->post('token');
        //data token
        $data_keys = $this->db->get_where('keys', ['key' => $token])->row();

        //saldo user
        $saldo  = $this->db->get_where('user', ['id' => $data_keys->user_id])->row()->saldo;

         $this->response([
            'status' => true,
            'saldo' => $saldo,
        ], 200);
    }

    private function _produk() {

        $datas = $this->db->select('produk.*')
                          ->from('produk')
                          ->join('group_produk', 'produk.group_produk_id = group_produk.id')
                          ->where('group_produk.main_group_produk_id', 1) //prabayar
                          ->get()->result_array();

            foreach ($datas as $key => $value) {
                unset($datas[$key]['group_produk_id']);
                unset($datas[$key]['server_id']);
                unset($datas[$key]['trx_code']);
            }

             if ($datas)
            {
                // Set the response and exit
                $this->response(['status' => true, 'data' => $datas], 200); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => false,
                    'message' => 'No data were found'
                ], 404); // NOT_FOUND (404) being the HTTP response code
            }
    }

    private function _beli() {
        $token = $this->post('token');
        $customer_no = $this->post('customer_no');
        $produk_id = $this->post('produk_id');
        if (empty($customer_no) || empty($produk_id)) {
            $this->response([
                'status' => false,
                'message' => 'params not true'
            ], 400); 
        }else{
            //data token
            $data_keys = $this->db->get_where('keys', ['key' => $token])->row();

            //saldo user
            $saldo  = $this->db->get_where('user', ['id' => $data_keys->user_id])->row()->saldo;
            
            //data produk
            $data_produk = $this->db->get_where('produk', ['id' => $produk_id])->row();

            if (empty($data_produk)) {
                $this->response([
                    'status' => false,
                    'message' => 'Not found produk'
                ], 400);
            }
            
            //harga produk
            $price = $data_produk->price;

            //jika price > saldo  => saldo tidak cukup
            if ($price > $saldo) {
                $this->response([
                    'status' => false,
                    'message' => 'saldo tidak cukup'
                ], 200);
            }else{
                //save to trx produk                               
                $data = [
                    'produk_id'     => $data_produk->id,
                    'user_id'       => $data_keys->user_id,
                    'customer_no'   => $customer_no,
                    'trx_code'      => $data_produk->trx_code,
                    'created_on'    => time(),
                    'status'        => 0
                ];

                $saveTrx = $this->db->insert('trx_produk', $data);

                $trxid =  $this->db->insert_id(); //ambil id trx barusan

                //cek nomor tersebut sudah trx hari ini
                $count = $this->Tbl_trx_produk->checkCustomerNo($customer_no, $data_keys->user_id);
                if ($count > 1){
                    $customer_no = ($count.'.'.$customer_no);
                }
                //lalu jaidkan id tersebut trx id to server
                $trxid = date('Ymdhis', time() ).'-'.$trxid;
                $rq = $this->digiflazz->getTopUp($trxid, $customer_no, $data_produk->trx_code);

                $jsonRQ = json_decode($rq, true);
                $status = $jsonRQ['data']['status'];

                //status gagal
                if ($status == "Gagal") {
                    $idtrx = explode('-', $trxid)[1];
                    $this->db->where('id', $idtrx);
                    if ( $this->db->delete('trx_produk') ) {
                        $this->response([
                            'status' => false,
                            'message' => $jsonRQ['data']['status']
                        ], 200);
                    }
                    
                }else{
                    //potong saldo
                    $count =  ($saldo - $price);
                    $this->updateSaldoUser($data_keys->user_id, $count);

                    //update status after purchase to server
                    $trxidX = explode('-', $trxid);
                    $trxidY = $trxidX[1];
                    $dataU = [
                        'sn'        => $jsonRQ['data']['sn'],
                        'status'    => $jsonRQ['data']['status'],
                        'ref'       => $trxid
                    ];
                    $this->db->where('trx_produk.id', $trxidY);
                    $this->db->update('trx_produk', $dataU);

                    $this->response([
                        'status' => true,
                        'message' => $jsonRQ['data']['status'],
                        'trx_id' => $trxidY
                    ], 200);                

                }
                
            }
            
            
             
        }
    }

    private function _cektrx() {
        $token = $this->post('token');
        $trx_id = $this->post('trx_id');
        //data token
        $data_keys = $this->db->get_where('keys', ['key' => $token])->row();

        $access = $this->db->get_where('trx_produk', ['id' => $trx_id , 'user_id' => $data_keys->user_id]);

        if ($access->num_rows() > 0) {
             $this->response([
                'status'    => true,
                'message'   => $access->row()->status,
                'sn'        => $access->row()->sn
            ], 200);
        }else{
            $this->response([
                'status' => false,
                'message' => "not found trx",
            ], 404);
        }
        

    }




}

/* End of file Connect.php */
/* Location: ./application/controllers/api/Connect.php */