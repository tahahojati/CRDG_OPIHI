<?php
/**
* @param $active: indicates which link in nav will have class active
* @param $login: indicates whether login modal should not be printed (value 0), If it should be printed with label Login (value 1) or Label Log out (value 2). 
*/
function printNav($view , $active = 0, $login = 1){
    if($active === null ) $active = 0; 
	if($login  == null) $login = 1; 
    $navdata = array (
        array(
            'href' => $view -> url(array('controller'=>'index','action' => 'index')),
            'content' => '<span class="glyphicon glyphicon-home" ></span> Home ',
            ),
        array  (
            'href' => $view -> url(array('controller'=>'index', 'action' =>'index')),
            'content' => '<span class="glyphicon glyphicon-search"> </span> Browse the Results'
            ),
                array(
            'href' => $view -> url(array('controller'=>'index','action' => 'contact')),
            'content' => '<span class="glyphicon glyphicon-envelope" > </span> Contact Us'
            ),
        array(
            'href' => $view -> url(array('controller'=>'index', 'action' =>'member')),
            'content' => '<span class="glyphicon glyphicon-user"> </span> Members',
            ),
        array(
            'href' => $view -> url(array('controller'=>'User', 'action' =>'register')),
            'content' => '<span class="glyphicon glyphicon-user"> </span> Register new teacher',
        ),
		array(
            'href' => $view -> url(array('controller'=>'Study', 'action' =>'create')),
            'content' => '<span class="glyphicon glyphicon-user"> </span> Create a new field trip',
        ),
        );
    $navdata[$active]['active'] = 'active' ; 
    if($login === 1){
   /* echo' 
<div class="fade modal" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                Login
                </h3>
                <button class="close" data-dismiss="modal" href="#loginModal"> &times; </button>
            </div>
            <div class="modal-body">'  . $view -> loginForm .'
            </div>
        </div>
    </div>
</div>
<!-- End of login modal section -->';*/
}
echo '
<nav class="nav navbar-nav navbar-default navbar-fixed-top" role="navigation" >
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" > <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
            <!--<a class="navbar-brand" href="#"> Opihi intertidial project </a>-->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul   class="nav navbar-nav">
            ';
            foreach($navdata as $item){
                if(isset($item['active']))
                    echo '<li class="active" > ';
                else
                    echo '<li> ';
                echo '<a href="'.$item['href'].'"> '.$item['content'].'</a> </li>
                ';
            }

            echo '</ul>
            <ul class="navbar-right nav navbar-nav">
                <li>';
				if (is_array($login)) 
					echo 'Hello '.$login['fname'].' '; 
					//var_dump($login); 
                    echo '<a class="navbar-right" href="';
					if( $login === 1) echo $view -> url(['controller' => 'user' , 'action' => 'login']).'">
                        <span class="glyphicon glyphicon-log-in"></span> Log in'; 
					else echo $view -> url(['controller' => 'user' , 'action' => 'logout']).'">
                        <span class="glyphicon glyphicon-log-out"></span> Log out'; 
					echo '
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>';
}

?>