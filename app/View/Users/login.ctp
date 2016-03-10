<div class="container content-padding">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4 well">
            <?php echo $this->Session->flash('flash',array('element'=>'Flash/error')); ?>
            <?php
            if (isset($logged_in) && !$logged_in) {

                echo $this->Form->create('User', array(
                    'action'=>'login',
                    'class'=>'form-signin', 
                    'role'=>'form'
                    )); 
                ?>
                <h3 class="text-center">Dados para acesso</h3>
                <div class="padtopbot5">
                <?php
                    echo $this->Form->input('username', array(
                        'type'=>'text',
                        'label'=>false,
                        'div'=>false,
                        'class'=>"form-control",
                        'placeholder'=>"Digite seu usuário"
                        ));
                ?>
                </div>
                <div class="padtopbot5">
                <?php
                    echo $this->Form->input('password', array(
                        'label'=>false,
                        'div'=>false,
                        'class'=>"form-control",
                        'placeholder'=>"Digite sua senha"
                        ));
                ?>
                </div>
                <div class="padtopbot5 text-center">
                <?php
                    echo $this->Form->input('Acessar',array(
                        'type'=>'submit',
                        'label'=>false,
                        'div'=>false,
                        'value'=>'Login',
                        'class'=>'btn btn-md btn-black'
                        ));
                ?>
                </div>
                <div class="padtopbot5 text-center">
                <?php 
                    echo $this->Facebook->login(array(
                        'perms' => 'public_profile,user_about_me,email,publish_actions',
                        'img'=>'connectwithfacebook.gif',
                        'redirect'=>array(
                            'controller'=>'users',
                            'action'=>'FBlogin'))); ?>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>