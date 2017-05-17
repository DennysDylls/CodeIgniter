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
