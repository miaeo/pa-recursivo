<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: index - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php
require_once("./toolskit.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Abertura",$bloco);
montatabestrut("Professores - Abertura");

# Form que permite 'Pesquisar' uma parte da tabela professores
printf("<form action='./index.php' method='POST'>\n");
printf("<input type='hidden' name='bloco' value='2'>\n");
printf("<input type='hidden' name='salto' value='$salto'>\n");
printf("<input type='text' name='txnomeprofessor' size='60' maxlength='90'>\n");
printf("%s <br>", barradebotoes("Pesquisar",FALSE,$salto));
printf("Escreva parte do nome do professor e/ou clique em 'Pesquisar'\n");
printf("</form>\n");

switch(TRUE) {
    case($bloco==1):{
        printf("Este sistema faz o Gerenciamento de dados da Tabela professores.<br>\n");
        printf("O menu apresentado acima indica as funcionalidades do sistema.\n");
        break;
    }
    case($bloco==2):{
        # Montagem do campo de seleção do professor para operações posteriores
        printf("<form action='' method='POST'>\n");
        printf("<input type='hidden' name='bloco' value='1'>");
        printf("<input type='hidden' name='salto' value='$salto'>\n");
        $cmdsql="SELECT pkprofessor, txnomeprofessor
                    FROM professores as p
                    order by txnomeprofessor";
        $execcmd=mysqli_query($nuconexao, $cmdsql);
        printf("<select name='pkprofessor'\n>");
        while($reg=mysqli_fetch_array($execcmd)){
            # Exibindo valores do cmd sql que foi executado no BD
            printf("<option value='$reg[pkprofessor]'>$reg[txnomeprofessor] - ($reg[pkprofessor])</option>");
        }
        printf("</select><br>\n");

        printf("<button type='submit' formaction='./incluir.php'>Incluir</button>\n");
        printf("<button type='submit' formaction='./consultar.php'>Consultar</button>\n");
        printf("<button type='submit' formaction='./alterar.php'>Alterar</button>\n");
        printf("<button type='submit' formaction='./excluir.php'>Excluir</button>\n");
        printf("<button type='submit' formaction='./listar.php'>Listar</button>\n");
        printf("</form>\n");
        printf("<button onclick='history.go(-1)'>Voltar para 'Pesquisar'</button><br>\n");
	    break;
    }
}

desmontatabestrut();
terminapagina("professores","index.php");
?>