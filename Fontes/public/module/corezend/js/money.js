/**
 * @author https://gist.github.com/gurgelrenan/11194847#file-converter_float_para_real-js
 * 
 * @param {type} valor
 * @returns {String}
 */
function converterFloatReal(valor) {
    var inteiro = null, decimal = null, c = null, j = null;
    var aux = new Array();
    valor = "" + valor;
    c = valor.indexOf(".", 0);
//encontrou o ponto na string
    if (c > 0) {
//separa as partes em inteiro e decimal
        inteiro = valor.substring(0, c);
        decimal = valor.substring(c + 1, valor.length);
    } else {
        inteiro = valor;
    }
//pega a parte inteiro de 3 em 3 partes
    for (j = inteiro.length, c = 0; j > 0; j -= 3, c++) {
        aux[c] = inteiro.substring(j - 3, j);
    }
//percorre a string acrescentando os pontos
    inteiro = "";
    for (c = aux.length - 1; c >= 0; c--) {
        inteiro += aux[c] + '.';
    }
//retirando o ultimo ponto e finalizando a parte inteiro
    inteiro = inteiro.substring(0, inteiro.length - 1);
    decimal = parseInt(decimal);
    if (isNaN(decimal)) {
        decimal = "00";
    } else {
        decimal = "" + decimal;
        if (decimal.length === 1) {
            decimal = "0" + decimal;
        }
    }
    valor = inteiro + "," + decimal;
    return valor;
} 