<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: funcoes - PA-Recursivo com dois blocos.
# Descrição.: Requer execução do toolskit.php
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
function mostraregistro($cp){
    global $nuconexao;
    printf("Mostrando os valores do registro escolhido:<br>\n");
    # Lendo os dados do registro da tabela 'professores'
    $cmdsql="SELECT p.*, l.txnomelogrcompleto as txnomelogr
                FROM professores as p
                    INNER JOIN logradourocompleto as l on p.fklogradouro=l.pklogradouro
                WHERE pkprofessor='$cp'";
    $execcmd=(mysqli_query($nuconexao, $cmdsql));
    # Montando o registro com os dados dos professores
    if (mysqli_num_rows($execcmd)==0) {
        printf("Não existem professores no cadastro.<br>");
    } else {
        $reg=mysqli_fetch_array($execcmd);
        printf("<table border='1'>\n");
        printf("<tr><td>Código</td>         <td>$reg[pkprofessor]</td></tr>\n");
        printf("<tr><td>Nome</td>           <td>$reg[txnomeprofessor]</td></tr>\n");
        printf("<tr><td>Logr.</td>          <td>$reg[txnomelogr] - $reg[fklogradouro]</td></tr>\n");
        printf("<tr><td>Complemento</td>    <td>$reg[txcomplemento]</td></tr>\n");
        printf("<tr><td>Nu CEP</td>         <td>$reg[nucepprofessor]</td></tr>\n");
        printf("<tr><td>DT Nasc.</td>        <td>$reg[dtnascimento]</td></tr>\n");
        printf("<tr><td>Registro</td>       <td>$reg[dtcadprofessor]</td></tr>\n");
        printf("</table>\n");
    }
}
function montaform($cp,$salto){
    global $nuconexao;
    if(ISSET($cp)){
        # Função executada pelo ALTERAR
        # Comando SQL que recupera os registros da BD
        $cmdsql="SELECT * FROM professores WHERE pkprofessor='$_REQUEST[pkprofessor]'";
        $reg=mysqli_fetch_array(mysqli_query($nuconexao,$cmdsql));
        $prg="alterar.php";
        $primeiralinha="$reg[pkprofessor] - O valor NÃO será alterado pelo sistema";
        $acao="Alterar";
    }
    else{
        # Função executada pelo INCLUIR
        # Esvaziando o vetor $reg
        $reg['pkprofessor']="";
        $reg['txnomeprofessor']="";
        $reg['fklogradouro']="";
        $reg['txcomplemento']="";
        $reg['nucepprofessor']="";
        $reg['dtnascimento']="";
        $reg['dtcadprofessor']="";
        $prg="incluir.php";
        $primeiralinha="Valor será gerado pelo sistema";
        $acao= "Incluir";
    }
    printf("<form action='./$prg' method='POST'>\n");
    printf("<input type='hidden' name='bloco' value='2'>");
    printf("<input type='hidden' name='salto' value='$salto'>\n");
    printf(( ISSET($cp)) ? "<input type='hidden' name='pkprofessor' value='$reg[pkprofessor]'>":"");
    printf("<table border='0'>\n");
    printf("<tr><td>Código</td>         <td>$primeiralinha</td></tr>\n");
    printf("<tr><td>Nome</td>           <td><input type='text' name='txnomeprofessor' value='$reg[txnomeprofessor]' size='60' maxlength='60'></td></tr>\n");
    printf("<tr><td colspan='2'><hr></td></tr\n>");
    printf("<tr><td>Logr. </td>      <td>");
    escolhachaveestrangeira("logradourocompleto","pklogradouro","txnomelogrcompleto","fklogradouro","$reg[fklogradouro]");
    printf("</td></tr\n>");
    printf("<tr><td>Complemento</td>    <td><input type='text' name='txcomplemento' value='$reg[txcomplemento]' size='60' maxlength='60'></td></tr>\n");
    printf("<tr><td>Nu CEP</td>         <td><input type='text' name='nucepprofessor' value='$reg[nucepprofessor]' size='10' maxlength='8'></td></tr>\n");
    printf("<tr><td colspan='2'><hr></td></tr\n>");
    printf("<tr><td>DT Nasc</td>        <td><input type='date' name='dtnascimento' value='$reg[dtnascimento]' ></td></tr>\n");
    printf("<tr><td>Registro</td>       <td><input type='date' name='dtcadprofessor' value='$reg[dtcadprofessor]'></td></tr>\n");
    printf("</table>\n");
    barradebotoes($acao,TRUE,$salto);
    printf("</form>\n");
}
?>