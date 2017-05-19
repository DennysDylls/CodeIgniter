<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login (teste)</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
    	<div class="row">
    		<div class="page-header">
			  <h1>Área de Login</h1>
			</div>
    		<div class="col-md-4 col-md-offset-4">
    			<?php if($alerta != null){ ?>
	    			<!--<div class="alert alert-danger">-->
	    			<div class="alert alert-<?php echo $alerta["class"]; ?>">
	    				<!-- Teste de mensagem de erro! -->
	    				<?php echo $alerta["mensagem"]; ?>
	    			</div>
	    		<?php } ?>
	    		<!-- poderia criar um "help" para chamar o alerta -->
				  <form action="<?php echo base_url('conta/entrar'); ?>" method="POST">
				  <input type="hidden" name="captcha">
				  <div class="form-group">
				    <label for="email">Email</label>
				    <!-- O código em php é para recolocar os dados dos campos, quando dê erro -->
				    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>" required>
				  </div>
				  <div class="form-group">
				    <label for="senha">Senha</label>
				    <!-- O código em php é para recolocar os dados dos campos, quando dê erro -->				    
				    <input type="password" name="senha" class="form-control" id="senha" placeholder="Senha" value="<?php echo set_value('senha'); ?>" required>
				  </div>
				  <button type="submit" name="entrar" value="entrar" class="btn btn-success pull-right">Entrar</button>
				</form>
    		</div>
    	</div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  </body>
</html>