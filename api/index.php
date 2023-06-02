<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="stylesheet" type="text/css" href="">
</head>

<body>
    <?php
    //Pegar os dados
    $nome = $_POST["name"];
    $cargo = $_POST["cargo"];
    $clt = $_POST["clt"];
    $salario = $_POST["salario"];
    $diastrabalhados = $_POST["diastrabalhados"];
    $ano = $_POST["ano"];
    $cargahoraria = $_POST["cargahoraria"];
    $valetransporte = $_POST["valetransporte"];
    $valordatarifa = $_POST["valordatarifa"];
    $descontotransporte = $_POST["descontotransporte"];
    $valordescontotrasnporte = $_POST["valordescontotrasnporte"];
    $valealimentacao = $_POST["valealimentacao"];
    $valorconsumido = $_POST["valorconsumido"];
    $desconto = $_POST["desconto"];
    $valordesconto = $_POST["valordesconto"];
    

    //clt
    if($clt=="sim"){
        $cltresposta = "O trabalhador é CLT";
    }
    else{
        $cltresposta =  "O trabalhador não é CLT";
    }
    
    //calcular jordana de tempo
    $jornadasemanal = $cargahoraria * 5;
    $jornadaanual = $cargahoraria * $diastrabalhados;

    //calculo fgts
    if ($clt == "sim") {
        $fgts = $salario * 0.08;
        $fgts_anual = $fgts * 12;
        $fgts_anual_formatado = number_format(round($fgts_anual, 2), 2, '.', '')." reais";
        $fgts_formatado = number_format(round($fgts, 2), 2, '.', '')." reais";

        
    }
    else if ($clt=="nao"){
        $fgts_formatado = "Não possui, pois não é clt";
        $fgts_anual_formatado = "Não possui, pois não é clt";
    }
    
    //calculo inss
    if ($clt == "sim") {
        if ($salario <= 1302.00) {
            $inss = $salario * 0.075 ;
        } else if ($salario <= 2571.29) {
            $inss = $salario * 0.09;
        } else if ($salario <= 3856.94) {
            $inss = $salario * 0.12;
        } else if ($salario <= 7507.49) {
            $inss = $salario * 0.14;
        } else {
            $inss = 7507.49 * 0.14; // o valor máximo para o cálculo do INSS é R$ 7507,49
        }
        
        $inss_anual = $inss * 12;
        $inss_formatado = number_format(round($inss, 2), 2, '.', '')." reais";
        $inss_anual_formatado = number_format(round($inss_anual, 2), 2, '.', '')." reais";
              
    }
    else if ($clt=="nao"){
        $inss_formatado = "Não possui isss, pois não é clt";
        $inss_anual_formatado = "Não possui isss, pois não é clt";
    }

    //calculo irrf      

    if ($clt == "sim") {

        $salarioBase = $salario  - $inss ;
        $aliquota;
        $deducao;
      
    if ($salarioBase <= 1903.98) {
            $aliquota = 0;
            $deducao = 0;
        } else if ($salarioBase <= 2826.65) {
            $aliquota = 0.075;
            $deducao = 142.80;
        } else if ($salarioBase <= 3751.05) {
            $aliquota = 0.15;
            $deducao = 354.80;
        } else if ($salarioBase <= 4664.68) {
            $aliquota = 0.225;
            $deducao = 636.13;
        } else {
            $aliquota = 0.275;
            $deducao = 869.36;
        }
   
        $irrf = ($salarioBase * $aliquota) - $deducao;
        $irrf_formatado = number_format(round($irrf, 2), 2, '.', '')." reais";
        $irrf_anual = $irrf * 12;
        $irrf_anual_formatado = number_format(round($irrf_anual, 2), 2, '.', '')." reais";

        if ($irrf <= 0) {
            $irrf = 0;
        }
        if ($irrf==0){
            $irrf_formatado = "Salário abaixo do valor mímimo";
        }
        if ($irrf_anual==0){
            $irrf_anual_formatado = "Salário abaixo do valor mímimo";
        }
    }
    if ($clt=="nao"){
    $irrf_formatado = "Não possui irrf, pois não é clt";
    $irrf_anual_formatado = "Não possui irrf, pois não é clt";
   }
    
                
        //calculo vale alimentação
        if ($valealimentacao == "sim"){
            $calculo_alimentacao = ($valorconsumido/100) * $salario;
            $valealimentacao_anual =  $calculo_alimentacao * 12;
            //formatar valores
            $calculo_alimentacao_formatado = number_format(round($calculo_alimentacao, 2), 2, '.', ''). " reais";
            $valealimentacao_anual_formatado = number_format(round($valealimentacao_anual, 2), 2, '.', '')." reais";
            if ($desconto == "sim"){
                $calculo_alimentacao_desconto = ($valordesconto/100) * $salario;
                $calculo_alimentacao_desconto_anual = $calculo_alimentacao_desconto * 12;
                //formatando valores 
                $calculo_alimentacao_desconto_formatado = number_format(round($calculo_alimentacao_desconto, 2), 2, '.', ''). " reais";
                $calculo_alimentacao_desconto_anual_formatado = number_format(round($calculo_alimentacao_desconto_anual, 2), 2, '.', ''). " reais";
            }
            else if ($desconto=="nao"){
                $calculo_alimentacao_desconto_formatado = "Não possui desconto no sálario";
                $calculo_alimentacao_desconto_anual_formatado = "Não possui desconto no sálario";
            }
        }
        else if ($valealimentacao =="nao"){
            $calculo_alimentacao_formatado = "Não possui vale alimentação";
            $valealimentacao_anual_formatado = "Não possui vale alimentação";
            $calculo_alimentacao_desconto_formatado = "Não possui vale alimentação";
            $calculo_alimentacao_desconto_anual = "Não possui vale alimentação";

        }
    
        //calculo vale transporte
        if ($valetransporte=="sim"){
            $calculo_transportes = ($valordatarifa*2) * $diastrabalhados;
            $calculo_transportes_mensal = ($calculo_transportes / 12); 
            //formatadndo valores
            $calculo_transportes_mensal_formatado = number_format(round($calculo_transportes_mensal, 2), 2, '.', '')." reais";
            $calculo_transportes_formatado = number_format(round($calculo_transportes, 2), 2, '.', '')." reais";

            if ($descontotransporte=="sim"){
                $calculo_transportes_desconto_anual = (($valordescontotrasnporte/100) * $salario) * 12  ;
                $calculo_transportes_desconto_mensal = ($valordescontotrasnporte/100) * $salario ;
                //formatando valores 
                $calculo_transportes_desconto_mensal_formatado = number_format(round($calculo_transportes_desconto_mensal, 2), 2, '.', '')." reais";
                $calculo_transportes_desconto_anual_formatado = number_format(round($calculo_transportes_desconto_anual, 2), 2, '.', '')." reais";
            }
            else if ($descontotransporte=="nao"){
                $calculo_transportes_desconto_anual_formatado = "Não possui desconto";
                $calculo_transportes_desconto_mensal_formatado = "Não possui desconto";
            }  
        }
        else if($valetransporte=="nao"){
            $calculo_transportes_mensal_formatado = "Não possui vale transporte";
            $calculo_transportes_formatado = "Não possui vale transporte";
            $calculo_transportes_desconto_anual_formatado = "Não possui vale transporte";
            $calculo_transportes_desconto_mensal_formatado = "Não possui vale transporte";
        }
        //calculo do salario Anual 
        $salario_anual = $salario * 12;
        //formatando valores
        $salario_anual_formatado = number_format(round($salario_anual, 2), 2, '.', '')." reais";

    ?>




    <section class="resultados">

        <div class="headerresultados">

            <img class="logoazapfy" src="Logo Azapfy.png" alt="">
            <h1 class="titulo">Resultados</h1>
            <h4 class="texto"> Abaixo segue o relatorio</h4>

        </div>

        <span class="titulo_resultados">Nome</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $nome ?> </span></div>
        </div>

        <span class="titulo_resultados">Cargo</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $cargo?> </span></div>
        </div>

        <span class="titulo_resultados">Ano de referência</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $ano?> </span></div>
        </div>

        <span class="titulo_resultados">CLT</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $cltresposta ?> </span></div>
        </div>

        <span class="titulo_resultados">Jornada anual</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $jornadaanual ?> horas </span></div>
        </div>

        <span class="titulo_resultados">Jornada semanal</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $jornadasemanal ?> horas </span></div>
        </div>

        <span class="titulo_resultados">Valor do fgts mensal</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $fgts_formatado?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do fgts no ano</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $fgts_anual_formatado ?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do inss mensal</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $inss_formatado ?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do inss anual</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $inss_anual_formatado ?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do irrf mensal</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $irrf_formatado ?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do irrf anual</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $irrf_anual_formatado ?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor do vale transporte mensal </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_transportes_mensal_formatado?> </span></div>
        </div>

        <span class="titulo_resultados">valor do vale transporte anual </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_transportes_formatado ?> </span></div>
        </div>

        <span class="titulo_resultados">Valor ser descontado no salario mensal (vale transporte)</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_transportes_desconto_mensal_formatado ?> </span></div>
        </div>

        <span class="titulo_resultados">Valor ser descontado no salario anual (vale transporte)</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_transportes_desconto_anual_formatado  ?> </span></div>
        </div>

        <span class="titulo_resultados">Valor do vale alimentação mensal  </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_alimentacao_formatado?></span></div>
        </div>

        <span class="titulo_resultados">Valor do vale alimentação anual </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $valealimentacao_anual_formatado ?></span></div>
        </div>

        <span class="titulo_resultados">Valor a ser descontado no salario mensal (vale alimentação) </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_alimentacao_desconto_formatado?>  </span></div>
        </div>

        <span class="titulo_resultados">Valor a ser descontado no salario anual (vale alimentação) </span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $calculo_alimentacao_desconto_anual_formatado ?> </span></div>
        </div>

        <span class="titulo_resultados">Valor do salario mensal</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $salario ?> </span></div>
        </div>
        
        <span class="titulo_resultados">Valor do salario bruto anual</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php echo $salario_anual_formatado ?> </span></div>
        </div>

        <span class="titulo_resultados">Valor do salario mensal liquido</span>
        <div class="resultados_tempo">
            <div class="Resultados"><span> <?php ?> </span></div>
        </div>

        <a class="button" href="https://365d-186-248-193-226.ngrok-free.app/calculoanual/resultados.php">Realizar um novo calculo</a>
        <a href="https://365d-186-248-193-226.ngrok-free.app/calculoanual/resultados.php" class="button" type="submit"> sair </a>


    </section>

    <style>

@import url("https://fonts.googleapis.com/css?family=Fredoka One");
@import url("https://fonts.googleapis.com/css?family=Inter");
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&family=Righteous&family=Sarala&display=swap');


*{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;

}

body {
    width: 100%;
    background: #ff7418;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
    margin-bottom: 40px;
}

.logoazapfy{
    margin-top: 40px;
    width: 250px;
}

.titulo{
margin-top: 15px;
    margin-left: 30px;
}
.texto{
    margin-left: 30px;
    margin-bottom: 25px;
}

.resultados{
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    background-color:white;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0, 0, 0.3);
    width: 550px;
    max-height: 100%;
    gap: 10px;
    
}

.resultados_tempo{
    margin-left: 30px;
    margin-bottom: 40px;
    background-color: white;
    border-radius: 10px;
    box-shadow: -2px 3px 5px rgba(255,116,24,1), 1px -2px 5px rgba(255,116,24,1);
    margin-right: 30px;
    width: 490px;
    height: 50px;
    
}

.titulo_resultados{
    margin-left: 30px;
   
}

.Resultados{
    color: black;
    margin: 10px;
}

.button{
   margin-left: 30px;
   color: black;
   margin-bottom: 10px; 
}



    </style>
</body>

</html>