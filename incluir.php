<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: incluir - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php e do arquivo de funções local
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php e o arquivo de funções local
require_once("./toolskit.php");
require_once("./funcoes.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Incluir", $bloco);
montatabestrut("Professores - Incluir");

switch(TRUE) {
    case($bloco==1):{
        montaform(null,$salto);
        break;
    }
    case($bloco==2):{
        # Tratamento da transação de inclusão do registro
        $mostramensagem=TRUE;
        $tentativa=TRUE;
        while($tentativa) { 
            mysqli_query($nuconexao, "START TRANSACTION");
            $cmdsql="SELECT MAX(pkprofessor) AS CpMAX FROM professores";
            $ultimacp=mysqli_fetch_array(mysqli_query($nuconexao,$cmdsql));
            $CP=($ultimacp['CpMAX']=='NULL') ? 1 : $ultimacp['CpMAX']+1;
            $cmdsql="INSERT INTO professores (pkprofessor, txnomeprofessor, fklogradouro, txcomplemento,
                                                nucepprofessor, dtnascimento, dtcadprofessor) 
                            VALUES ('$CP',
                                    '$_REQUEST[txnomeprofessor]',
                                    '$_REQUEST[fklogradouro]',
                                    '$_REQUEST[txcomplemento]',
                                    '$_REQUEST[nucepprofessor]',
                                    '$_REQUEST[dtnascimento]',
                                    '$_REQUEST[dtcadprofessor]')";
            $execcmd=mysqli_query($nuconexao, $cmdsql);
            if (mysqli_errno($nuconexao)==0) {
                # Não deu erros  
                $mostramensagem=TRUE;
                mysqli_query($nuconexao, "COMMIT");
                $mensagem= "O registro com código $CP foi INCLUÍDO com sucesso!";
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
                    $mostramensagem=FALSE;
                    $mensagem="Ocorreu um erro irrecuperável: ".mysqli_errno($nuconexao)." - ".mysqli_error($nuconexao)."";
                    mysqli_query($nuconexao, "ROLLBACK");
                    $tentativa=FALSE;
                }
            }
        }
        if ( $mostramensagem )
        {
           mostraregistro($CP);
        }
        printf("$mensagem<br>");
        barradebotoes(NULL,FALSE,$salto);
        break;
    }
}
desmontatabestrut();
terminapagina("professores","incluir.php");   
?>