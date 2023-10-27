<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Conversor de Moedas v1.0</h1>
        <?php 
            $reais = $_POST["reais"] ?? 0;
            
            if($reais == 0){
                print "<p>Perdão, mas o valor inserido \"$reais\", <strong>não é válidos</strong>!</p>";
            }
            else if($reais < 0){
                print "<p>Perdão, mas o valor inserido \"$reais\", <strong>não é válidos</strong>!</p>";
                print "<p>Tá devendo pro banco é, fudido?</p>";
            }
            else{
                $inicio = date("m-d-Y", strtotime("-7 days"));
                $fim = date("m-d-Y");
                $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                $dados = json_decode(file_get_contents($url), true);
                $cotacaoDolar = $dados["value"][0]["cotacaoCompra"];
                
                $dolar = $reais / $cotacaoDolar;
                $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
    
                print "<p>Seus " . numfmt_format_currency($padrao, $reais, "BRL") . " equivalem à <strong>" . numfmt_format_currency($padrao, $dolar, "USD") . "</strong></p>";
            }
        ?>
        <button onclick="javascript:history.go(-1)">Voltar</button>
        <p style="font-size: 0.8em;">cotação atual: <strong><?php print numfmt_format_currency($padrao, $cotacaoDolar, "USD"); ?></strong></p>
    </main>
    <footer>
        <p>
            Desenvolvido por <a href="https://github.com/Jotapehh" target="_blank" rel="external">Jotapehh</a> para <a href="https://youtube.com/@CursoEmVideo" target="_blank" rel="external">CursoEmVídeo</a>
        </p>
    </footer>
</body>
</html>