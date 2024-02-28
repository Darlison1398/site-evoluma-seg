<?php

require_once __DIR__.'/router.php';
const PASTA = '/evoluma';
// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('', 'views/index.php');

get('/home', 'views/home.php');
//get('/index', 'views/index.php');
//get(PASTA, 'views/index.php');


// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
//get(PASTA.'/cliente/$id', 'views/user');
get('/cliente/$id/$nome', 'views/cliente.php');

get('/servicos', 'views/servicos.php');

get('/produtos', 'views/produtos.php');

get('/servico/$id/$nome', 'views/servico.php');

get('/produto/$id/$nome', 'views/produto.php');

get('/clientes/$id/$nome', 'views/clientes.php');

get('/sobre/$id/$nome', 'views/sobre.php');

get('/noticias/$id/$nome', 'views/noticias.php');

get('/noticia/$id/$nome', 'views/noticia.php');

get('/contato/$id/$nome', 'views/contato.php');


get('/lgpd-ok', 'views/api/lgpd-ok.php');
get('/lgpd-no', 'views/api/lgpd-no.php');
get('/termos-uso', 'views/termos-uso.php');
get('/politica-privacidade', 'views/politica-privacidade.php');


//post('/send', 'views/send.php');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
//get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
//get('/product/$type/color/$color', 'product.php');

// A route with a callback
// get('/callback', function(){
//   echo 'Callback executed';
// });

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
// get('/callback/$name', function($name){
//   echo "Callback executed. The name is $name";
// });

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
// get('/callback/$name/$last_name', function($name, $last_name){
//   echo "Callback executed. The full name is $name $last_name";
// });

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
