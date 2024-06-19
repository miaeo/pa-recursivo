<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: consultar - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php e do arquivo de funções local
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php e o arquivo de funções local
require_once("./toolskit.php");
require_once("./funcoes.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Consultar", $bloco);
montatabestrut("Professores - Consultar");

switch(TRUE) {
    case($bloco==1):{
        mostraregistro($_REQUEST['pkprofessor']);
        barradebotoes(null,TRUE,$salto);
        break;
    }
}

desmontatabestrut();
terminapagina("professores","consultar.php");
?>