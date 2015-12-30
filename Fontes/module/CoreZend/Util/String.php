<?php

namespace CoreZend\Util;


/**
 * Classe responsavel no tratamento de string.
 *
 * @package InepZend
 * @subpackage Util
 */
class String
{

    /**
     * Metodo responsavel em retornar uma expressao no formato de nome proprio.
     *
     * @example \CoreZend\Util\String::beautifulProperName('INSTITUTO NACIONAL DE ESTUDOS E PESQUISAS EDUCACIONAIS ANÍSIO TEIXEIRA') <br /> \CoreZend\Util\String::beautifulProperName('instituto nacional de estudos e pesquisas educacionais anísio teixeira')
     *
     * @param string $strName
     * @param boolean $booSort
     * @return string
     */
    public static function beautifulProperName($strName, $booSort = false)
    {
        $strEncode = 'UTF-8';
        if (function_exists('mb_convert_case'))
            $strName = mb_convert_case($strName, MB_CASE_TITLE, $strEncode);
        else
            $strName = self::utf8Decode($strName);
        $strNameResult = '';
        $arrName = explode(' ', $strName);
        $arrIntersectName = array(
            'da', 'das',
            'de', 'des',
            'di', 'dis',
            'do', 'dos',
            'du', 'dus',
            'na', 'nas',
            'ne', 'nes',
            'ni', 'nis',
            'no', 'nos',
            'nu', 'nus'
        );
        foreach ($arrName as $strBlockName) {
            $strBlockNameLower = mb_strtolower($strBlockName, $strEncode);
            $boolUcfirst = (!in_array($strBlockNameLower, $arrIntersectName));
            $strNameResult .= ($boolUcfirst) ? ucfirst($strBlockNameLower) : $strBlockNameLower;
            $strNameResult .= ' ';
        }
        $strNameResult = trim($strNameResult);
        if ($booSort) {
            $arrNameResult = explode(' ', $strNameResult);
            $arrNameResultShort = array();
            if (isset($arrNameResult[0]))
                $arrNameResultShort[] = $arrNameResult[0];
            if (isset($arrNameResult[1]))
                $arrNameResultShort[] = $arrNameResult[1];
            if ((in_array(strtolower($arrNameResult[1]), $arrIntersectName)) && (isset($arrNameResult[2])))
                $arrNameResultShort[] = $arrNameResult[2];
            $strNameResult = implode(' ', $arrNameResultShort);
        }
        return $strNameResult;
    }

    /**
     * Metodo responsavel em gerar uma expressao com elementos totalmente randomicos.
     *
     * @example \CoreZend\Util\String::generateRandomExpression(9)
     *
     * @param integer $intLength
     * @param boolean $booNumber
     * @return string
     */
    public static function generateRandomExpression($intLength, $booNumber = true)
    {
        $strValidsChars = (($booNumber) ? '0123456789' : '') . 'abcdefghijklmnopqrstuvwxyz';
        $strPassword = '';
        for ($intCount = 0; $intCount < $intLength; ++$intCount)
            $strPassword .= $strValidsChars[rand(0, strlen($strValidsChars) - 1)];
        return str_pad($strPassword, $intLength, 'A', STR_PAD_LEFT);
    }

    /**
     * Metodo responsavel em verificar se a string parametrizada possui o encode utf8.
     *
     * @example \CoreZend\Util\String::isUTF8()
     *
     * @param string $strValue
     * @return boolean
     *
     * @assert ('Instituto Nacional de Estudos E Pesquisas Educacionais Anísio Teixeira') === true
     * @TODO assert ('éáú.') !== true
     */
    public static function isUTF8($strValue)
    {
        return (utf8_encode(utf8_decode($strValue)) == $strValue);
    }

    /**
     * Metodo responsavel em remover os acentos, inclusive para um consulta LIKE
     * ou ILIKE utilizando query SQL.
     *
     * @example \CoreZend\Util\String::clearWord('Ministério da Educação - Instituto Nacional de Estudos E Pesquisas Educacionais Anísio Teixeira') <br /> \CoreZend\Util\String::clearWord('Ministério da Educação - Instituto Nacional de Estudos E Pesquisas Educacionais Anísio Teixeira', true)
     *
     * @param string $strWord
     * @param boolean $booPercent
     * @return string
     *
     * @assert ('Ministério da Educação - Instituto Nacional de Estudos E Pesquisas Educacionais Anísio Teixeira') === 'Ministerio da Educacao - Instituto Nacional de Estudos E Pesquisas Educacionais Anisio Teixeira'
     * @assert ('Ministério da Educação - Instituto Nacional de Estudos E Pesquisas Educacionais Anísio Teixeira', true) === 'Minist%rio da Educa%%o - Instituto Nacional de Estudos E Pesquisas Educacionais An%sio Teixeira'
     * @assert ('Ministerio da Educacao - Instituto Nacional de Estudos E Pesquisas Educacionais Anisio Teixeira') === 'Ministerio da Educacao - Instituto Nacional de Estudos E Pesquisas Educacionais Anisio Teixeira'
     * @assert ('Minist%rio da Educa%%o - Instituto Nacional de Estudos E Pesquisas Educacionais An%sio Teixeira', true) === 'Minist%rio da Educa%%o - Instituto Nacional de Estudos E Pesquisas Educacionais An%sio Teixeira'
     */
    public static function clearWord($strWord, $booPercent = false)
    {
        $strSeparator = '||';
        $arrSpecialCharacter = array(
            'á', 'â', 'ã', 'à', 'ä',
            'é', 'ê', 'è', 'ë',
            'í', 'î', 'ì', 'ï',
            'ó', 'ô', 'õ', 'ò', 'ö',
            'ú', 'û', 'ù', 'ü',
            'ç',
            'Á', 'Â', 'Ã', 'À', 'Ä',
            'É', 'Ê', 'È', 'Ë',
            'Í', 'Î', 'Ì', 'Ï',
            'Ó', 'Ô', 'Õ', 'Ò', 'Ö',
            'Ú', 'Û', 'Ù', 'Ü',
            'Ç'
        );
        $arrNormalCharacter = array(
            'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u',
            'c',
            'A', 'A', 'A', 'A', 'A',
            'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I',
            'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U',
            'C'
        );
        $strWord = self::utf8Decode($strWord);
        $mixReplace = ($booPercent === false) ? $arrNormalCharacter : '%';
        $strSpecialCharacter = implode($strSeparator, $arrSpecialCharacter);
        if (self::isUTF8($strSpecialCharacter))
            $strSpecialCharacter = iconv('UTF-8', 'ISO-8859-1', $strSpecialCharacter);
        $arrSpecialCharacter = explode($strSeparator, $strSpecialCharacter);
        return str_ireplace($arrSpecialCharacter, $mixReplace, $strWord);
    }

    /**
     * Metodo responsavel em serializar um elemento e converte para base64.
     *
     * @example \CoreZend\Util\String::serialize64('INEP')
     *
     * @param mix $mixElement
     * @return string
     *
     * @assert ('INEP') == 'czo0OiJJTkVQIjs='
     * @assert ('Instituto Nacional de Estudos E Pesquisas Educacionais Anisio Teixeira') === 'czo3MDoiSW5zdGl0dXRvIE5hY2lvbmFsIGRlIEVzdHVkb3MgRSBQZXNxdWlzYXMgRWR1Y2FjaW9uYWlzIEFuaXNpbyBUZWl4ZWlyYSI7'
     * @assert ('Ministério da Educação') === 'czoyNToiTWluaXN0w6lyaW8gZGEgRWR1Y2HDp8OjbyI7'
     *
     * @assert ('czo0OiJJTkVQIjs') === 'czoxNToiY3pvME9pSkpUa1ZRSWpzIjs='
     * @assert ('czo3MDoiSW5zdGl0dXRvIE5hY2lvbmFsIGRlIEVzdHVkb3MgRSBQZXNxdWlzYXMgRWR1Y2FjaW9uYWlzIEFuaXNpbyBUZWl4ZWlyYSI7') === 'czoxMDQ6ImN6bzNNRG9pU1c1emRHbDBkWFJ2SUU1aFkybHZibUZzSUdSbElFVnpkSFZrYjNNZ1JTQlFaWE54ZFdsellYTWdSV1IxWTJGamFXOXVZV2x6SUVGdWFYTnBieUJVWldsNFpXbHlZU0k3Ijs='
     */
    public static function serialize64($mixElement)
    {
        return base64_encode(serialize($mixElement));
    }

    /**
     * Metodo responsavel em deserializar um elemento e desconverte da base64.
     *
     * @example \CoreZend\Util\String::unserialize64('czo0OiJJTkVQIjs')
     *
     * @param string $strBase64Element
     * @return string
     *
     * @assert ('czo0OiJJTkVQIjs') === 'INEP'
     * @assert ('czo3MDoiSW5zdGl0dXRvIE5hY2lvbmFsIGRlIEVzdHVkb3MgRSBQZXNxdWlzYXMgRWR1Y2FjaW9uYWlzIEFuaXNpbyBUZWl4ZWlyYSI7') == 'Instituto Nacional de Estudos E Pesquisas Educacionais Anisio Teixeira'
     * @assert ('czoyNToiTWluaXN0w6lyaW8gZGEgRWR1Y2HDp8OjbyI7') === 'Ministério da Educação'
     *
     * @assert ('czoxNToiY3pvME9pSkpUa1ZRSWpzIjs==') === 'czo0OiJJTkVQIjs'
     * @assert ('czoxMDQ6ImN6bzNNRG9pU1c1emRHbDBkWFJ2SUU1aFkybHZibUZzSUdSbElFVnpkSFZrYjNNZ1JTQlFaWE54ZFdsellYTWdSV1IxWTJGamFXOXVZV2x6SUVGdWFYTnBieUJVWldsNFpXbHlZU0k3Ijs=') === 'czo3MDoiSW5zdGl0dXRvIE5hY2lvbmFsIGRlIEVzdHVkb3MgRSBQZXNxdWlzYXMgRWR1Y2FjaW9uYWlzIEFuaXNpbyBUZWl4ZWlyYSI7'
     */
    public static function unserialize64($strBase64Element)
    {
        return unserialize(base64_decode($strBase64Element));
    }

    /**
     * Metodo responsavel em decodificar o valor da variavel $_GET.
     *
     * @param string $strCodedElement
     * @return string
     *
     * @TODO nao ha situacao que entre na terceira condicao
     */
    public static function getBase64Decode($strCodedElement)
    {
        if (($_GET[md5($strCodedElement)] == 'null') || (is_null($_GET[md5($strCodedElement)])) || (empty($_GET[md5($strCodedElement)])))
            return;
        elseif ((!is_null($_GET[$strCodedElement])) || (!empty($_GET[$strCodedElement])))
            return base64_decode($_GET[$strCodedElement]);
        else
            return base64_decode($_GET[md5($strCodedElement)]);
    }

    /**
     * Metodo responsavel em inserir uma string ao final de deteminados numeros
     * de caracteres.
     *
     * @example \CoreZend\Util\String::truncate('Ministerio da Educacao')
     *
     * @param string $strValue
     * @param integer $intLengthMaxCarac
     * @param string $strEtc
     * @param boolean $booBreakWords
     * @param boolean $booMiddle
     * @param boolean $booConvertHtml
     * @param boolean $booTitleFullValue
     * @return string
     *
     * @assert ('Ministerio da Educacao') === 'Ministerio da Educacao'
     * @assert ('Ministerio da Educacao', 13) === 'Ministerio...'
     * @assert ('Ministerio da Educacao', 13, '***') === 'Ministerio***'
     * @assert ('Ministerio da Educacao', 20, '***', true) === 'Ministerio da Edu***'
     * @assert ('Ministerio da Educacao', 20, '_._', true, true) === 'Minister_._Educacao'
     * @assert ('Ministerio da Educacao', 20, '_._', true, true, true) === 'Minister_._Educacao'
     * @assert ('<b>Ministério da Educação</b>', 20, '...', true, true, true) === '&lt;b&gt;Minis...&sect;&Atilde;&pound;o&lt;/b&gt;'
     */
    public static function truncate($strValue, $intLengthMaxCarac = 80, $strEtc = '...', $booBreakWords = false, $booMiddle = false, $booConvertHtml = false, $booTitleFullValue = false)
    {
        $strValue = html_entity_decode($strValue);
        if ($intLengthMaxCarac == 0)
            return '';
        $strFullValue = $strValue;
        if (strlen($strValue) > $intLengthMaxCarac) {
            $intLengthMaxCarac -= strlen($strEtc);
            if (!$booBreakWords && !$booMiddle)
                $strValue = preg_replace('/\s+?(\S+)?$/', '', substr($strValue, 0, $intLengthMaxCarac + 1));
            $strReturn = (!$booMiddle) ? substr($strValue, 0, $intLengthMaxCarac) . $strEtc : substr($strValue, 0, $intLengthMaxCarac / 2) . $strEtc . substr($strValue, -$intLengthMaxCarac / 2);
        } else
            $strReturn = $strValue;
        if ($booConvertHtml)
            $strReturn = htmlentities($strReturn, ENT_COMPAT | ENT_HTML401, '');
        if ($booTitleFullValue)
            $strReturn = '<font title="' . $strFullValue . '">' . $strReturn . '</font>';
        return $strReturn;
    }

    /**
     * Metodo responsavel em alterar a string de um nome proprio inserindo o
     * primeiro caracter maiusculo nos nomes e nos sobrenomes.
     *
     * @example \CoreZend\Util\String::maskName('instituto nacional de estudos e pesquisas educacionais anisio teixeira')
     *
     * @param string $strName
     * @return string
     */
    public static function maskName($strName)
    {
        if (function_exists('mb_convert_encoding')) {
            if (self::isUTF8($strName))
                $strName = mb_convert_encoding($strName, 'UTF-8');
        } else
            $strName = self::utf8Decode($strName);
        $strName = strtolower($strName);
        $arrName = explode(' ', $strName);
        foreach ($arrName as &$strName)
            $strName = ucfirst($strName);
        $strName = implode(' ', $arrName);
        $arrName = explode("'", $strName);
        foreach ($arrName as &$strName)
            $strName = ucfirst($strName);
        $strName = implode("'", $arrName);
        $arrFrom = array(' Da ', ' De ', ' Do ', ' E ');
        $arrTo = array(' da ', ' de ', ' do ', ' e ');
        $strName = str_replace($arrFrom, $arrTo, $strName);
        return $strName;
    }

    /**
     * Metodo responsavel em verificar se algum valor eh nulo ou vazio.
     *
     * @example \CoreZend\Util\String::isNullEmpty('') <br /> \CoreZend\Util\String::isNullEmpty(array())
     *
     * @param mix $mixValue
     * @return boolean
     *
     * @assert ('') === true
     * @assert (array()) === true
     *
     * @assert ('INEP') !== true
     * @assert (array('MEC' => 'INEP')) !== true
     */
    public static function isNullEmpty($mixValue)
    {
        return ((is_null($mixValue)) || ((empty($mixValue)) && (!is_numeric($mixValue))));
    }

    /**
     * Metodo responsavel em trabalhar com a quebra de linhas de uma string
     * acrescidas de outras funcionalidades especiais.
     *
     * @example \CoreZend\Util\String::cleanBreakline('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira')
     *
     * @param string $strValue
     * @param boolean $booBr
     * @param boolean $booAspasDupla
     * @param boolean $booNoWrap
     * @param boolean $booHtmlDecode
     * @return string
     *
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') === 'Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira'
     * @assert ('"Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira"') === '\"Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira\"'
     * @assert ('"Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira"', true, false) === '"Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira"'
     */
    public static function cleanBreakline($strValue = '', $booBr = true, $booAspasDupla = true, $booNoWrap = true, $booHtmlDecode = true)
    {
        if ($booHtmlDecode)
            $strValue = html_entity_decode($strValue);
        $strBreak = ($booBr) ? '<br />' : "\n";
        $strValue = str_replace(chr(13), '', $strValue);
        if ($booAspasDupla)
            $strValue = str_replace(chr(34), '\"', $strValue);
        $strValue = (!$booNoWrap) ? str_replace(chr(10), $strBreak, $strValue) : str_replace(chr(10), '', $strValue);
        return $strValue;
    }

    /**
     * Metodo responsavel em quebrar um texto em formato vertical.
     *
     * @example \CoreZend\Util\String::verticalText('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') <br /> \CoreZend\Util\String::verticalText('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira', true)
     *
     * @param string $strText
     * @param string $strWrap
     * @return string
     *
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') === 'I<br />n<br />s<br />t<br />i<br />t<br />u<br />t<br />o<br /> <br />N<br />a<br />c<br />i<br />o<br />n<br />a<br />l<br /> <br />d<br />e<br /> <br />E<br />s<br />t<br />u<br />d<br />o<br />s<br /> <br />e<br /> <br />P<br />e<br />s<br />q<br />u<br />i<br />s<br />a<br />s<br /> <br />E<br />d<br />u<br />c<br />a<br />c<br />i<br />o<br />n<br />a<br />i<br />s<br /> <br />A<br />n<br />i<br />s<br />i<br />o<br /> <br />T<br />e<br />i<br />x<br />e<br />i<br />r<br />a'
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira', '_') === 'I_n_s_t_i_t_u_t_o_ _N_a_c_i_o_n_a_l_ _d_e_ _E_s_t_u_d_o_s_ _e_ _P_e_s_q_u_i_s_a_s_ _E_d_u_c_a_c_i_o_n_a_i_s_ _A_n_i_s_i_o_ _T_e_i_x_e_i_r_a'
     *
     * @assert ('Ministerio da Educacao') !== 'Mi<br>n<br>i<br>s<br>t<br>e<br>r<br>i<br>o<br> <br>da<br> <br>E<br>d<br>u<br>c<br>a<br>c<br>a<br>o'
     * @assert ('Ministerio da Educacao', "\n") !== 'Mi n i s t e r i o d a E d u c a cao'
     */
    public static function verticalText($strText = '', $strWrap = '<br />')
    {
        $arrText = array();
        for ($intCount = 0; $intCount < strlen($strText); ++$intCount)
            $arrText[] = $strText{$intCount};
        return implode($strWrap, $arrText);
    }

    /**
     * Metodo responsavel em limpar determinado texto, retirando caracteres
     * desnecessarios.
     *
     * @example \CoreZend\Util\String::clearText('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira')
     *
     * @param string $strText
     * @param string $strChars
     * @param boolean $booAcceptChar
     * @return string
     *
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') === 'Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira'
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira', 'i') === 'iiiiiiiii'
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira', 'i', false) === 'Insttuto Naconal de Estudos e Pesqusas Educaconas Anso Texera'
     */
    public static function clearText($strText = null, $strChars = null, $booAcceptChar = null)
    {
        if (self::isNullEmpty($strText))
            return false;
        if (!is_bool($booAcceptChar))
            $booAcceptChar = true;
        if (self::isNullEmpty($strChars))
            $strChars = ($booAcceptChar === true) ? 'abcdefghijklmnopqrstuvwxyzçABCDEFGHIJKLMNOPQRSTUVWXYZÇáàâãäéèêëíìïóòôõöúùûüÁÀÂÃÄÉÈÊËÍÌÏÓÒÔÕÖÚÙÛÜ0123456789,.;/<>:?][}{\\|/*-+="\'!@#$%&*()_ °ªº§¬£¢\n\t' : '–“”';
        $strSymbol = ($booAcceptChar === true) ? '!==' : '===';
        $strResult = '';
        for ($intCount = 0; $intCount < strlen($strText); ++$intCount)
            eval('if (strpos($strChars , $strText{$intCount}) ' . $strSymbol . ' false) $strResult .= $strText{$intCount};');
        return $strResult;
    }

    /**
     * Metodo responsavel em converter caracteres de um array por outro caracter.
     *
     * @example \CoreZend\Util\String::replaceCharacterAndRemoveLast('MEC', array('M', 'E', 'C'), 'OAB') <br/ > \CoreZend\Util\String::replaceCharacterAndRemoveLast('INEP')
     *
     * @param string $strText
     * @param array $arrCharacter
     * @param string $strCharacterReplace
     * @return string
     *
     * @assert ('INEP', array('N', 'E', 'A'), 'MFB') === 'IMFBP'
     * @assert ('MEC', array('M', 'E', 'C'), 'OAB') === 'OAB'
     * @TODO assert ('INEP', array('I', 'N', 'E', 'P'), 'FNDE') === 'FNDE'
     * @TODO assert ('Programando Testes Unitarios', array('P', 'r', 'o', 'g', 'r', 'a', 'm', 'a', 'n', 'd', 'o'), 'Analisando') === 'Analisando Testes Unitarios'
     */
    public static function replaceCharacterAndRemoveLast($strText = '', $arrCharacter = array(), $strCharacterReplace = ',')
    {
        $strText = trim($strText);
        foreach ($arrCharacter as $strCharacter) {
            foreach ($arrCharacter as $strCharacterIntern)
                $strText = str_replace($strCharacter . $strCharacterIntern, $strCharacterReplace, $strText);
            $strText = str_replace($strCharacter, $strCharacterReplace, $strText);
        }
        while (strpos($strText, $strCharacterReplace . $strCharacterReplace) !== false)
            $strText = str_replace($strCharacterReplace . $strCharacterReplace, $strCharacterReplace, $strText);
        if (in_array($strText{ (strlen($strText) - 1) }, $arrCharacter))
            $strText = substr($strText, 0, (strlen($strText) - 1));
        return $strText;
    }

    /**
     * Metodo responsavel em fazer o tratamento de parametros de consulta que
     * precisam ser separados por ','.
     * Substitui varios separadores na string por , para que o parametro da pesquisa
     * seja passado corretamente a query de consulta.
     *
     * @example \CoreZend\Util\String::treatingSeparatorParameter('INEP')
     *
     * @param string $strItemPesquisa
     * @return string
     *
     * @assert ('INEP') == 'INEP'
     * @assert ('INEP MEC') === "'INEP','MEC'"
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') === "'Instituto','Nacional','de','Estudos','e','Pesquisas','Educacionais','Anisio','Teixeira'"
     */
    public static function treatingSeparatorParameter($strItemPesquisa)
    {
        if (!empty($strItemPesquisa)) {
            $strItem = str_replace(array(';', ':', '|', '.', '-', '+', ' ', "\n", "\t", "\r"), ',', (string) $strItemPesquisa);
            $arrItem = explode(',', str_replace('"', '', $strItem));
            foreach ($arrItem as $intKey => $strParametro) {
                if (empty($strParametro))
                    unset($arrItem[$intKey]);
            }
            if (count($arrItem) > 1)
                return "'" . implode("','", $arrItem) . "'";
            elseif (count($arrItem) == 1)
                return reset($arrItem);
            else
                return;
        } else
            return;
    }

    /**
     * Metodo responsavel em realizar o SUBSTR de tras para frente.
     *
     * @example \CoreZend\Util\String::substrReverse('INEP MEC', 4, 8)
     *
     * @param string $strText
     * @param integer $intStart
     * @param integer $intLenght
     * @return string
     *
     * @assert ('INEP MEC') === 'INEP MEC'
     * @assert ('INEP MEC', 4, 8) === 'INEP'
     */
    public static function substrReverse($strText, $intStart = null, $intLenght = null)
    {
        if (empty($intStart))
            $intStart = 0;
        if (empty($intLenght))
            $intLenght = strlen((string) $strText);
        return strrev(substr(strrev((string) $strText), $intStart, $intLenght));
    }

    /**
     * Metodo responsavel em editar uma string para o formato dasherize.
     *
     * @example \CoreZend\Util\String::dasherize('INEP MEC')
     *
     * @param string $strText
     * @param string $strSymbol
     * @return string
     *
     * @assert ('INEP MEC') === 'i-n-e-p-m-e-c'
     * @assert ('INEP') === 'i-n-e-p'
     * @assert ('I') === 'i'
     *
     * @assert ('i-n-e-p-m-e-c') === 'i-n-e-p-m-e-c'
     * @assert ('i-n-e-p') === 'i-n-e-p'
     */
    public static function dasherize($strText = '', $strSymbol = null)
    {
        $intPos = 0;
        while ($intPos < strlen($strText)) {
            $strCarac = @$strText{$intPos};
            if ((!empty($strCarac)) && (!is_numeric($strCarac))) {
                $intAscii = ord($strCarac);
                if ((!empty($strCarac)) && ($strCarac == strtoupper($strCarac)) && ((($intAscii >= 48) && ($intAscii <= 57)) || (($intAscii >= 65) && ($intAscii <= 90)) || (($intAscii >= 97) && ($intAscii <= 122)))) {
                    $strText{$intPos} = strtolower($strCarac);
                    if ($intPos != 0) {
                        $strText = substr($strText, 0, $intPos) . '-' . substr($strText, $intPos);
                        ++$intPos;
                    }
                }
            }
            ++$intPos;
        }
        if (empty($strSymbol))
            $strSymbol = '-';
        return strtolower(str_replace(array('_', ' ', '--', '-'), $strSymbol, (string) $strText));
    }

    /**
     * Metodo responsavel em editar uma string para o formato camelize.
     *
     * @example \CoreZend\Util\String::camelize('INEP MEC')
     *
     * @param string $strText
     * @return string
     *
     * @assert ('INEP MEC') === 'InepMec'
     * @assert ('Instituto Nacional de Estudos e Pesquisas Educacionais Anisio Teixeira') === 'InstitutoNacionalDeEstudosEPesquisasEducacionaisAnisioTeixeira'
     * @assert ('InstitutoNacionalDeEstudosEPesquisasEducacionaisAnisioTeixeira') === 'InstitutoNacionalDeEstudosEPesquisasEducacionaisAnisioTeixeira'
     */
    public static function camelize($strText = '')
    {
        $strText = str_replace(array('_', ' ', '--'), '-', trim((string) $strText));
        if (!empty($strText)) {
            if (strpos($strText, '-') !== false) {
                $arrText = explode('-', strtolower($strText));
                foreach ($arrText as $intKey => $strPart)
                    $arrText[$intKey] = ucfirst($strPart);
                return implode('', $arrText);
            } else {
                $strCarac = $strText{0};
                if ((!empty($strCarac)) && ($strCarac != strtoupper($strCarac)))
                    $strText{0} = strtoupper($strCarac);
            }
        }
        return $strText;
    }

    /**
     * Metodo responsavel em realizar o MB_SUBSTR.
     *
     * @example \CoreZend\Util\String::substrEncode('Minstério da Educação', 5) <br /> \CoreZend\Util\String::substrEncode('Minstério da Educação', 5, 21) <br /> \CoreZend\Util\String::substrEncode('Minstério da Educação', 5, 'US-ASCII')
     *
     * @param string $strText
     * @param integer $intStart
     * @param integer $intLength
     * @param string $strEncoding
     * @return string
     *
     * @assert ('Minstério da Educação', 5) === 'ério da Educação'
     * @assert ('Minstério da Educação', 12) === ' Educação'
     *
     * @assert ('Minstério da Educação', 5, 21) === 'ério da Educação'
     * @assert ('Minstério da Educação', 12, 21) === ' Educação'
     *
     * @assert ('Minstério da Educação', 5, 21) === 'ério da Educação'
     *
     * @TODO assert ('Minstério da Educação', 5, 21, 'US-ASCII') === '&#233;rio da Educa&#231;&#227;o'
     * @TODO assert ('Minstério da Educação', 12, 21, 'US-ASCII') === 'Educa&#231;&#227;o'
     */
    public static function substrEncode($strText, $intStart = 0, $intLength = null, $strEncoding = null)
    {
        if (empty($strText))
            return;
        if (empty($strEncoding)) {
//            $strEncoding = (function_exists('mb_internal_encoding')) ? mb_internal_encoding() : 'UTF-8';
            $strEncoding = 'UTF-8';
        }
        if (is_null($intLength))
            $intLength = (function_exists('mb_strlen')) ? mb_strlen($strText, $strEncoding) : strlen($strText);
        if ($intStart > $intLength)
            return false;
        return (function_exists('mb_substr')) ? mb_substr($strText, $intStart, $intLength, $strEncoding) : substr($strText, $intStart, $intLength);
    }

    /**
     * Metodo responsavel em Converter uma determinada string para o formato
     * de UTF-8.
     *
     * @example \CoreZend\Util\String::utf8Decode('&#233;rio da Educa&#231;&#227;o') <br />
     *
     * @param string $strText
     * @param boolean $booCheck
     * @return string
     *
     * @assert ('MinistÃ©rio da EducaÃ§Ã£o') === 'Ministério da Educação'
     * @assert ('Ministério da Educação') === utf8_decode('Ministério da Educação')
     * @assert ('Minist&#233;rio da Educa&#231;&#227;o') !== 'Ministério da Educação'
     */
    public static function utf8Decode($strText = '', $booCheck = null)
    {
        if (!is_bool($booCheck))
            $booCheck = true;
        if ((!$booCheck) || (self::isUTF8($strText)))
            $strText = utf8_decode($strText);
        return $strText;
    }

    /**
     * Metodo responsavel em codificar uma determinada string para o formato
     * de UTF-8.
     *
     * @example \CoreZend\Util\String::utf8Encode('')
     *
     * @param string $strText
     * @param boolean $booCheck
     * @return string
     *
     * @assert ('Ministério da Educação') === 'MinistÃ©rio da EducaÃ§Ã£o'
     * @assert ('MinistÃ©rio da EducaÃ§Ã£o') === 'MinistÃÂ©rio da EducaÃÂ§ÃÂ£o'
     */
    public static function utf8Encode($strText = '', $booCheck = null)
    {
        if (!is_bool($booCheck))
            $booCheck = true;
        if ((!$booCheck) || (self::isUTF8($strText)))
            $strText = utf8_encode($strText);
        return $strText;
    }

    /**
     * Metodo responsavel em listar os valores de uma string usando aspas
     * simples e duplas.
     *
     * @example \CoreZend\Util\String::listValueFromText('Inep', '<span class="Inep">Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira Legislação e Documentos.</span>')
     *
     * @param string $strValuePart
     * @param string $strText
     * @return mix
     *
     * @assert ('Inep', '<span class="Inep">Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira Legislação e Documentos.</span>') === array('Inep')
     * @assert ('INEP - MEC', '<p>Ministerio da Educacao, "INEP - MEC"</p>' === array('INEP - MEC')
     * @assert ('Inep', 'Instituto=\'Inep\'') === array('Inep')
     * @assert ('INEP', 'Instituto=\'Inep\'') === array('Inep')
     * @assert ('INEP', 'O Censo Escolar, realizado anualmente pelo Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira - "Inep", é o mais relevante e abrangente levantamento estatístico sobre a Educação Básica no País') === array('Inep')
     * @assert ('Educação Básica no País', 'O Censo Escolar, realizado anualmente pelo Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira - Inep, é o mais relevante e abrangente levantamento estatístico sobre a "Educação Básica no País"') === array('Educação Básica no País')
     * @assert ('Educação Básica no País', 'O Censo Escolar, realizado anualmente pelo Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira - Inep, é o mais relevante e abrangente levantamento estatístico sobre a "Educação Básica" no País') !== array('Educação Básica no País')
     */
    public static function listValueFromText($strValuePart = null, $strText = null)
    {
        if ((empty($strValuePart)) || (empty($strText)))
            return false;
        $arrValue = array();
        $strTextEdited = $strText;
        while (($intPos = stripos($strTextEdited, $strValuePart)) !== false) {
            if ($intPos === 0)
                continue;
            $strPart = substr($strTextEdited, $intPos - 1);
            $strFirstCharacter = $strPart{0};
            if (!in_array($strFirstCharacter, array('"', "'", '=', ':')))
                continue;
            $strPart = substr($strPart, 1);
            if (((in_array($strFirstCharacter, array('"', "'"))) && (($intPos = strpos($strPart, $strFirstCharacter)) !== false)) || (($intPos = strpos($strPart, ' ')) !== false))
                $arrValue[] = substr($strPart, 0, $intPos);
            else
                continue;
            $strTextEdited = substr($strPart, $intPos + 1);
        }
        return array_values(array_unique($arrValue));
    }

    /**
     * Metodo responsavel em listar a ordem alfabetica.
     *
     * @example \CoreZend\Util\String::getAlphabeticOrder()
     *
     * @param integer $intOrder
     * @param boolean $booCapsLock
     * @return mix
     *
     * @TODO implementar asserts
     */
    public static function getAlphabeticOrder($intOrder = null, $booCapsLock = false)
    {
        $arrRange = array();
        $strRange = 'abcdefghijklmnopqrstuvwxyz';
        if ($booCapsLock)
            $strRange .= strtoupper($strRange);
        for ($intCount = 0; $intCount < strlen($strRange); ++$intCount)
            $arrRange[] = $strRange{$intCount};
        if ($intOrder >= strlen($strRange))
            $intOrder = strlen($strRange) - 1;
        return (is_null($arrRange)) ? $arrRange : @$arrRange[$intOrder];
    }

}
