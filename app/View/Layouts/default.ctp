<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'TVZonaLivre');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" href="<?php echo $this->webroot; ?>bootstrap/css/bootstrap.css">
	<link href="<?php echo $this->webroot ; ?>js/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="<?php echo $this->webroot ; ?>js/jquery-ui-1.11.4/jquery-ui.js"></script>
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<!-- Bootstrap  -->
	<script src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('tvzl');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="navbar navbar-fixed-top navbar-blue">
				<div class="container-fluid wrap-container">
				    <!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php
							echo $this->Html->link( $this->Html->image('tvzonalivre.png',array('height'=>'30')), '/', array('class'=>'navbar-brand', 'escape'=>false, 'style'=>'margin:-8px'));
						?>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li>
								<?php echo $this->Html->link('Assitir',array('controller'=>'pages','action'=>'home')); ?>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">On Demand <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">Por Programa</a></li>
									<li><a href="#">Por Artista</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">Separated link</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>
							<li><a href="#">Programação</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<?php
								if ($logged_in) {
									if ($isAdmin) { 
							?>
							<li><a href="#">Admin</a></li>
							<?php 	} ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('Profile', array('controller'=>'users', 'action'=>'edit',AuthComponent::user('id'))); ?>
									</li>
									<li><a href="#">Something else here</a></li>
									<li role="separator" class="divider"></li>
									<li>
									<?php 
										echo $this->Facebook->logout(array('redirect' => array('controller' => 'users', 'action' => 'logout'), 'img' => 'facebook-logout.png')); 
									?>
									</li>
								</ul>
							</li>
						<?php
							} else {
						?>
							<li>
			                <?php 
			                    echo $this->Facebook->login(array(
//			                    	'label'=>'Login with Facebook',
			                        'perms' => 'public_profile,user_about_me,email,publish_actions',
			                        'img'=>'fb-xs-logo.png',
			                        'redirect'=>array(
			                            'controller'=>'users',
			                            'action'=>'FBlogin')));
			                 ?> 
							</li>
							<li>
			                <?php 
			                    echo $this->Facebook->login(array(
			                    	'label'=>'Acessar',
			                        'perms' => 'public_profile,user_about_me,email,publish_actions',
//			                        'img'=>'fb-xs-logo.png',
			                        'redirect'=>array(
			                            'controller'=>'users',
			                            'action'=>'FBlogin')));
			                 ?> 
							</li>
						<?php
							}
						?>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</div>
		</div>
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
<?php echo $this->Facebook->init(); ?>
</html>
