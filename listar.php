<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: listar - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
# Referenciando o toolskit.php
require_once("./toolskit.php");

$bloco=(ISSET($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$salto=(ISSET($_REQUEST['salto'])) ? $_REQUEST['salto'] +1 : 1;
iniciapagina("Professores","stylesheet","Listar", $bloco);

switch(TRUE) {
    case($bloco==1):{
        montatabestrut("Professores - Listar");
        printf("<form action='./listar.php' method='POST'>\n");
        printf("<input type='hidden' name='bloco' value='2'>");
        printf("<input type='hidden' name='salto' value='$salto'>\n");
        printf("<table border=1>\n");
        printf("<tr><td colspan=2>Escolha a <negrito>ordem</negrito> como os dados serão exibidos no relatório:</td></tr>\n");
        printf("<tr><td>Nome do Professor...:</td>    <td>(<input type='radio' name='ordem' value='p.txnomeprofessor' checked>)</td></tr>\n");
        printf("<tr><td>Código do Professor.:</td>    <td>(<input type='radio' name='ordem' value='p.pkprofessor'>)</td></tr>\n");
        $dtini="1901-01-01";
        $dtfim=date("Y-m-d");
        printf("<tr><td>Intervalo de datas de cadastro:</td><td><input type='date' name='dtcadini' value='$dtini'> até <input type='date' name='dtcadfim' value='$dtfim'></td></tr>");
        printf("   <tr><td></td><td>");
        printf("%s <br>",barradebotoes("Listar dados",FALSE,$salto));
        printf("</td></tr>\n");
        printf("</table></center>\n");
        printf("</form>\n");

        desmontatabestrut();
        break;
    }
    case($bloco==2 or $bloco==3):{
        $cmdsql="SELECT p.*, l.txnomelogrcompleto as txnomelogr
                        FROM professores as p
                        INNER JOIN logradourocompleto as l on p.fklogradouro=l.pklogradouro";
        $cmdsql=$cmdsql." where p.dtcadprofessor between '$_REQUEST[dtcadini]' and '$_REQUEST[dtcadfim]'";
        $cmdsql=$cmdsql." order by $_REQUEST[ordem]";
        $execsql=mysqli_query($nuconexao,$cmdsql);
        printf(" <center>\n");
        printf("  <titulo>Professores - Listar</titulo>");
        $corlinha=" bgcolor='#00FA9A'";
        printf("<table border=1 style=' border-collapse: collapse; '>\n");
        printf("<tr$corlinha><td rowspan=2 valign=top>Cod.</td>\n
                <td rowspan=2 valign=top>Nome</td>\n
                <td rowspan=2 valign=top>Logradouro</td>\n
                <td rowspan=2 valign=top>Complemento</td></tr>\n");
        printf("<tr$corlinha><td valign=top>CEP</td>\n
                <td valign=top>Dt.Nasc.</td>\n
                <td valign=top>Dt.Cad.</td></tr>\n");
        # Cores da lista
        # #00FA9A - verde primavera
        # #90EE90 - verde claro
        # #ADD8E6 - azul claro
        # #F5F5F5 - branco
        while ( $le=mysqli_fetch_array($execsql) ) {
        $corlinha=($corlinha==" bgcolor='#F5F5F5'") ? " bgcolor='#ADD8E6'" : " bgcolor='#F5F5F5'";
        printf("<tr$corlinha><td>$le[pkprofessor]</td>\n
                    <td valign=top>$le[txnomeprofessor]</td>\n
                    <td valign=top>$le[txnomelogr] - ($le[fklogradouro])</td>\n
                    <td valign=top>$le[txcomplemento]</td>\n
                    <td valign=top>$le[nucepprofessor]</td>\n
                    <td valign=top>$le[dtnascimento]</td>\n
                    <td valign=top>$le[dtcadprofessor]</td></tr>\n");
        }
        printf("</table>\n");
        if ( $bloco==2 ) {
        printf("<form action='./listar.php' method='POST' target='_NEW'>\n");
        printf(" <input type='hidden' name='bloco' value=3>\n");
        printf(" <input type='hidden' name='salto' value='$_REQUEST[salto]'>\n");
        printf(" <input type='hidden' name='dtcadini' value=$_REQUEST[dtcadini]>\n");
        printf(" <input type='hidden' name='dtcadfim' value=$_REQUEST[dtcadfim]>\n");
        printf(" <input type='hidden' name='ordem' value=$_REQUEST[ordem]>\n");
        barradebotoes("Gerar Cópia para Impressão",TRUE,$salto);
        printf("</form>\n");
        }
        else {
        printf("<button type='submit' onclick='window.print();'>Imprimir</button> - Corte a folha abaixo da linha no final da página<br>\n<hr>\n");
        }

        break;
    }
}

terminapagina("professores","N", "listar.php");
?>
