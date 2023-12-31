<?php

    const NUMEROMAXMEGA = 20; //settadas para a Mega, de qual o valor minimo e maximo que se pode jogar
    const NUMEROMINMEGA = 6;  
    const QUANTIDADEDENUMEROSMEGA = 60; //quant de numeros 

    const NUMEROMAXQUINA = 15; //settadas para a Quina, de qual o valor minimo e maximo que se pode jogar
    const NUMEROMINQUINA = 5;
    const QUANTIDADEDENUMEROSQUINA = 80; //quant de numeros

    const NUMEROMAXLOTOMANIA = 50; //settadas para a Lotomania, de qual o valor minimo e maximo que se pode jogar
    const NUMEROMINLOTOMANIA = 50;
    const QUANTIDADEDENUMEROSLOTOMANIA = 100; //quant de numeros

    const NUMEROMAXLOTOFACIL = 20;//settadas para a lotofacil, de qual o valor minimo e maximo que se pode jogar
    const NUMEROMINLOTOFACIL = 15;
    const QUANTIDADEDENUMEROSLOTOFACIL = 25; //quant de numeros

    print ("Escolha o jogo que você gostaria de jogar!\n1-Mega-Sena\n2-Quina\n3-Lotomania\n4-Lotofácil\n");
    $jogoEscolhido = readline();

    ParaosJogos($jogoEscolhido, obterNumeroMinimo($jogoEscolhido), obterNumeroMaximo($jogoEscolhido));
  
    function ParaosJogos($jogoEscolhido, $numMinimo, $numMaximo)
    {
        print("Quantas apostas você deseja fazer?\n");
        $numsApostas = readline();
        for ($i = $numsApostas; $i > 0; $i--) 
        {   
            print("Você deseja informar os números, ou que o programa os gere para você?\n1-Quero informar eu mesmo\n2-Surpresinha!\n");
            $opcaoDeAposta = readline();
            if ($opcaoDeAposta == 1) 
            {
                $numsEscolhidos = obterNumerosEscolhidos($jogoEscolhido);
                $numsSorteados = sortearNumeros($jogoEscolhido,$numMaximo,$numMinimo);
                JogoLoteria($numsEscolhidos, $numsSorteados, $jogoEscolhido);
                sort($numsEscolhidos);
                $quantidadeNumeros = count($numsEscolhidos);
                $preco = preco($jogoEscolhido,$quantidadeNumeros);
                print "O preço que você pagará pela sua aposta é de R$" . $preco . "\n";
                print "Os números escolhidos são: ". implode(", ", $numsEscolhidos) . "\n";
                print "Os números premiados são: " . implode(", ", $numsSorteados) . "\n";
                $premio = JogoLoteria($numsEscolhidos, $numsSorteados, $jogoEscolhido);
                print "Seu prêmio é: " . $premio . "\n";
            }
            else if ($opcaoDeAposta == 2)
            {
                print("Quantos numeros você deseja apostar?\n");
                $quantidadeNumeros = readline();
                if ($quantidadeNumeros < $numMinimo || $quantidadeNumeros > $numMaximo) 
                {
                    print "Número incorreto de dezenas! Informe novamente, você deve escolher entre 6 e 20 no jogo da Mega!\n";
                    while ($quantidadeNumeros < $numMinimo || $quantidadeNumeros > $numMaximo) 
                    {
                        print("Quantos números você deseja apostar?\n");
                        $quantidadeNumeros = readline();
                    }
                }
                $numsEscolhidos = sortearNumeros($jogoEscolhido, $numMaximo, $quantidadeNumeros);
                $numsSorteados = sortearNumeros($jogoEscolhido, $numMaximo, $numMinimo);
                $quantidadeNumeros = count($numsEscolhidos);
                $preco = preco($jogoEscolhido,$quantidadeNumeros);
                print "O preço que você pagará pela sua aposta é de R$" . $preco . "\n";
                JogoLoteria($numsEscolhidos, $numsSorteados, $jogoEscolhido);
                sort($numsEscolhidos);
                print "Os números escolhidos são: " . implode(", ", $numsEscolhidos) . "\n";
                print "Os números premiados são: " . implode(", ", $numsSorteados) . "\n";
                $premio = JogoLoteria($numsEscolhidos, $numsSorteados, $jogoEscolhido);
                print "Seu prêmio é: " . $premio . "\n";
            }
            else if ($opcaoDeAposta != 1 && $opcaoDeAposta != 2) 
            {
                print"Opcao invalida.\n";
                while ($opcaoDeAposta != 1 && $opcaoDeAposta != 2) 
                {
                    print("Você deseja informar os números, ou que o programa os gere para você?\n1-Quero informar eu mesmo\n2-Surpresinha!\n");
                    $opcaoDeAposta = readline();
                }
            }
        } 
    } 

    function JogoLoteria($numsEscolhidos, $numsSorteados, $jogoEscolhido) 
    {
        $premio = "Nenhum prêmio :(";

        //Deixa os numeros bonitinhos
        sort($numsEscolhidos);
        sort($numsSorteados);
        
        //Compara 
        $numsIguais = array_intersect($numsEscolhidos, $numsSorteados);
        
        //Verifica quantos números iguais
        $numsIguaisCount = count($numsIguais);
        
        //Prêmio!
        switch ($jogoEscolhido) 
        {
            case 1: // Mega-Sena
                if ($numsIguaisCount == 4) 
                {
                    $premio = 'Quadra';
                } 
                elseif ($numsIguaisCount == 5) 
                {
                    $premio = 'Quina';
                } 
                elseif ($numsIguaisCount == 6) 
                {
                    $premio = 'Sena, parabéns. Novo(a) ricasso(a)!!!!';
                }
                break;
            case 2: // Quina
                if ($numsIguaisCount == 5) 
                {
                    $premio = 'Quina, parabéns!';
                }
                break;
            case 3: // Lotomania
                if ($numsIguaisCount == 50) 
                {
                    $premio = '50 acertos';
                }
                break;
            case 4: // Lotofácil
                if ($numsIguaisCount >= 15 && $numsIguaisCount <= 20) 
                {
                    $premio = $numsIguaisCount . ' acertos, parabéns!';
                }
                break;
            default:
                $premio = 'Jogo não existe';
                break;
        }
    
        return $premio;
    }

    function sortearNumeros($minimo, $maximo, $quantidade) 
    {
        $numsSorteados = [];
        
        while (count($numsSorteados) < $quantidade) 
        {
            $numAleatorio = rand($minimo, $maximo);

            if ($numAleatorio >= $minimo && $numAleatorio <= $maximo) //so uma garatia
            {
                if (!in_array($numAleatorio, $numsSorteados)) //pra nao duplicar <3, penei nisso, viu? ass:Sarah
                {
                    $numsSorteados[] = $numAleatorio;
                }
            }
        }
        
        sort($numsSorteados);

        return $numsSorteados;
    }

    function obterNumerosEscolhidos($jogoEscolhido)
    {
        $minDezenas = obterNumeroMinimo($jogoEscolhido);
        $maxDezenas = obterNumeroMaximo($jogoEscolhido);
        $numMinimoJogo = 0;
        $numMaximoJogo = 0;

        if ($jogoEscolhido == 1)   
        {
            $numMinimoJogo = 1;
            $numMaximoJogo = 60;
        } elseif ($jogoEscolhido == 2) 
        {
            $numMinimoJogo = 1;
            $numMaximoJogo = 80;
        } elseif ($jogoEscolhido == 3) 
        {
            $numMinimoJogo = 1;
            $numMaximoJogo = 100;
        } elseif ($jogoEscolhido == 4) 
        {
            $numMinimoJogo = 1;
            $numMaximoJogo = 25;
        }

        do 
        {
            $entradaUsuarioEscolha = readline("Informe os números escolhidos(separados por vírgula): \n");
            $numsEscolhidos = explode(",", $entradaUsuarioEscolha);
            $numsEscolhidos = array_map('intval', $numsEscolhidos);
            $numsEscolhidos = array_unique($numsEscolhidos);
            $numsEscolhidos = array_filter($numsEscolhidos, function ($num) use ($numMinimoJogo, $numMaximoJogo) 
            {
                return $num >= $numMinimoJogo && $num <= $numMaximoJogo;
            });
            $numsEscolhidosQuantidade = count($numsEscolhidos);

            // Verifica se a quantidade de números está correta
            if ($numsEscolhidosQuantidade < $minDezenas || $numsEscolhidosQuantidade > $maxDezenas) 
            {
                print "\nAlguma coisa deu errado!\nVerifique as seguintes opções\nVerifique se você digitou o número correto de dezenas, nesse jogo, você pode digitar entre " . $minDezenas . "e " . $maxDezenas . "\nVerifique também, se sua aplicação não tem números repetidos\n";
                continue;
            }

            // Verifica se não há números repetidos
            if (count(array_intersect_assoc($numsEscolhidos, array_unique($numsEscolhidos))) !== $numsEscolhidosQuantidade) 
            {
                print "\nAlguma coisa deu errado!\nVerifique as seguintes opções\nVerifique se você digitou o número correto de dezenas, nesse jogo, você pode digitar entre " . $minDezenas . "e " . $maxDezenas . "\nVerifique também, se sua aplicação não tem números repetidos\n";
                continue;
            }

            // Se chegou até aqui, os números estão certinhos, gracas
            break;
        } 
        while (true);

        return $numsEscolhidos;
}

    function obterNumeroMaximo($jogoEscolhido)
    {
        switch ($jogoEscolhido) 
        {
            case 1:
                return NUMEROMAXMEGA;
            case 2:
                return NUMEROMAXQUINA;
            case 3:
                return NUMEROMAXLOTOMANIA;
            case 4:
                return NUMEROMAXLOTOFACIL;
            default:
                return 0;
        }
    }

    function obterNumeroMinimo($jogoEscolhido)
    {
        switch ($jogoEscolhido) 
        {
            case 1:
                return NUMEROMINMEGA;
            case 2:
                return NUMEROMINQUINA;
            case 3:
                return NUMEROMINLOTOMANIA;
            case 4:
                return NUMEROMINLOTOFACIL;
            default:
                return 0;
        }
    }

    function preco($jogoEscolhido, $quantidadeNumeros)
    {
        $precos = 
        [
            1 => [6  => '6,00', 7  => '35,00', 8  => '140,00', 9  => '420,00', 10 => '1.050,00', 11 => '2.310,00', 12 => '4.620,00', 13 => '8.580,00', 14 => '15.015,00', 15 => '25.025,00', 16 => '40.040,00', 17 => '61.880,00', 18 => '92.820,00', 19 => '135.660,00', 20 => '193.800,00', ],
            2 => [5  => '2,50', 6  => '15,00', 7  => '52,50', 8  => '140,00', 9  => '315,00', 10 => '630,00', 11 => '1.155,00', 12 => '1.980,00', 13 => '3.217,00', 14 => '5.005,00', 15 => '7.507,00',],
            3 => [50 => '3,00',],
            4 => [15 => '3,00', 16 => '48,00', 17 => '408,00', 18 => '2.448,00', 19 => '11.628,00', 20 => '46.512,00',],
        ];

        return $precos[$jogoEscolhido][$quantidadeNumeros] ?? 'Preço não encontrado'; //quando eu descobri o "??", meu cerebro explodiu, isso aqui deixou o código 1.000.000 de vezes mais bonito
    }

exit;
