<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Verifica se o usuário NÂO está logado
        // e redireciona para a autenticação.
        if (!$this->session->userdata('logado'))
        {
            redirect('conta/entrar');
        }
    }

    // Exibir informações sobre o nosso sistema
    public function visualizar_todos()
    {

        $alerta = null;

        // Para carregar o model: usuarios_model
        $this->load->model('usuarios_model'); // cuidado com cse sensitive

        $usuarios = $this->usuarios_model->get_usuarios();

        /* var_dump($usuarios); // para ver o que esta entrando

          exit; */

        $dados = array(
            "alerta"   => $alerta,
            "usuarios" => $usuarios
        );

        $this->load->view('usuario/visualizar_todos', $dados);
    }

    public function cadastrar()
    {

        $alerta = null;

        $dados = array(
            "alerta" => $alerta
        );

        $this->load->view('usuario/visualizar_todos', $dados);
    }

    public function editar($id_usuario)
    {
        $alerta  = null;
        $usuario = null;

        // Converte o id do usuário para int
        $id_usuario = (int) $id_usuario;

        if ($id_usuario)
        {
            // Carrega o model
            $this->load->model('usuarios_model');

            // Verifica se o usuário está cadastrado no banco
            $existe = $this->usuarios_model->get_usuario($id_usuario);
            if ($existe)
            {
                // Armazena em uma variável legível
                $usuario = $existe;

                if ($this->input->POST('editar') === "editar")
                {
                    // Converte também o id do usuário, que vem do POST, para int
                    $id_usuario_form = (int) $this->input->POST('id_usuario');
                    
                    if ($this->input->POST('captcha'))
                        redirect('conta/editar');
                    /* // só testar id
                    echo $id_usuario;
                    echo $this->input->POST('id_usuario');
                    exit;
                    */
                    if ($id_usuario !== $id_usuario_form)
                        redirect('conta/entrar'); // segurança para quando trocarem o id no url
                                                            
                    // Definir regras de validação
                    $this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email');
                    $this->form_validation->set_rules('senha', 'SENHA', 'required|min_lenght[3]|max_lenght[20]');
                    $this->form_validation->set_rules('confirmar_senha', 'CONFIRMAR SENHA', 'required|min_lenght[3]|max_lenght[20]|matches[senha]');

                    // Verificar se as regras são atendidas
                    if ($this->form_validation->run() === TRUE)
                    {
                        $usuario_atualizado = array(
                            "email" => $this->input->POST('email'), // índice do array
                            "senha" => $this->input->POST('senha') // índice do array
                        );

                        // $this->usuarios_model->update_usuario($this->input->POST('id'), $usuario_atualizado);
                        $atualizou = $this->usuarios_model->update_usuario($id_usuario, $usuario_atualizado);

                        if ($atualizou)
                        {
                            // Atualizações validadas 
                            $alerta = array(
                                "class"    => "success",
                                "mensagem" => "Atenção! O usuário foi atualizado com sucesso!"
                            );
                        }
                        else
                        {
                            // Erro na atualização
                            $alerta = array(
                                "class"    => "danger",
                                "mensagem" => "Atenção! O usuário não foi atualizado. :("
                            );
                        }
                    }
                    else
                    {
                        // Formulário inválido
                        $alerta = array(
                            "class"    => "danger",
                            "mensagem" => "Atenção! O formulário não foi validado!</br>". validation_errors()
                        );
                    }
                }
            }
            else
            {
                // Define um valor vazio para o usuário
                $usuario = FALSE;

                // Usuário não existe
                $alerta = array(
                    "class"    => "danger",
                    "mensagem" => "Atenção! O Usuário não foi encontrado!"
                );
            }
        }
        else
        {
            // Usuário invalido
            $alerta = array(
                "class"    => "danger",
                "mensagem" => "Atenção! O Usuário informado está incorretos."
            );
        }

        $dados = array(
            "alerta"  => $alerta,
            "usuario" => $usuario
        );
        $this->load->view('usuario/editar', $dados);
    }

}
