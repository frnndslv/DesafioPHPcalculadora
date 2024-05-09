<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Capbara</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calculadora Capibara">
        <h2>Calculadora Capibara</h2>
        <form method="post" action="">
            <input type="text" name="num1" placeholder="Número 1">
                
                <select name="operation">
                    <option value="">Selecione a operação</option>
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="!">!</option>
                    <option value="^">^</option>
                </select>
                <input type="text" name="num2" placeholder="Número 2">

                <input type="submit" id="calcular" name="calcular" value="Calcular">
                <input type="submit" id="historico" name="historico" value="Histórico">
                <input type="submit" id="m" name="m" value="M">
                <input type="submit" id="salvar" name="salvar" value="Salvar">
                <input type="submit" id="limpar" name="limpar" value="Limpar Histórico">
        </form>
        
        <?php

            
            if ($_SERVER["REQUEST_METHOD"] == "POST"  ) {
                session_start();
                $array = array();
                $_SESSION['historico'] = $_SESSION['historico'] ?? $array;

                $num1 = $_POST["num1"];
                $num2 = $_POST["num2"];
                $operation = $_POST["operation"];
                $result = "";

                if(array_key_exists('calcular',$_POST)){
                    if($num1 && $num2&& $operation){
                        switch ($operation) {
                            case '+':
                                $result = $num1 + $num2;
                                $valores = $num1. ' + ' .$num2. ' = ' .$result;
                                array_push($_SESSION['historico'], $valores);
                                break;
                            case '-':
                                $result = $num1 - $num2;
                                $valores = $num1. ' - ' .$num2. ' = ' .$result;
                                array_push($_SESSION['historico'], $valores);
                                break;
                            case '*':
                                $result = $num1 * $num2;
                                $valores = $num1. ' * ' .$num2. ' = ' .$result;
                                array_push($_SESSION['historico'], $valores);
                                break;
                            case '/':
                                if ($num2 == 0) {
                                    $result = "Erro! Divisão por zero.";
                                } else {
                                    $result = $num1 / $num2;
                                    $valores = $num1. ' / ' .$num2. ' = ' .$result;
                                    array_push($_SESSION['historico'], $valores);
                                }
                                break;
                            case '!':
                                $result = factorial($num1);
                                $valores = '!' . $num1. ' = ' .$result;
                                array_push($_SESSION['historico'], $valores);
                                break;
                            case '^':
                                $result = pow($num1, $num2);
                                $valores = $num1. ' ^ ' .$num2. ' = ' .$result;
                                array_push($_SESSION['historico'], $valores);
                                break;
                            default:
                                $result = "Operação inválida.";
                                break;
                        }
    
                        echo "<p>  $num1 $operation $num2 = $result</p>";
                    }else {
                        echo "<p> Selecione os valores </p>";
                    }

                }
                

                if(array_key_exists('historico',$_POST)){
                    historico();
                }

                if(array_key_exists('limpar',$_POST)){
                    clearMemory();
                }
            
                if(array_key_exists('m',$_POST)){
                    salvandoDadoTela();
        
                }if(array_key_exists('salvar',$_POST)){
                    save();
    
                }
                 
                
            }


            function historico() {
                if($_SESSION['historico']){
                    forEach($_SESSION['historico'] as $key=>$value){
                        echo  "<div class='historico'> ''.$value.</div></br>";
                    }
                }
            }

            function salvandoDadoTela()
        {


            // Verifica se já existe um flag indicando que os dados foram salvos
            if (isset($_SESSION['save_tela'])) {
                // Se os dados já foram salvos, exibe-os
                echo "<p>Dados Salvos: " . $_SESSION['save_tela']['num1'] . " " . $_SESSION['save_tela']['operation'] . " " . $_SESSION['save_tela']['num2'] . "</p>";
                // Remove o flag para que os dados não sejam exibidos novamente no próximo clique
                unset($_SESSION['save_tela']);
            } else {
                // Se os dados ainda não foram salvos, salva-os
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                $operation = $_POST['operation'];

                if (!empty($num1) && !empty($num2) && !empty($operation)) {
                    $_SESSION['save_tela'] = [
                        'num1' => $num1,
                        'operation' => $operation,
                        'num2' => $num2
                    ];
                }
            }
        }
        function save()
        {


            // Verifica se já existe um flag indicando que os dados foram salvos
            if (isset($_SESSION['salvar'])) {
                // Se os dados já foram salvos, exibe-os
                echo "<p>Dados Salvos: " . $_SESSION['salvar']['num1'] . " " . $_SESSION['salvar']['operation'] . " " . $_SESSION['salvar']['num2'] . "</p>";
                // Remove o flag para que os dados não sejam exibidos novamente no próximo clique
                unset($_SESSION['salvar']);
            } else {
                // Se os dados ainda não foram salvos, salva-os
                $num1 = $_POST['num1'];
                $num2 = $_POST['num2'];
                $operation = $_POST['operation'];

                if (!empty($num1) && !empty($num2) && !empty($operation)) {
                    $_SESSION['salvar'] = [
                        'num1' => $num1,
                        'operation' => $operation,
                        'num2' => $num2
                    ];
                    echo "<p>Dados salvos.</p>";
                } else {
                    echo "<p>Não há dados para salvar.</p>";
                }
            }
        }
        

        // Função para limpar a sessão de memória
        
        // Verifica se o botão de memória foi pressionado


        

        function factorial($n) {
            if ($n <= 1) {
                    return 1;
            } else {
                    return $n * factorial($n - 1);
            }
        }

    
        function clearMemory() {
            unset($_SESSION['historico']);
        }
            

        ?>
    </div>
</body>
</html>