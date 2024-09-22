<?php 

//"espadas(♠), paus(♣), copas(♥) e ouros(♦)"

class Carta {
    private int $numero;
    private string $nome;
    private string $naipe;

    public function __construct(int $numero, string $nome, string $naipe){
        $this->numero = $numero;
        $this->nome = $nome;
        $this->naipe = $naipe;
    }

    public function getNumero(): int{
        return $this->numero;
    }

    public function setNumero(int $numero): self{
        $this->numero = $numero;

        return $this;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setNome(string $nome): self{
        $this->nome = $nome;

        return $this;
    }
    
    public function getNaipe(): string{
        return $this->naipe;
    }

    
    public function setNaipe(string $naipe): self{
        $this->naipe = $naipe;

        return $this;
    }

}

$baralhoCompleto = [];
$naipes = ["Espadas", "Copas", "Ouros", "Paus"];
$nomes = [
    1 => "Ás", 2 => "Dois", 3 => "Três", 4 => "Quatro", 5 => "Cinco", 
    6 => "Seis", 7 => "Sete",8 => "Oito", 9 => "Nove", 10 => "Dez", 
    11 => "Valete", 12 => "Dama", 13 => "Rei"
];

foreach ($naipes as $naipe) {
    foreach ($nomes as $numero => $nome) {
        $baralhoCompleto[] = new Carta($numero, $nome, $naipe);
    }
}

do {
    echo "\n-----------MENU-----------\n";
    echo "1- Modo fácil (10 cartas - adivinhar somente uma!)\n";
    echo "2- Modo médio(21 cartas - adivinhar três..)\n";
    echo "3- Modo super hardcore (O BARALHO TODO!!! - ADIVINHAR 7 😰😰😰)\n";
    echo "0- Sair\n";

    $opcao = readline("Informe a opção: ");
    echo "\n"; //Apenas para executar uma quebra de linha

    switch($opcao) {
        
        case 1:

            $qtdCartas = 10;
            $qtdAcertos = 1;
            echo "Voce escolheu o modo facil!! - Boa sorte 🙏\n";

            break;
        case 2: 

            $qtdCartas = 21;
            $qtdAcertos = 3;
            echo "Voce escolheu o modo medio.. - Boa sorte 🤝\n";

            break;
        case 3:

            $qtdCartas = 52;
            $qtdAcertos = 7;
            echo "Voce escolheu o modo.. SUPER HARDCORE??? - Deus lhe guarde..\n";

            break;
        case 0:
            echo "Programa encerrando!\n";
            break;

        default:
            echo "Opção Inválida! Escolha uma opcao valida.\n";
            break;

    }
    
    $cartas = array_rand($baralhoCompleto, $qtdCartas);
    $baralhoDoModo = [];

    //aqui iremos criar o baralho para cada modo - facil(10 cartas), medio (21 cartas), super hardcore (o baralho todo)

    foreach ($cartas as $qtd) {
        // array_push($baralhoDoModo, $qtd); nao deu certo 0-0
        $baralhoDoModo[] = $baralhoCompleto[$qtd];
    }


    $acertosNecessarios = $qtdAcertos;
    $acertos = 0;

    // print_r($baralhoDoModo);

    while ($acertos < $acertosNecessarios) {
        $cartaSorteada = $baralhoDoModo[array_rand($baralhoDoModo)];
        $tentativas = 0; // servira para dizer as dicas e/ou dar a possibilidade de desistencia ao jogador

        echo "\nBoa sorte tentando adivinhar a(s) carta(s) escolhida(s)!!\n";
        foreach ($baralhoDoModo as $i => $carta) {
            echo $i + 1 . ". " . $carta->getNome() . " de " . $carta->getNaipe() . "\n";
        }

        while (true) {
            $escolha = (int) readline("Digite o numero da carta que voce acha que foi sorteada [0 para desistir]: ");
            $tentativas++;

            if ($escolha == 0){
                echo "Desistindo..\n";
                break 2;
            }

            if ($escolha < 1 || $escolha > count($baralhoDoModo)) {
                echo "Escolha invalida!! Digite um numero valido.\n";

                continue; //dar a oportunidade de refazer a escolha
            }

            $cartaEscolhida = $baralhoDoModo[$escolha - 1]; //pq escolha - 1? pq a carta esta como $i + 1 e isso nao mostra a sua real posicao no array entao para o usuario conseguir acessar com exatidao, subtraimos um para que seja a real posicao no array

            if ($cartaEscolhida->getNumero() === $cartaSorteada->getNumero() && $cartaEscolhida->getNaipe() === $cartaSorteada->getNaipe()) {
                echo "\nVocê acertou uma carta: " . $cartaSorteada->getNome() . " de " . $cartaSorteada->getNaipe() . "!!\n";
                $acertos++;
                echo "Você já acertou $acertos de $acertosNecessarios cartas!\n";

                break; // rodada nova
            } else {
                echo "Errado! Tente novamente.\n";
                if ($tentativas > 3) {

                    $dica = (int)readline("Parece que voce esta com dificuldades.. Quer uma dica? [Digite 0 para sim | Digite 1 para nao] ");

                    if ($dica == 0) {
                        echo "Dica: O naipe da carta sorteada é " . $cartaSorteada->getNaipe() . ".\n";
                        $tentativas = 0; //para reiniciar e nao pedir dicas o tempo todo.
                    } 
                }

                // dps de 6 erros o usuario tem a opcao de desistir
                if ($tentativas == 6) {
                    $resposta = readline("Você fez 6 tentativas! Deseja desistir? (Digite 'sim' para desistir ou 'não' para continuar): ");
                    if (strtolower($resposta) === 'sim') { //strtolower serve para deixar todos os caracteres da string em minusculo, assim poupando tempo de criar todas as possiveis possibilidades de sim - Sim, SIM, sIm, SIm, etc..
                        echo "Você desistiu do jogo!\n";
                        break 2; //Sai do jogo completamente
                    }
                }
            }


        }
    }

    if ($acertos == $acertosNecessarios) {
        echo "\nVoce acertou todas as cartas!! -Se quiser tentar outro modo fique a vontade e boa sorte!\n";
        break;
    }


} while($opcao != 0);
