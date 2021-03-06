<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CCuentas extends CI_Controller {

	public function __construct() {
        parent::__construct();


       
		// Load database
        $this->load->model('MCuentas');
        $this->load->model('MCoins');
        $this->load->model('MTiposCuenta');
        $this->load->model('MBitacora');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MCuentas->obtener();
		$this->load->view('cuentas/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['account_type'] = $this->MTiposCuenta->obtener();
		$data['monedas'] = $this->MCoins->obtener();
		$this->load->view('cuentas/registrar', $data);
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
		
		$datos = array(
			'owner' => $this->input->post('owner'),
			'alias' => $this->input->post('alias'),
			'number' => $this->input->post('number'),
            'user_id' => $this->session->userdata('logged_in')['id'],
            'type' => $this->input->post('type'),
            'description' => $this->input->post('description'),
            'amount' => $this->input->post('amount'),
            'coin_id' => $this->input->post('coin_id'),
            'status' => $this->input->post('status'),
            'd_create' => date('Y-m-d H:i:s')
        );
        
        $result = $this->MCuentas->insert($datos);
        
        if ($result) {
			
			// Guardamos el registro en la bitácora
			
			$ipvisitante = $_SERVER["REMOTE_ADDR"];
			
			$detail[0] = array(
				'model' => 'accounts',
				'controller' => $this->router->class,
				'method' => $this->router->method,
				'data' => $datos,
			);
			
			//~ $detail = json_decode( json_encode( $detail ), true );
			$detail = json_encode( $detail );
			
			//~ print_r($detail);
			
			$bitacora = array(
				'date' => date('Y-m-d H:i:s'),
				'ip' => $ipvisitante,
				'user_id' => $this->session->userdata('logged_in')['id'],
				'detail' => $detail
			);
			
			//~ print_r($bitacora);
			
			$insert_bitacora = $this->MBitacora->insert($bitacora);

			echo '{"response":"ok"}';
       
        }else{
			
			echo '{"response":"error"}';
			
		}
    }
	
	// Método para editar
    public function edit() {
		
		$this->load->view('base');
        $data['id'] = $this->uri->segment(3);
        $data['editar'] = $this->MCuentas->obtenerCuenta($data['id']);
        $data['account_type'] = $this->MTiposCuenta->obtener();
        $data['monedas'] = $this->MCoins->obtener();
        $this->load->view('cuentas/editar', $data);
		$this->load->view('footer');
    }
	
	// Método para actualizar
    public function update() {
		
		$datos = array(
			'id' => $this->input->post('id'),
			'owner' => $this->input->post('owner'),
			'alias' => $this->input->post('alias'),
			'number' => $this->input->post('number'),
			'user_id' => $this->session->userdata('logged_in')['id'],
            'type' => $this->input->post('type'),
            'description' => $this->input->post('description'),
            'amount' => $this->input->post('amount'),
            'coin_id' => $this->input->post('coin_id'),
            'status' => $this->input->post('status'),
            'd_update' => date('Y-m-d H:i:s')
		);
		
        $result = $this->MCuentas->update($datos);
        
        if ($result) {
			
			// Guardamos la actualización en la bitácora
			
			$ipvisitante = $_SERVER["REMOTE_ADDR"];
			
			$detail[0] = array(
				'model' => 'accounts',
				'controller' => $this->router->class,
				'method' => $this->router->method,
				'data' => $datos,
			);
			
			//~ $detail = json_decode( json_encode( $detail ), true );
			$detail = json_encode( $detail );
			
			//~ print_r($detail);
			
			$bitacora = array(
				'date' => date('Y-m-d H:i:s'),
				'ip' => $ipvisitante,
				'user_id' => $this->session->userdata('logged_in')['id'],
				'detail' => $detail
			);
			
			//~ print_r($bitacora);
			
			$insert_bitacora = $this->MBitacora->insert($bitacora);
			
			echo '{"response":"ok"}';
			
        }else{
			
			echo '{"response":"error"}';
			
		}
    }
    
	// Método para eliminar
	function delete($id) {
		
		// Primero verificamos si está asociada a alguna transacción
		$search_assoc = $this->MCuentas->obtenerCuentaFondos($id);
		
		// Luego verificamos si está asociada a algún grupo de inversionistas
		$search_assoc2 = $this->MCuentas->obtenerCuentaGrupos($id);
		
		if(count($search_assoc) > 0){
			
			echo '{"response":"existe"}';
			
		}else if(count($search_assoc2) > 0){
			
			echo '{"response":"existe2"}';
			
		}else{
			
			$result = $this->MCuentas->delete($id);
			
			if($result){
				
				// Guardamos la actualización en la bitácora
			
			$ipvisitante = $_SERVER["REMOTE_ADDR"];
			
			$detail[0] = array(
				'model' => 'accounts',
				'controller' => $this->router->class,
				'method' => $this->router->method,
				'data' => array("id" => $id, "user_id" => $this->session->userdata('logged_in')['id']),
			);
			
			//~ $detail = json_decode( json_encode( $detail ), true );
			$detail = json_encode( $detail );
			
			//~ print_r($detail);
			
			$bitacora = array(
				'date' => date('Y-m-d H:i:s'),
				'ip' => $ipvisitante,
				'user_id' => $this->session->userdata('logged_in')['id'],
				'detail' => $detail
			);
			
			//~ print_r($bitacora);
			
			$insert_bitacora = $this->MBitacora->insert($bitacora);
				
				echo '{"response":"ok"}';
				
			}else{
				
				echo '{"response":"error"}';
				
			}
			
		}
        
    }
	
	public function ajax_cuentas()
    {
        $result = $this->MCuentas->obtener();
        echo json_encode($result);
    }
	
	
}
