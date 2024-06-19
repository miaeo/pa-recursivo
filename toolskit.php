<?php
#------------------------------------------------------------------------------------------------------------------------
# Programa..: toolskit - Conjunto de funções sistêmicas
# Descrição.: Requer execução do toolskit.php
# Autoria...: Miranda Honorato
# Criação...: 16/06/2024
#------------------------------------------------------------------------------------------------------------------------
function barradebotoes($submit,$voltar,$salto){
    #------------------------------------------------------------------
    # Objetivo...: Esta função recebe argumentos para montar os botões dos PA.
    # Parâmetros.: $submit - um texto para montar o botão de submit.
    #              $voltar - TRUE|FALSE para indicar a montagem do botão com history.go(-1).
    #              $salto - Número com os saltos para o botão 'SAIR'
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    $pesquisar=($salto>=3) ? $salto-1:1;
    printf( (ISSET($submit)) ? "<button type='submit'>$submit</button>":"");
    printf( ( $voltar ) ? "<button onclick='window.history.go(-1);return false;'>Voltar</button>":"");
    # printf( ( $pesquisar>=2 ) ? "<button onclick='window.history.go(-$pesquisar);return false;'>Pesquisar</button>":"");
    printf("<button onclick='window.history.go(-$salto);return false;'>Sair</button>");
}
function escolhachaveestrangeira($tabela,$chaveprim,$campodesc,$chaveestrang,$cealterar){
    #------------------------------------------------------------------
    # Objetivo...: 
    # Parâmetros.: $tabela - Tabela do banco de dados de onde está sendo referida as chaves
    #              $chaveprim - Chave primária (pk)
    #              $campodesc - 
    #              $chaveestrang - Chave estrangeira (fk)
    #              $cealterar - 
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    global $nuconexao;
    $cmdsql="SELECT $chaveprim, $campodesc FROM $tabela order by $campodesc";
    $execcmd=mysqli_query($nuconexao,$cmdsql);
    printf("<select name='$chaveestrang'>");
    while ( $reg=mysqli_fetch_array($execcmd) )
    { #Exibindo os valores do cmd sql que foi executado no BD
      $selected=( $reg[$chaveprim]==$cealterar) ? " selected":"";
      printf("<option value='$reg[$chaveprim]'$selected>$reg[$campodesc]-($reg[$chaveprim])</option>\n");
    }
    printf("</select>\n");
}
function iniciapagina($NomeFormTab, $NomeTabBD, $acao, $bloco){
    #------------------------------------------------------------------
    # Objetivo...: Esta função recebe argumentos para montar as TAGs iniciais das Páginas dos PAs.
    # Parâmetros.: $NomeFormTab - Nome Usual da tabela (Escrito com acentos e Maiús/Minúsculas).
    #              $NomeTabBD - Nome Formal da tabela (como escrito na Base de Dados).
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    printf("<!DOCTYPE html>\n");
    printf("<html>\n");
    printf(" <head>\n");
    printf("  <title>$NomeFormTab-$acao</title>\n");
    printf("  <link rel='stylesheet' type='text/css' href='../php-projeto-2/$NomeTabBD.css'>\n");
    printf(" </head>\n");
    printf(( $acao=='Listar' and $bloco=='3' ) ? " <body class='impr'>\n":" <body>\n");
}
function montatabestrut($titulo){
    #------------------------------------------------------------------
    # Objetivo...: Esta função escreve as TAGs que monta a tabela organizadora das páginas dos PAs.
    # Parâmetros.: $titulo - String do título da página
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    printf("<table width='100%%'>\n");
    printf("<tr>\n");
    printf("<td width='10%%'></td>\n");
    printf("<td><center><titulo>$titulo</titulo><br>\n");
}
function desmontatabestrut(){
    #------------------------------------------------------------------
    # Objetivo...: Esta função escreve as TAGs que 'desmonta' a tabela organizadora das páginas dos PAs.
    # Parâmetros.: Não recebe parâmetros.
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    printf("</center>\n");
    printf("</td>\n");
    printf("<td width='10%%'></td>\n");
    printf("</tr>\n");
    printf("</table>\n");
}
function terminapagina($NomeFisTab, $Turno, $NomePA){
    #------------------------------------------------------------------
    # Objetivo...: Esta função escreve as TAGs que 'termina' a tabela organizadora das páginas dos PAs.
    # Parâmetros.: $NomeFisTab - Nome da Tabela como escrito on BD.
    #              $NomePA - Nome do Arquivo onde está escrito o PA.
    #              $Turno - Turno no qual o aluno cursa - recebe as Letras 'T' ou 'N'.
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    printf("  <hr>\n");
    printf( ($Turno=='T')  ? "  <center>$NomeFisTab - &copy; 2024-1 - 4&ordm;ADS-Tarde - $NomePA</center>" :
                             "  <center>$NomeFisTab - &copy; 2024-1 - 4&ordm;ADS-Noite - $NomePA</center>");
    printf(" </body>\n");
    printf("</html>\n");
}
function conectamariadb($server, $username, $passd, $basename){
    #------------------------------------------------------------------
    # Objetivo...: Esta função recebe argumentos para conectar-se aos servidores do MariaDB.
    # Parâmetros.: $server - Nome da sessão do servidor/IP.
    #              $username - Usuário de acesso.
    #              $passd - Senha de acesso.
    #              $basename - Banco de dados onde está localizada a tabela.
    # Autoria....: Miranda Honorato
    # Criação....: 16/06/2024
    #------------------------------------------------------------------
    global $nuconexao;
    $nuconexao=mysqli_connect($server, $username, $passd, $basename);
}
#------------------------------------------------------------------
# Conexão com BD
conectamariadb("localhost","root","","mirandahonorato");
?>
