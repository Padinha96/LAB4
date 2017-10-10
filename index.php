<?php 
require_once "HTML/Template/IT.php";
include 'inc/db.inc'; 

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
if($db) {
  // criar query numa string
  $query  = "SELECT * FROM microposts";
  
  // executar a query
  if(!($result = @ mysql_query($query,$db )))
   showerror();

  // Cria um novo objecto template
  $template = new HTML_Template_IT('.');

  // Carrega o template Filmes2_TemplateIT.html
  $template->loadTemplatefile('index_template.html', true, true);


  // mostra o resultado da query utilizando o template

  $nrows  = mysql_num_rows($result);
   for($i=0; $i<$nrows; $i++) {
     $tuple = mysql_fetch_array($result,MYSQL_ASSOC);
     
     // trabalha com o bloco FILMES do template
     $template->setCurrentBlock("MENU");

     $template->setVariable('MENU1', "HOME");
     $template->setVariable('MENU2', "Login");
     $template->setVariable('MENU3', "Register");
     $template->setVariable('ACORES', $tuple['acores']);
	      $template->parseCurrentBlock();
		       $template->setCurrentBlock("MICROPOSTS");
     $template->setVariable('USER', "user");
     $template->setVariable('UPDATED', $tuple['updated_at']);
	      $template->setVariable('UPDATE', $tuple['likes']);
		       $template->setVariable('CREATED', $tuple['created_at']);
   
     // Faz o parse do bloco FILMES
     $template->parseCurrentBlock();

   } // end for

  // Mostra a tabela
  $template->show();

  // fechar a ligação à base de dados
  mysql_close($db);
} // end if 
?>

