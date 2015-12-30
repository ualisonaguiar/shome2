<?php

namespace CoreZend\Util;

use CoreZend\Util\String;

/**
 * Classe responsavel no tratamento, formatacao e validacao de dados que utilizam mascara.
 *
 * @package InepZend
 * @subpackage Util
 */
class Format
{

    /**
     * Metodo responsavel em verificar se o parametro eh um CPF com mascara.
     *
     * @example \CoreZend\Util\Format::isCpf('173.575.278-91');
     *
     * @param string $strNuCpf
     * @return boolean
     *
     * @assert ('173.575.278-91') === true
     * @assert ('17357527891') !== true
     * @assert ('173575278-91') !== true
     * @assert ('173.57527891') !== true
     * @assert ('abc.def.ghi-91') !== true
     */
    public static function isCpf($strNuCpf)
    {
        if ((strpos($strNuCpf, '.') === false) || (strpos($strNuCpf, '-') === false))
            return false;
        return (bool) preg_match('/^([0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}|[0-9]{11})$/', $strNuCpf);
    }

    /**
     * Metodo responsavel em verificar se o parametro eh um CNPJ com ou sem mascara.
     *
     * @example \CoreZend\Util\Format::isCnpj('56.167.101/0001-06');
     *
     * @param string $strNuCnpj
     * @return boolean
     *
     * @assert ('56.167.101/0001-06') === true
     * @assert ('56167101000106') !== true
     * @assert ('56.167101000106') !== true
     * @assert ('56167101/000106') !== true
     * @assert ('561671010001-06') !== true
     * @assert ('ab.cde.fgh/ijkl-06') !== true
     */
    public static function isCnpj($strNuCnpj)
    {
        if ((strpos($strNuCnpj, '.') === false) || (strpos($strNuCnpj, '/') === false) || (strpos($strNuCnpj, '-') === false))
            return false;
        return (bool) preg_match('/^([0-9]{2}\.[0-9]{3}.[0-9]{3}\/[0-9]{4}\-[0-9]{2}|[0-9]{14})$/', $strNuCnpj);
    }

    /**
     * Metodo responsavel em formatar uma string nas mascaras de CPF ou CNPJ.
     *
     * @example \CoreZend\Util\Format::formatCpfCnpj('17357527891'); <br /> \CoreZend\Util\Format::formatCpfCnpj('56167101000106');
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('17357527891') === '173.575.278-91'
     * @assert ('56167101000106') === '56.167.101/0001-06'
     *
     * @assert ('1735752789') === '1735752789'
     * @assert ('5616710100010') === '5616710100010'
     * @assert ('123456abcd') === '123456abcd'
     * @assert ('56167101000106120') === '56167101000106120'
     * @assert ('173575278912') === '173575278912'
     * @assert ('abcdefghijkl06') === 'abcdefghijkl06'
     * @TODO assert ('abcdefghijkl06') === null | Realizar chamada isCpf e isCnpj no inicio do metodo.
     */
    public static function formatCpfCnpj($strValue)
    {
        if (!empty($strValue)) {
            $strValueEdited = str_replace(array('.', ',', '-', '/', '\\', ' '), '', (string) $strValue);
            $intLenght = strlen($strValueEdited);
            if (is_numeric($strValueEdited)) {
                $arrValue = array();
                if ($intLenght < 11)
                    $strValueEdited = str_pad($strValueEdited, 11, '0', STR_PAD_LEFT);
                if ($intLenght == 11) {
                    array_push($arrValue, substr($strValueEdited, 0, 3));
                    array_push($arrValue, substr($strValueEdited, 3, 3));
                    array_push($arrValue, substr($strValueEdited, 6, 3));
                    array_push($arrValue, substr($strValueEdited, 9, 2));
                    $strValue = $arrValue[0] . '.' . $arrValue[1] . '.' . $arrValue[2] . '-' . $arrValue[3];
                } elseif ($intLenght == 14) {
                    array_push($arrValue, substr($strValueEdited, 0, 2));
                    array_push($arrValue, substr($strValueEdited, 2, 3));
                    array_push($arrValue, substr($strValueEdited, 5, 3));
                    array_push($arrValue, substr($strValueEdited, 8, 4));
                    array_push($arrValue, substr($strValueEdited, 12, 2));
                    $strValue = $arrValue[0] . '.' . $arrValue[1] . '.' . $arrValue[2] . '/' . $arrValue[3] . '-' . $arrValue[4];
                }
            }
        }
        return $strValue;
    }

    /**
     * Metodo responsavel em retirar as mascaras de CPF ou CNPJ uma string.
     *
     * @example \CoreZend\Util\Format::clearCpfCnpj('173.575.278-91'); <br /> \CoreZend\Util\Format::clearCpfCnpj('56.167.101/0001-06');
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('173.575.278-91') === '17357527891'
     * @assert ('56.167.101/0001-06') === '56167101000106'
     */
    public static function clearCpfCnpj($strValue)
    {
        $strValue = str_replace(array('.', ',', '-', '/', '\\', ' '), '', (string) $strValue);
        if (is_numeric($strValue))
            $strValue = str_pad($strValue, ((strlen($strValue) <= 11) ? 11 : 14), '0', STR_PAD_LEFT);
        return $strValue;
    }

    /**
     * Metodo responsavel em Formatar uma string nas mascaras de PIS/PASEP.
     *
     * @example \CoreZend\Util\Format::formatPisPasep('12532227364');
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('12532227364') === '125.32227.36-4'
     * @assert ('125322273645') === '125322273645'
     * @assert ('125322273') === '125322273'
     */
    public static function formatPisPasep($strValue)
    {
        if (!empty($strValue)) {
            $intLenght = strlen($strValue);
            $arrValue = array();
            if ($intLenght == 11) {
                array_push($arrValue, substr($strValue, 0, 3));
                array_push($arrValue, substr($strValue, 3, 5));
                array_push($arrValue, substr($strValue, 8, 2));
                array_push($arrValue, substr($strValue, 10, 1));
                $strValue = $arrValue[0] . '.' . $arrValue[1] . '.' . $arrValue[2] . '-' . $arrValue[3];
            }
        }
        return $strValue;
    }

    /**
     * Metodo responsavel em formatar uma string nas mascaras de CEP.
     *
     * @example \CoreZend\Util\Format::formatCep('70610404');
     *
     * @param string $strCep
     * @return string
     *
     * @assert ('70610404') === '70610-404'
     * @assert ('7061040') === '07061-040'
     * @assert ('7061040412') === '7061040412'
     * @assert ('abcdefgh') === 'abcdefgh'
     */
    public static function formatCep($strCep)
    {
        if (is_numeric($strCep)) {
            if (strlen($strCep) < 8)
                $strCep = str_pad($strCep, 8, '0', STR_PAD_LEFT);
            if (strlen($strCep) == 8)
                $strCep = substr($strCep, 0, 5) . '-' . substr($strCep, 5, 8);
        }
        return $strCep;
    }

    /**
     * Metodo responsavel em formatar uma string nas mascaras de PERCENTUAL.
     *
     * @example \CoreZend\Util\Format::formatPercent('28'); <br /> \CoreZend\Util\Format::formatPercent('28', 3); <br /> \CoreZend\Util\Format::formatPercent('2.58'); <br /> \CoreZend\Util\Format::formatPercent('2.58', 3); <br /> \CoreZend\Util\Format::formatPercent('99.958');
     *
     * @param string $strPercent
     * @param integer $intMaxDecimal
     * @return string
     *
     * @assert ('-1') === '-1,00%'
     * @assert ('28') === '28,00%'
     * @assert ('28', 3) === '28,000%'
     * @assert ('28', 10) === '28,0000000000%'
     * @assert ('2.58') === '2,58%'
     * @assert ('2.58', 3) === '2,580%'
     * @assert ('99.9589') === '99,96%'
     * @assert ('99.9589', 3) === '99,959%'
     *
     * @assert ('teste') === '0,00%'
     * @assert ('teste', 3) === '0,000%'
     * @assert ('teste', 10) === '0,0000000000%'
     */
    public static function formatPercent($strPercent, $intMaxDecimal = 2)
    {
        return number_format((float) $strPercent, $intMaxDecimal, ',', '.') . '%';
    }

    /**
     * Metodo responsavel em formatar uma string nas mascaras de HORA.
     *
     * @example \CoreZend\Util\Format::formatTime('15:22:50');
     *
     * @param string $strTime
     * @param integer $strFormat
     * @return string
     *
     * @assert ('15:22:50') === '15:22:50'
     *
     * @TODO assert ('152250') === '15:22:50'
     * @TODO assert (':22:50') === null'
     * @TODO assert ('::50') === null
     * @TODO assert ('::') === null
     * @TODO assert ('Yes:22:50') === null
     * @TODO assert ('Yes:22:50') === null
     * @TODO assert ('Yes To Format') === null
     */
    public static function formatTime($strTime, $strFormat = 'H:i:s')
    {
        if (empty($strTime))
            return;
        $arrTime = explode(':', $strTime);
        $intHour = (count($arrTime) >= 1) ? $arrTime[0] : null;
        $intMin = (count($arrTime) >= 2) ? $arrTime[1] : null;
        $intSec = (count($arrTime) >= 3) ? $arrTime[2] : null;
        return str_ireplace(array('H', 'i', 's'), array((string) $intHour, (string) $intMin, (string) $intSec), $strFormat);
    }

    /**
     * Metodo responsavel em formatar uma string nas mascaras de TELEFONE.
     *
     * @example \CoreZend\Util\Format::formatPhone('1111111111'); <br /> \CoreZend\Util\Format::formatPhone('22222222'); <br /> \CoreZend\Util\Format::formatPhone('12345123');
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('02345123456') === str_replace('&#32;', ' ', '(023)&#32;4512-3456')
     * @assert ('1234512345') === str_replace('&#32;', ' ', '(12)&#32;3451-2345')
     * @assert ('12345123') === '1234-5123'
     * @assert ('1234512') === '1234512'
     * @assert ('(11) 1111-1111') === str_replace('&#32;', ' ', '(11)&#32;1111-1111')
     */
    public static function formatPhone($strValue)
    {
        if (!String::isNullEmpty($strValue)) {
            if (strlen($strValue) == 11) {
                $strPattern = '/(\d{3})(\d{4})(\d*)/';
                $strValue = preg_replace($strPattern, '($1) $2-$3', $strValue);
            } else if (strlen($strValue) == 10) {
                $strPattern = '/(\d{2})(\d{4})(\d*)/';
                $strValue = preg_replace($strPattern, '($1) $2-$3', $strValue);
            } else if (strlen($strValue) == 8) {
                $strPattern = '/(\d{4})(\d*)/';
                $strValue = preg_replace($strPattern, '$1-$2', $strValue);
            }
        }
        return $strValue;
    }

    /**
     * Metodo responsavel em connverter do formato de DINHEIRO para double.
     *
     * @example \CoreZend\Util\Format::moneyToFloat('R$ 1.234,56');
     *
     * @param string $strMoneyValue
     * @return float
     *
     * @assert ('R$ 1.234,56') == '1234.56'
     * @assert ('R$ 22.000.000,00') == '22000000'
     * @assert ('R$ 22.000.000,95') == '22000000.95'
     * @assert ('R$ 145.998.000.000,95') == '145998000000.95'
     * @assert ('R$ 500,05') == '500.05'
     *
     * @TODO assert ('R$ 500,996') == null
     * @TODO assert ('R$ 500,A9') == null
     */
    public static function moneyToFloat($strMoneyValue)
    {
        $strMoneyValue = str_replace(array('R$ ', ' ', '.'), '', $strMoneyValue);
        $strMoneyValue = str_replace(',', '.', $strMoneyValue);
        $floMoneyValue = (double) $strMoneyValue;
        return $floMoneyValue;
    }

    /**
     * Metodo responsavel em converter o numero double para o formato de DINHEIRO.
     *
     * @example \CoreZend\Util\Format::moneyToFloat('1234.56');
     *
     * @param float $floValue
     * @param boolean $booCifrao
     * @return string
     *
     * @assert ('1234.56') == 'R$ 1.234,56'
     * @assert ('1234.56', false) == '1.234,56'
     *
     * @assert ('22000000') == 'R$ 22.000.000,00'
     * @assert ('22000000', false) == '22.000.000,00'
     *
     * @assert ('22000000.95') == 'R$ 22.000.000,95'
     * @assert ('22000000.95', false) == '22.000.000,95'
     *
     * @assert ('145998000000.95') == 'R$ 145.998.000.000,95'
     * @assert ('145998000000.95', false) == '145.998.000.000,95'
     *
     * @assert ('500.05') == 'R$ 500,05'
     * @assert ('500.05', false) == '500,05'
     *
     * @TODO assert ('500.996') == null
     * @TODO assert ('500.996', false) == null
     * @TODO assert ('500.A9') == null
     * @TODO assert ('500.A9', false) == null
     */
    public static function floatToMoney($floValue, $booCifrao = true)
    {
        $finalZero = false;
        $tamanhoString = strlen($floValue);
        if (0 == $floValue[$tamanhoString - 1] && 0 != $floValue[$tamanhoString - 2]) {
            $finalZero = true;
        }
        
        $floValue = round($floValue, 2);
        $floValue = (double) $floValue;
        $strValue = (string) $floValue;
        if (strpos($strValue, '.') === false)
            $strValue = $strValue . '.00';
        $arrValue = explode('.', $strValue);
        $strInteiro = $arrValue[0];
        $strDecimal = $arrValue[1];
        $strInteiroMascarado = '';
        for ($intLetra = 0; $intLetra < strlen($strInteiro); ++$intLetra) {
            $intLetraPos = (strlen($strInteiro) - 1) - $intLetra;
            if (($intLetra > 0) && ($intLetra % 3 == 0))
                $strInteiroMascarado = '.' . $strInteiroMascarado;
            $strInteiroMascarado = $strInteiro[$intLetraPos] . $strInteiroMascarado;
        }
        $strNumero = $strInteiroMascarado . ',' . $strDecimal;
        if ($booCifrao)
            $strNumero = 'R$ ' . $strNumero;
        if ($finalZero) {
            $strNumero .= 0;
        }
        return $strNumero;
    }

    /**
     * Metodo responsavel em colocar qualquer mascara.
     *
     * @example \CoreZend\Util\Format::setMask('12345678911', '999.999.999-99');
     *
     * @param string $strValue
     * @param string $strMask
     * @return string
     *
     * @assert ('12345678911', '999.999.999-99') == '123.456.789-11'
     * @assert ('1234567891', '(99)9999-9999') == '(12)3456-7891'
     *
     * @assert ('12345678', '99.999.99-9') == '12.345.67-8'
     * @assert ('12345678912345', '99.999.99-9-9.99-999') == '12.345.67-8-9.12-345'
     * @assert ('1234567891234', '99.999.99-9-9.99-999') == '12.345.67-8-9.12-34'
     *
     * @assert ('12345678912345', '99.999.99-9-9.99-99/9') == '12.345.67-8-9.12-34/5'
     *
     * @TODO assert ('1234567891', '(99) 9999-9999') == "(12) 3456-7891"
     */
    public static function setMask($strValue, $strMask)
    {
        $strValue = self::clearMask($strValue);
        $strValueRetorno = '';
        $intCount = 0;
        for ($intCountIntern = 0; $intCountIntern < strlen($strValue); $intCountIntern++) {
            if (($strMask[$intCount] != '9') && ($strMask[$intCount] != '*')) {
                $strValueRetorno .= $strMask[$intCount];
                $intCount++;
            }
            $strValueRetorno .= $strValue[$intCountIntern];
            $intCount++;
        }
        return $strValueRetorno;
    }

    /**
     * Metodo responsavel em retirar qualquer mascara.
     *
     * @example \CoreZend\Util\Format::clearMask('999.999.999-99');
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('999.999.999-99') == '99999999999'
     * @assert ('12.345.67-8-9.12-34/5') == '12345678912345'
     * @assert ('12-345.67-8-9_1234/5') == '12345678912345'
     *
     * @TODO assert ('12-345.67-8-9.12@34/5') == '12345678912@345'
     */
    public static function clearMask($strValue)
    {
        $intNuValue = str_replace(array('-'), '', $strValue);
        if ((strpos($strValue, '-') !== false) && (strpos($strValue, '.') !== false) && (strpos($strValue, '@') === false))
            return str_replace(array('-', '.', '/', '_'), '', $strValue);
        elseif (is_numeric($intNuValue))
            return $intNuValue;
        return $strValue;
    }

    /**
     * Metodo responsavel em realizar a conversao de um valor informado para indicador.
     *
     * @example \CoreZend\Util\Format::convertToIndicator('sim'); <br /> \CoreZend\Util\Format::convertToIndicator(true); <br /> \CoreZend\Util\Format::convertToIndicator('nao'); <br /> \CoreZend\Util\Format::convertToIndicator(false);
     *
     * @param mix $mixValue
     * @return integer
     *
     * @assert (1) == 1
     * @assert ('true') == 1
     * @assert ('sim') == 1
     * @assert ('verdadeiro') == 1
     * @assert ('verdadeira') == 1
     * @assert ('s') == 1
     * @assert ('x') == 1
     *
     * @assert ('nao') == 0
     * @assert (false) == 0
     * @assert ('teste') == 0
     */
    public static function convertToIndicator($mixValue = null)
    {
        if ((!is_null($mixValue)) && (!empty($mixValue))) {
            if (is_bool($mixValue))
                $mixValue = ($mixValue) ? 'true' : 'false';
            if (is_string($mixValue))
                $mixValue = trim(strtolower($mixValue));
            $mixValue = (in_array($mixValue, array(1, 'true', '1', 'sim', 'verdadeiro', 'verdadeira', 's', 'x'))) ? 1 : 0;
        }
        return $mixValue;
    }

    /**
     * Metodo responsavel em listar os DDDs do Brasil e os DDDs que possuem 9 digitos.
     *
     * @example \CoreZend\Util\Format::listDdd(); <br /> \CoreZend\Util\Format::listDdd(true);
     *
     * @param boolean $boo9Digit
     * @return integer
     *
     * @assert () == array(11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 21 => 21, 22 => 22, 24 => 24, 27 => 27, 28 => 28, 31 => 31, 32 => 32, 33 => 33, 34 => 34, 35 => 35, 37 => 37, 38 => 38, 41 => 41, 42 => 42, 43 => 43, 44 => 44, 45 => 45, 46 => 46, 47 => 47, 48 => 48, 49 => 49, 51 => 51, 53 => 53, 54 => 54, 55 => 55, 61 => 61, 62 => 62, 63 => 63, 64 => 64, 65 => 65, 66 => 66, 67 => 67, 68 => 68, 69 => 69, 71 => 71, 73 => 73, 74 => 74, 75 => 75, 77 => 77, 79 => 79, 81 => 81, 82 => 82, 83 => 83, 84 => 84, 85 => 85, 86 => 86, 87 => 87, 88 => 88, 89 => 89, 91 => 91, 92 => 92, 93 => 93, 94 => 94, 95 => 95, 96 => 96, 97 => 97, 98 => 98, 99 => 99)
     * @assert (true) == array(11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28)
     */
    public static function listDdd($boo9Digit = false)
    {
        if ($boo9Digit === true)
            return array(11, 12, 13, 14, 15, 16, 17, 18, 19, 21, 22, 24, 27, 28);
        $arrDdd = array();
        $arrDddExclude = array(23, 25, 26, 29, 36, 39, 52, 56, 57, 58, 59, 72, 76, 78);
        for ($intCount = 11; $intCount <= 99; ++$intCount) {
            if ((($intCount % 10) == 0) || (in_array($intCount, $arrDddExclude)))
                continue;
            $arrDdd[$intCount] = $intCount;
        }
        return $arrDdd;
    }

    /**
     * Metodo responsavel em verificar se um valor parametrizado possui ou nao um caracter (string).
     *
     * @example \CoreZend\Util\Format::hasString('1a')
     *
     * @param mix $mixValue
     * @return boolean
     *
     * @assert () === false
     * @assert (null) === false
     * @assert ('') === false
     * @assert (0) === false
     * @assert ('1') === false
     * @assert (array()) === false
     * @assert ('a') === true
     * @assert ('1a') === true
     * @assert ('a1') === true
     */
    public static function hasString($mixValue = null)
    {
        return (is_array($mixValue)) ? false : (boolean) preg_match("/[a-zA-Z]/", $mixValue);
    }

    public static function removeMaskMoney($strMoneyValue)
    {
        if (!$strMoneyValue) {
            return null;
        }
        $strMoneyValue = str_replace(array('R$ ', ' ', '.'), '', $strMoneyValue);
        $strMoneyValue = str_replace(',', '.', $strMoneyValue);
        return $strMoneyValue;
    }
}
