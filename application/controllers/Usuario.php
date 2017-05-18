<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Verifica se o usuário NÂO está logado
        // e redireciona para a autenticação.
        if (!$this->session->userdata('logado')) {
            redirect('conta/entrar');
        }
    }

    // Exibir informações sobre o nosso sistema
    public function visualizar_todos() {

        $alerta = null;

        // Para carregar o model: usuarios_model
        $this->load->model('usuarios_model'); // cuidado com cse sensitive

        $usuarios = $this->usuarios_model->get_usuarios();

        /* var_dump($usuarios); // para ver o que esta entrando

          exit; */

        $dados = array(
            "alerta" => $alerta,
            "usuarios" => $usuarios
        );

        $this->load->view('usuario/visualizar_todos', $dados);
    }

    public function cadastrar() {

        $alerta = null;

        $dados = array(
            "alerta" => $alerta
        );

        $this->load->view('usuario/visualizar_todos', $dados);
    }

    public function editar($id_usuario) {
        $alerta = null;
        $usuario = null;

        // Converte o id do usuário para int
        $id_usuario = (int) $id_usuario;

        if ($id_usuario) {
            // Carrega o model
            $this->load->model('usuarios_model');

            // Verifica se o usuário está cadastrado no banco
            $existe = $this->usuarios_model->get_usuario($id_usuario);
            if ($existe) {
                // Armazena em uma variável legível
                $usuario = $existe;

                if ($this->input->POST('editar') === "editar") {
                    if ($this->input->POST('captcha'))
                        redirect('conta/editar');

                    // Definir regras de validação
                    $this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email');
                    $this->form_validation->set_rules('senha', 'SENHA', 'required|min_lenght[3]|max_lenght[20]');
                    $this->form_validation->set_rules('confirmar_senha', 'CONFIRMAR SENHA', 'required|min_lenght[3]|max_lenght[20]|matches[senha]');

                    // Verificar se as regras são atendidas
                    if ($this->form_validation->run() === TRUE) {

                        $usuario_atualizado = array(
                            "email" => $this->input->POST('email'),
                            "senha" => $this->input->POST('senha')
                        );
                    } else {
                        // Formulário inválido
                        $alerta = array(
                            "class" => "danger",
                            "mensagem" => "Atenção! O formulário não foi validado!"
                        );
                    }
                }
            } else {
                // Define um valor vazio para o usuário
                $usuario = FALSE;

                // Usuário não existe
                $alerta = array(
                    "class" => "danger",
                    "mensagem" => "Atenção! O Usuário não foi encontrado!"
                );
            }
        } else {
            // Usuário invalido
            $alerta = array(
                "class" => "danger",
                "mensagem" => "Atenção! O Usuário informado está incorretos."
            );
        }

        $dados = array(
            "alerta" => $alerta,
            "usuario" => $usuario
        );
        $this->load->view('usuario/editar', $dados);
    }

}
