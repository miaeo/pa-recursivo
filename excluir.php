<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: excluir - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php e do arquivo de funções local
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php e o arquivo de funções local
require_once("./toolskit.php");
require_once("./funcoes.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Excluir",$bloco);
montatabestrut("Professores - Excluir");

switch(TRUE) {
    case($bloco==1):{
        mostraregistro($_REQUEST['pkprofessor']);
        printf("<form action='./excluir.php' method='POST'>\n");
        printf("<input type='hidden' name='bloco' value='2'>");
        printf("<input type='hidden' name='salto' value='$salto'>\n");
        printf("<input type='hidden' name='pkprofessor' value='$_REQUEST[pkprofessor]'>\n");
        barradebotoes("Confirmar a Exclusão",TRUE,$salto);
        printf("</form>\n");
        break;
    }
    case($bloco==2):{
    # Tratamento da transação de exclusão do registro
    $cmdsql="DELETE FROM professores WHERE professores.pkprofessor='$_REQUEST[pkprofessor]'";
    $tentativa=TRUE;
    while($tentativa) { 
        mysqli_query($nuconexao, "START TRANSACTION");
        $execcmd=mysqli_query($nuconexao, $cmdsql);
        if (mysqli_errno($nuconexao)==0) {
            # Não deu erros  
            mysqli_query($nuconexao, "COMMIT");
            $mensagem= "O registro com código ".$_REQUEST['pkprofessor']." foi DELETADO com sucesso!";
            $tentativa=FALSE;
        } 
        else {  
            # Deu erro
            if (mysqli_errno($nuconexao)==1213) {
                # Se for Deadlock:
                # Reinicio de transação
                mysqli_query($nuconexao, "ROLLBACK");
                $tentativa=TRUE;
            }
            else {
                # Se NÃO for Deadlock:
                # Erro irrecuperável -> transação cancelada
                $mensagem="Ocorreu um erro irrecuperável: ".mysqli_errno($nuconexao)." - ".mysqli_error($nuconexao)."";
                mysqli_query($nuconexao, "ROLLBACK");
                $tentativa=FALSE;
            }
        }
    }
    print("$mensagem<br>");
    barradebotoes(null,FALSE,$salto);
    break;
    }
}
desmontatabestrut();
terminapagina("professores", "excluir.php");
?>