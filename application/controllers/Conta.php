<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('logado'))
		{
			if(!$this->uri->segment(2) == "sair")
			{
				redirect('dashboard');				
			}
		}/*
		else
		{
			
			$this->entrar();
		}*/

		/*/ verifica informações de login
		var_dump($this->session->all_userdata());
		exit;
		*/
	}
	
	public function entrar(){
		//echo base_url('assets/css/bootstrap.min.css');

		/* só para verificar se o post está funcionando, tem que carregar a página sem este código */
		//var_dump($this->input->post());
		//exit;

		$alerta = null;

		if($this->input->post('entrar') === "entrar")
		{
			// echo "O formulário foi submetido.";
			if($this->input->post('captcha')) redirect('conta/entrar');

			// Deine as regras de validação
			$this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email');
			$this->form_validation->set_rules('senha', 'SENHA', 'required|min_length[6]|max_length[20]');

			// Executa as regras de validação
			if($this->form_validation->run() === TRUE)
			{
				// Carrega o model "usuarios_model" apenas para este 'momento'
				$this->load->model('usuarios_model');

				// Armazenando os dados do formulário em variáveis
				$email = $this->input->post('email');
				$senha = $this->input->post('senha');

				// Executando o método check_login do usuarios_model
				$login_existe = $this->usuarios_model->check_login($email, $senha);

				// recebe o resultado de 'login_existe' da class Usuarios_model
				// Verificando se os dados digitados estão corretos
				if($login_existe)
				{
					// Login autoriazado... iniciar sessão
					$usuario = $login_existe;

					// configura os dados da sessão
					$session = array(
						// pega do banco
				        'email'     => $usuario["email"],
				        'created'   => $usuario["created"],
				        'logado'    => TRUE
					);

					// inicializa a sessão e redirecionar para algum lugar restrito
					$this->session->set_userdata($session);

					redirect('dashboard');

				}
				else
				{
					// Login invalido
					$alerta = array(
						"class" => "danger",
						"mensagem" => "Atenção! Login inválido, senha ou email incorretos."
					);
				}

			}
			else
			{
				$alerta = array(
					"class" => "danger",
					"mensagem" => "Atenção! Falha na validação do formulário!<br>". validation_errors()
				);
			}
		}

		$dados = array(
			"alerta" => $alerta
			);

		$this->load->view('conta/entrar' , $dados);

	}

	public function sair(){
		
		// apenas remove o logado
		//$this->session->unset_userdata('logado');

		// destruir toda a sessão
		$this->session->sess_destroy();

		redirect('welcome');

	}
}
