<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function get_usuario($id_usuario)
	{
		$this->db->where("id", $id_usuario); // WHERE "id" = $i_usuario

		$usuario = $this->db->get('usuarios'); // SELECT * FROM usuario WHERE "id" = $id_usuario

		if($usuario->num_rows())
		{
			return $usuario->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_usuarios()
	{
		$query = $this->db->get('usuarios'); // SELECT * FROM usuarios (nome da tabela para ele buscar)

		// Verificar se tem alguma coisa
		if($query->num_rows())
		{
			// Retorna o resultado
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function check_login($email, $senha)
	{
		// Definindo o parâmetro FROM
		$this->db->from('usuarios');
		
		// Definindo os parâmetros WHERE
		$this->db->where('email', $email);
		$this->db->where('senha', $senha);

		// Executando a QUERY no banco de dados
		$usuarios = $this->db->get();

		// Verificando o resuldado da busca acima
		if($usuarios->num_rows())
		{
			$usuario = $usuarios->result_array();
			return $usuario[0];

		}
		else
		{
			return FALSE;
		}

	}
	
}
