<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function index() // index vai direto, com 'editar' tem que estar na url
	{
		$this->load->view('usuario/editar');
	}
}
