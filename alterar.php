<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: alterar - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php e do arquivo de funções local
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php e o arquivo de funções local
require_once("./toolskit.php");
require_once("./funcoes.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Alterar", $bloco);
montatabestrut("Professores - Alterar");
switch(TRUE) {
    case($bloco==1):{
        montaform("$_REQUEST[pkprofessor]", $salto);
        break;
    }
    case($bloco==2):{
        # Tratamento da transação de alteração do registro
        $cmdsql="UPDATE professores SET txnomeprofessor ='$_REQUEST[txnomeprofessor]',
                                        fklogradouro    ='$_REQUEST[fklogradouro]',
                                        txcomplemento   ='$_REQUEST[txcomplemento]',
                                        nucepprofessor  ='$_REQUEST[nucepprofessor]',
                                        dtnascimento    ='$_REQUEST[dtnascimento]',
                                        dtcadprofessor  ='$_REQUEST[dtcadprofessor]'
                        WHERE pkprofessor ='$_REQUEST[pkprofessor]'";
        $tentativa=TRUE;
        while($tentativa) { 
            mysqli_query($nuconexao, "START TRANSACTION");
            $execcmd=mysqli_query($nuconexao, $cmdsql);
            if (mysqli_errno($nuconexao)==0) {
                # Não deu erros  
                $mostramensagem=TRUE;
                mysqli_query($nuconexao, "COMMIT");
                $mensagem= "O registro do professor ".$_REQUEST['pkprofessor']." foi ALTERADO na Tabela.";
                $tentativa=FALSE;
                $mostramensagem=TRUE;
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
                    $mostramensagem=FALSE;
                    $mensagem="Ocorreu um erro irrecuperável: ".mysqli_errno($nuconexao)." - ".mysqli_error($nuconexao)."";
                    mysqli_query($nuconexao, "ROLLBACK");
                    $tentativa=FALSE;
                    $mostramensagem=FALSE;
                }
            }
        }
        if ( $mostramensagem )
        {
           mostraregistro($_REQUEST['pkprofessor']);
        }
        printf("$mensagem<br>");
        barradebotoes(NULL,FALSE,$salto);
        break;
    }
}
desmontatabestrut();
terminapagina("professores","alterar.php");
?>