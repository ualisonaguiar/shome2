<?php

namespace CoreZend\Util;

class Date
{

    const TYPE_DATE_BASE = 'base';
    const TYPE_DATE_TEMPLATE = 'template';
    const TYPE_DATE_WS = 'ws';

    /**
     * Metodo responsavel em verificar se a data passada como parametro esta na string dd/mm/aaaa.
     *
     * @example \CoreZend\Util\Date::isDateTemplate('18/07/2014')
     *
     * @param string $strValue
     * @return boolean
     *
     * @assert ('18/07/2014') === true
     * @assert ('2014-07-18') !== true
     * @assert ('20140718') !== true
     */
    public static function isDateTemplate($strValue)
    {
        return self::isDate($strValue, self::TYPE_DATE_TEMPLATE);
    }

    /**
     * Metodo responsavel em verificar se a data passada como parametro esta na string aaaa-mm-dd.
     *
     * @example \CoreZend\Util\Date::isDateBase('2014-07-18')
     *
     * @param string $strValue
     * @return boolean
     *
     * @assert ('2014-07-18') === true
     * @assert ('18/07/2014') !== true
     */
    public static function isDateBase($strValue)
    {
        return self::isDate($strValue, self::TYPE_DATE_BASE);
    }

    /**
     * Metodo responsavel em verificar se a data passada como parametro esta na string aaaammdd.
     *
     * @example \CoreZend\Util\Date::isDateWs('20140718')
     *
     * @param string $strValue
     * @return boolean
     *
     * @assert ('20140718') === true
     * @assert ('18/07/2014') !== true
     * @assert ('2014-07-18') !== true
     *
     * @assert ('20140718 09:49:10') === true
     * @assert ('18/07/2014 09:49:10') !== true
     * @assert ('2014-07-18 09:49:10') !== true
     */
    public static function isDateWs($strValue)
    {
        return self::isDate($strValue, self::TYPE_DATE_WS);
    }

    /**
     * Verifica se a data passada como parametro esta no formato aaaa-mm-dd ou dd/mm/aaaa.
     *
     * @example \CoreZend\Util\Date::isDate('18/07/2014', 'template') <br /> \CoreZend\Util\Date::isDate('2014-07-18', 'base') <br /> \CoreZend\Util\Date::isDate('20140718', 'ws')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @return boolean
     *
     * @assert ('18/07/2014', 'template') === true
     * @assert ('2014-07-18', 'template') !== true
     * @assert ('20140718', 'template') !== true
     *
     * @assert ('2014-07-18', 'base') === true
     * @assert ('18/07/2014', 'base') !== true
     * @assert ('20140718', 'base') !== true
     *
     * @assert ('20140718', 'ws') === true
     * @assert ('2014-07-18', 'ws') !== true
     *
     * @assert ('18/07/2014', 'teste') !== true
     * @assert ('2014-07-18', 'teste') !== true
     * @assert ('20140718', 'teste') !== true
     */
    public static function isDate($strValue, $strTypeDate = null)
    {
        $mixDateParse = self::getDateParse($strValue, $strTypeDate);
        if (is_bool($mixDateParse))
            return $mixDateParse;
        return checkdate((integer) $mixDateParse['month'], (integer) $mixDateParse['day'], (integer) $mixDateParse['year']);
    }

    /**
     * Metodo responsavel em capturar algumas informacoes da data.
     *
     * @example \CoreZend\Util\Date::getInfoDate('18/07/2014', 'template') <br /> \CoreZend\Util\Date::getInfoDate('18/07/2014 18:36:15', 'template') <br /> \CoreZend\Util\Date::getInfoDate('2014-07-18', 'base') <br /> \CoreZend\Util\Date::getInfoDate('20140718', 'ws')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @return array
     *
     * @assert ('18/07/2014', 'template') === array(array(18, 7, 2014), array(0, 0, 0), 'd/m/Y', 'template')
     * @assert ('18/07/2014 18:36:15', 'template') === array(array(18, 7, 2014), array(18, 36, 15), 'd/m/Y H:i:s', 'template')
     * @assert ('32/07/2014', 'template') === null
     *
     * @assert ('2014-07-18', 'base') === array(array(18, 7, 2014), array(0, 0, 0), 'Y-m-d', 'base')
     * @assert ('2014-07-18 18:36:15', 'base') === array(array(18, 7, 2014), array(18, 36, 15), 'Y-m-d H:i:s', 'base')
     * @assert ('2014-14-32', 'base') === null
     *
     * @assert ('20140718', 'ws') === array(0 => array(18, 7, 2014), 1 => array(0, 0, 0), 2 => 'Ymd', 3 => 'ws')
     * @assert ('20140718 18:36:15', 'ws') === array(0 => array(18, 7, 2014), 1 => array(18, 36, 15), 2 => 'Ymd H:i:s', 3 => 'ws')
     * @assert ('20141432', 'ws') === null
     *
     * @assert ('18/07/2014 90:36:15', 'template') === array(array(18, 7, 2014), array(18, 36, 15), 'd/m/Y H:i:s', 'template')
     */
    public static function getInfoDate($strValue, $strTypeDate = null)
    {
        $arrDateParse = self::getDateParse($strValue, $strTypeDate);
        if (is_bool($arrDateParse))
            return;
        $intDays = (integer) $arrDateParse['day'];
        $intMonths = (integer) $arrDateParse['month'];
        $intYears = (integer) $arrDateParse['year'];
        if (($intYears >= 1970) && ($intYears <= 2037)) {
            if (!checkdate($intMonths, $intDays, $intYears))
                return;
        }
        $arrTime = array(
            (integer) $arrDateParse['hour'],
            (integer) $arrDateParse['minute'],
            (integer) $arrDateParse['second'],
        );
        return array(array($intDays, $intMonths, $intYears), $arrTime, $arrDateParse['format'], $arrDateParse['type_intern']);
    }

    /**
     * Metodo responsavel pela informacoes detalhada sobre a data.
     *
     * @example \CoreZend\Util\Date::getDateParse('18/07/2014', 'template') <br /> \CoreZend\Util\Date::getDateParse('2014-07-18', 'base') <br /> \CoreZend\Util\Date::getDateParse('20140718', 'ws')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @return array
     *
     * @assert ('18/07/2014') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'd/m/Y', 'type_intern' => 'template')
     * @assert ('18/07/2014', 'template') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'd/m/Y', 'type_intern' => 'template')
     * @assert ('18/07/2014 19:31:10', 'template') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => 19, 'minute' => 31, 'second' => 10, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'd/m/Y H:i:s', 'type_intern' => 'template')
     * @assert ('32/07/2014', 'template') === array('year' => 2014, 'month' => 7, 'day' => 32, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 1, 'warnings' => array(10 => 'The parsed date was invalid'), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'd/m/Y', 'type_intern' => 'template')
     * @assert ('/07/2014', 'template') === array('year' => 2014, 'month' => 7, 'day' => false, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => '/m/Y', 'type_intern' => 'template')
     * @assert ('07/2014', 'template') === false
     *
     * @assert ('2014-07-18') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Y-m-d', 'type_intern' => 'base')
     * @assert ('2014-07-18', 'base') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Y-m-d', 'type_intern' => 'base')
     * @assert ('2014-07-18 19:31:10', 'base') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => 19, 'minute' => 31, 'second' => 10, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Y-m-d H:i:s', 'type_intern' => 'base')
     * @assert ('2014-07-32', 'base') === array('year' => 2014, 'month' => 7, 'day' => 32, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 1, 'warnings' => array(10 => 'The parsed date was invalid'), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Y-m-d', 'type_intern' => 'base')
     * @assert ('2014-07-', 'base') === array('year' => 2014, 'month' => 7, 'day' => false, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Y-m-', 'type_intern' => 'base')
     * @assert ('2014-07', 'base') === false
     * @assert ('2014-07-18', 'template') === false
     *
     * @assert ('20140718') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Ymd', 'type_intern' => 'ws')
     * @assert ('20140718', 'ws') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Ymd', 'type_intern' => 'ws')
     * @assert ('20140718 11:15:10', 'ws') === array('year' => 2014, 'month' => 7, 'day' => 18, 'hour' => 11, 'minute' => 15, 'second' => 10, 'fraction' => false, 'warning_count' => 0, 'warnings' => array(), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Ymd H:i:s', 'type_intern' => 'ws')
     * @assert ('20140732', 'ws') === array('year' => 2014, 'month' => 7, 'day' => 32, 'hour' => false, 'minute' => false, 'second' => false, 'fraction' => false, 'warning_count' => 1, 'warnings' => array(8 => 'The parsed date was invalid'), 'error_count' => 0, 'errors' => array(), 'is_localtime' => false, 'format' => 'Ymd', 'type_intern' => 'ws')
     * @assert ('201407-', 'ws') === false
     * @assert ('201407', 'ws') === false
     * @assert ('201407-18 19:31:10', 'ws') === false
     * @assert ('18/07/2014', 'ws') === false
     * @assert ('2014-07-18', 'ws') === false
     */
    public static function getDateParse($strValue, $strTypeDate = null)
    {
        $arrDateFormat = self::getDateFormat($strValue, $strTypeDate);
        if (is_bool($arrDateFormat))
            return $arrDateFormat;
        $strFormat = $arrDateFormat[0];
        $strTypeDate = $arrDateFormat[1];
        $arrDateParse = date_parse_from_format($strFormat, $strValue);
        if (is_array($arrDateParse)) {
            $arrDateParse['format'] = $strFormat;
            $arrDateParse['type_intern'] = $strTypeDate;
        }
        return $arrDateParse;
    }

    /**
     * Metodo responsavel pela formatacao da data.
     *
     * @example \CoreZend\Util\Date::getDateFormat('18/07/2014', 'template') <br /> \CoreZend\Util\Date::getDateFormat('2014-07-18', 'base') <br /> \CoreZend\Util\Date::getDateFormat('20140718', 'ws')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @return array
     *
     * @assert ('18/07/2014', 'template') === array('d/m/Y', 'template')
     * @assert ('18/07/2014 14', 'template') === array('d/m/Y H', 'template')
     * @assert ('18/07/2014 14:45', 'template') === array('d/m/Y H:i', 'template')
     * @assert ('18/07/2014 14:45:10', 'template') === array('d/m/Y H:i:s', 'template')
     * @assert ('2014-07-18', 'template') === false
     * @assert ('2014-07-18 14:45:10', 'template') === false
     * @assert ('20140718', 'template') === false
     * @assert ('20140718 14:45:10', 'template') === false
     *
     * @assert ('2014-07-18', 'base') === array('Y-m-d', 'base')
     * @assert ('2014-07-18 14', 'base') === array('Y-m-d H', 'base')
     * @assert ('2014-07-18 14:45', 'base') === array('Y-m-d H:i', 'base')
     * @assert ('2014-07-18 14:45:10', 'base') === array('Y-m-d H:i:s', 'base')
     * @assert ('18/07/2014', 'base') === false
     * @assert ('18/07/2014 14:45:10', 'base') === false
     * @assert ('20140718', 'base') === false
     * @assert ('20140718 14:45:10', 'base') === false
     *
     * @assert ('20140718', 'ws') === array('Ymd', 'ws')
     * @assert ('20140718 14', 'ws') === array('Ymd H', 'ws')
     * @assert ('20140718 14:45', 'ws') === array('Ymd H:i', 'ws')
     * @assert ('20140718 14:45:10', 'ws') === array('Ymd H:i:s', 'ws')
     * @assert ('18/07/2014', 'ws') === false
     * @assert ('18/07/2014 14:45:10', 'ws') === false
     * @assert ('2014-07-18', 'ws') === false
     * @assert ('2014-07-18 14:45:10', 'ws') === false
     */
    public static function getDateFormat($strValue, $strTypeDate = null)
    {
        if ((empty($strValue)) || (is_array($strValue)))
            return false;
        $arrValue = explode(' ', $strValue);
        if (count($arrValue) > 2)
            return false;
        $strDateValue = trim($arrValue[0]);
        $strTimeValue = (count($arrValue) > 1) ? trim($arrValue[1]) : null;
        if (($strTypeDate == self::TYPE_DATE_BASE) || ((is_null($strTypeDate)) && (stripos($strDateValue, '-') !== false))) {
            $arrValue = explode('-', $strDateValue);
            if (count($arrValue) != 3)
                return false;
            $strFormatDays = (empty($arrValue[2])) ? '' : ((is_numeric($arrValue[2])) ? 'd' : 'D');
            $strFormatMonths = (empty($arrValue[1])) ? '' : ((is_numeric($arrValue[1])) ? 'm' : 'M');
            $strFormatYears = (empty($arrValue[0])) ? '' : ((strlen((integer) $arrValue[0]) == 2) ? 'y' : 'Y');
            $strFormat = $strFormatYears . '-' . $strFormatMonths . '-' . $strFormatDays;
            $strTypeDate = self::TYPE_DATE_BASE;
        } elseif (($strTypeDate == self::TYPE_DATE_TEMPLATE) || ((is_null($strTypeDate)) && (stripos($strDateValue, '/') !== false))) {
            $arrValue = explode('/', $strDateValue);
            if (count($arrValue) != 3)
                return false;
            $strFormatDays = (empty($arrValue[0])) ? '' : ((is_numeric($arrValue[0])) ? 'd' : 'D');
            $strFormatMonths = (empty($arrValue[1])) ? '' : ((is_numeric($arrValue[1])) ? 'm' : 'M');
            $strFormatYears = (empty($arrValue[2])) ? '' : ((strlen((integer) $arrValue[2]) == 2) ? 'y' : 'Y');
            $strFormat = $strFormatDays . '/' . $strFormatMonths . '/' . $strFormatYears;
            $strTypeDate = self::TYPE_DATE_TEMPLATE;
        } elseif (($strTypeDate == self::TYPE_DATE_WS) || ((is_null($strTypeDate)) && (stripos($strDateValue, '/') === false) && (stripos($strDateValue, '-') === false))) {
            if (!preg_match('/\d{8}/', $strValue))
                return false;
            $strFormat = 'Ymd';
            $strTypeDate = self::TYPE_DATE_WS;
        } else
            return false;
        if (!empty($strTimeValue)) {
            if (strpos($strTimeValue, ':') !== false) {
                $arrTimeValue = explode(':', $strTimeValue);
                if (array_key_exists(0, $arrTimeValue))
                    $strFormat .= ' H';
                if (array_key_exists(1, $arrTimeValue))
                    $strFormat .= ':i';
                if (array_key_exists(2, $arrTimeValue))
                    $strFormat .= ':s';
            } elseif (strlen($strTimeValue) <= 2)
                $strFormat .= ' H';
            elseif (strlen($strTimeValue) <= 4)
                $strFormat .= ' Hi';
            else
                $strFormat .= ' His';
        }
        return array($strFormat, $strTypeDate);
    }

    /**
     * Metodo responsavel em delegar qual funcao de conversao da data para timestamp deve ser acionada.
     *
     * @example \CoreZend\Util\Date::convertDateToTimestamp('18/07/2014', 'template') <br /> \CoreZend\Util\Date::convertDateToTimestamp('18/07/2014 18:02:15', 'template') <br /> \CoreZend\Util\Date::convertDateToTimestamp('2014-07-18', 'base') <br /> \CoreZend\Util\Date::convertDateToTimestamp('2014-07-18 18:02:15', 'base') <br /> \CoreZend\Util\Date::convertDateToTimestamp('20140718', 'ws') <br /> \CoreZend\Util\Date::convertDateToTimestamp('20140718 18:02:15', 'ws')
     *
     * @param string $strValue
     * @return integer
     *
     * @assert ('18/07/2014') === 1405652400
     * @assert ('18/07/2014 18:45:10') === 1405719910
     *
     * @assert ('2014-07-18') === 1405652400
     * @assert ('2014-07-18 18:45:10') === 1405719910
     *
     * @assert ('20140718') === 1405652400
     * @assert ('20140718 18:45:10') === 1405719910
     *
     * @assert ('teste') === null
     */
    public static function convertDateToTimestamp($strValue)
    {
        if (empty($strValue))
            return;
        if (self::isDateTemplate($strValue))
            $strMethod = 'convertDateTemplateToTimestamp';
        elseif (self::isDateBase($strValue))
            $strMethod = 'convertDateBaseToTimestamp';
        elseif (self::isDateWs($strValue))
            $strMethod = 'convertDateWsToTimestamp';
        else
            return;
        return self::$strMethod($strValue);
    }

    /**
     * Metodo responsavel em converter a data na string dd/mm/aaaa para timestamp.
     *
     * @example \CoreZend\Util\Date::convertDateTemplateToTimestamp('18/07/2014') <br /> \CoreZend\Util\Date::convertDateTemplateToTimestamp('18/07/2014 18:45:10')
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('18/07/2014') === 1405652400
     * @assert ('18/07/2014 18:45:10') === 1405719910
     *
     * @assert ('2014-07-18') === null
     * @assert ('2014-07-18 18:45:10') === null
     *
     * @assert ('20140718') === null
     * @assert ('20140718 18:45:10') === null
     */
    public static function convertDateTemplateToTimestamp($strValue)
    {
        return self::convertDateToTimestampAction($strValue, self::TYPE_DATE_TEMPLATE);
    }

    /**
     * Metodo responsavel em converter a data na string aaaa-mm-dd para timestamp.
     *
     * @example \CoreZend\Util\Date::convertDateBaseToTimestamp('2014-07-18') <br /> \CoreZend\Util\Date::convertDateBaseToTimestamp('2014-07-18 18:45:10')
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('2014-07-18') === 1405652400
     * @assert ('2014-07-18 18:45:10') === 1405719910
     *
     * @assert ('18/07/2014') === null
     * @assert ('18/07/2014 18:45:10') === null
     *
     * @assert ('20140718') === null
     * @assert ('20140718 18:45:10') === null
     */
    public static function convertDateBaseToTimestamp($strValue)
    {
        return self::convertDateToTimestampAction($strValue, self::TYPE_DATE_BASE);
    }

    /**
     * Metodo responsavel em converter a data na string aaaammdd para timestamp.
     *
     * @example \CoreZend\Util\Date::convertDateWsToTimestamp('20140718') <br /> \CoreZend\Util\Date::convertDateWsToTimestamp('20140718 18:45:10')
     *
     * @param string $strValue
     * @return string
     *
     * @assert ('20140718') === 1405652400
     * @assert ('20140718 18:45:10') === 1405719910
     *
     * @assert ('2014-07-18') === null
     * @assert ('2014-07-18 18:45:10') === null
     *
     * @assert ('18/07/2014') === null
     * @assert ('18/07/2014 18:45:10') === null
     */
    public static function convertDateWsToTimestamp($strValue)
    {
        return self::convertDateToTimestampAction($strValue, self::TYPE_DATE_WS);
    }

    /**
     * Metodo responsavel em realizar as operacoes para a convercao da data para timestamp.
     *
     * @example \CoreZend\Util\Date::convertDateToTimestampAction('18/07/2014') <br /> \CoreZend\Util\Date::convertDateToTimestampAction('18/07/2014 18:45:10') <br /> \CoreZend\Util\Date::convertDateToTimestampAction('2014-07-18') <br /> \CoreZend\Util\Date::convertDateToTimestampAction('2014-07-18 18:45:10') <br /> \CoreZend\Util\Date::convertDateToTimestampAction('20140718') <br /> \CoreZend\Util\Date::convertDateToTimestampAction('20140718 18:45:10')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @return string
     *
     * @assert ('18/07/2014') === 1405652400
     * @assert ('18/07/2014 18:45:10') === 1405719910
     *
     * @assert ('2014-07-18') === 1405652400
     * @assert ('2014-07-18 18:45:10') === 1405719910
     *
     * @assert ('20140718') === 1405652400
     * @assert ('20140718 18:45:10') === 1405719910
     *
     * @assert ('32/07/2014') === null
     * @assert ('31/32/2014 18:45:10') === null
     *
     * @assert ('2014-07-32') === null
     * @assert ('2014-32-31 18:45:10') === null
     *
     * @assert ('20140732') === null
     * @assert ('20143231 18:45:10') === null
     */
    public static function convertDateToTimestampAction($strValue, $strTypeDate = null)
    {
        $arrInfoDate = self::getInfoDate($strValue, $strTypeDate);
        if (!is_array($arrInfoDate))
            return;
        $arrDate = $arrInfoDate[0];
        $arrTime = $arrInfoDate[1];
        return mktime($arrTime[0], $arrTime[1], $arrTime[2], $arrDate[1], $arrDate[0], $arrDate[2]);
    }

    /**
     * Metodo responsavel em delegar qual funcao de conversao da data deve ser acionada, de acordo com o formato utilizado.
     *
     * @example \CoreZend\Util\Date::convertDate('18/07/2014', 'Y-m-d') <br /> \CoreZend\Util\Date::convertDate('18/07/2014 18:45:10', 'Y-m-d H:i:s') <br /> \CoreZend\Util\Date::convertDate('2014-07-18', 'Y-m-d') <br /> \CoreZend\Util\Date::convertDate('2014-07-18 18:45:10', 'Y-m-d H:i:s') <br /> \CoreZend\Util\Date::convertDate('20140718', 'Y-m-d') <br /> \CoreZend\Util\Date::convertDate('20140718 18:45:10', 'Y-m-d H:i:s')
     *
     * @param string $strValue
     * @param string $strFormat
     * @return string
     *
     * @assert ('18/07/2014', 'd/m/Y') === '18/07/2014'
     * @assert ('18/07/2014 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     * @assert ('18/07/2014 18:45:10', 'd/m/Y h:i:s') === '18/07/2014 06:45:10'
     *
     * @assert ('18/07/2014', 'Y-m-d') === '2014-07-18'
     * @assert ('18/07/2014 18:45:10', 'Y-m-d H:i:s') === '2014-07-18 18:45:10'
     * @assert ('18/07/2014 18:45:10', 'Y-m-d h:i:s') === '2014-07-18 06:45:10'
     *
     * @assert ('18/07/2014', 'Ymd') === '20140718'
     * @assert ('18/07/2014 18:45:10', 'Ymd H:i:s') === '20140718 18:45:10'
     * @assert ('18/07/2014 18:45:10', 'Ymd h:i:s') === '20140718 06:45:10'
     *
     *
     * @assert ('2014-07-18', 'd/m/Y') === '18/07/2014'
     * @assert ('2014-07-18 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     * @assert ('2014-07-18 18:45:10', 'd/m/Y h:i:s') === '18/07/2014 06:45:10'
     *
     * @assert ('2014-07-18', 'Y-m-d') === '2014-07-18'
     * @assert ('2014-07-18 18:45:10', 'Y-m-d H:i:s') === '2014-07-18 18:45:10'
     * @assert ('2014-07-18 18:45:10', 'Y-m-d h:i:s') === '2014-07-18 06:45:10'
     *
     * @assert ('2014-07-18', 'Ymd') === '20140718'
     * @assert ('2014-07-18 18:45:10', 'Ymd H:i:s') === '20140718 18:45:10'
     * @assert ('2014-07-18 18:45:10', 'Ymd h:i:s') === '20140718 06:45:10'
     *
     * @assert ('20140718', 'd/m/Y') === '18/07/2014'
     * @assert ('20140718 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     * @assert ('20140718 18:45:10', 'd/m/Y h:i:s') === '18/07/2014 06:45:10'
     *
     * @assert ('20140718', 'Y-m-d') === '2014-07-18'
     * @assert ('20140718 18:45:10', 'Y-m-d H:i:s') === '2014-07-18 18:45:10'
     * @assert ('20140718 18:45:10', 'Y-m-d h:i:s') === '2014-07-18 06:45:10'
     *
     * @assert ('20140718', 'Ymd') === '20140718'
     * @assert ('20140718 18:45:10', 'Ymd H:i:s') === '20140718 18:45:10'
     * @assert ('20140718 18:45:10', 'Ymd h:i:s') === '20140718 06:45:10'
     */
    public static function convertDate($strValue, $strFormat = 'Y-m-d')
    {
        if (empty($strValue))
            return;
        if (self::isDateTemplate($strValue))
            $strMethod = 'convertDateTemplate';
        elseif (self::isDateBase($strValue))
            $strMethod = 'convertDateBase';
        elseif (self::isDateWs($strValue))
            $strMethod = 'convertDateWs';
        return self::$strMethod($strValue, $strFormat);
    }

    /**
     * Metodo responsavel em converter a data na string dd/mm/aaaa para qualquer formato de data.
     *
     * @example \CoreZend\Util\Date::convertDateTemplate('18/07/2014') <br /> \CoreZend\Util\Date::convertDateTemplate('18/07/2014', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateTemplate('18/07/2014 18:45:10', 'd/m/Y H:i:s')
     *
     * @param string $strValue
     * @param string $strFormat
     * @return string
     *
     * @assert ('18/07/2014') === '2014-07-18'
     * @assert ('18/07/2014', 'd/m/Y') === '18/07/2014'
     * @assert ('18/07/2014 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     *
     * @assert ('2014-07-18') === null
     * @assert ('2014-07-18 18:45:10') === null
     *
     * @assert ('20140718') === null
     * @assert ('20140718 18:45:10') === null
     */
    public static function convertDateTemplate($strValue, $strFormat = 'Y-m-d')
    {
        return self::convertDateAction($strValue, self::TYPE_DATE_TEMPLATE, $strFormat);
    }

    /**
     * Metodo responsavel em converter a data na string aaaa-mm-dd para qualquer formato de data.
     *
     * @example \CoreZend\Util\Date::convertDateBase('2014-07-18') <br /> \CoreZend\Util\Date::convertDateBase('2014-07-18', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateBase('2014-07-18 18:45:10', 'd/m/Y H:i:s')
     *
     * @param string $strValue
     * @param string $strFormat
     * @return string
     *
     * @assert ('2014-07-18') === '18/07/2014'
     * @assert ('2014-07-18 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     *
     * @assert ('2014-07-18', 'Y-m-d') === '2014-07-18'
     * @assert ('2014-07-18 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     *
     * @assert ('2014-07-18', 'Ymd') === '20140718'
     * @assert ('2014-07-18 18:45:10', 'Ymd H:i:s') === '20140718 18:45:10'
     *
     * @assert ('18/07/2014') === null
     * @assert ('18/07/2014', 'Y-m-d') === null
     * @assert ('18/07/2014', 'Ymd') === null
     *
     * @assert ('20140718') === null
     * @assert ('20140718', 'Ymd') === null
     * @assert ('20140718 18:45:10', 'd/m/Y H:i:s') === null
     */
    public static function convertDateBase($strValue, $strFormat = 'd/m/Y')
    {
        return self::convertDateAction($strValue, self::TYPE_DATE_BASE, $strFormat);
    }

    /**
     * Metodo responsavel em converter a data na string aaaammdd para qualquer formato de data.
     *
     * @example \CoreZend\Util\Date::convertDateWs('2014-07-18') <br /> \CoreZend\Util\Date::convertDateWs('2014-07-18', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateWs('2014-07-18 18:45:10', 'd/m/Y H:i:s')
     *
     * @param string $strValue
     * @param string $strFormat
     * @return string
     *
     * @assert ('20140718') === '18/07/2014'
     * @assert ('20140718 18:45:10', 'd/m/Y H:i:s') === '18/07/2014 18:45:10'
     *
     * @assert ('20140718', 'Y-m-d') === '2014-07-18'
     * @assert ('20140718 18:45:10', 'Y-m-d H:i:s') === '2014-07-18 18:45:10'
     *
     * @assert ('20140718', 'Ymd') === '20140718'
     * @assert ('20140718 18:45:10', 'Ymd H:i:s') === '20140718 18:45:10'
     *
     * @assert ('2014-07-18') === null
     * @assert ('2014-07-18', 'd/m/Y') === null
     * @assert ('2014-07-18 18:45:10', 'd/m/Y H:i:s') === null
     *
     * @assert ('18/07/2014') === null
     * @assert ('18/07/2014 18:45:10') === null
     * @assert ('18/07/2014 18:45:10', 'd/m/Y H:i:s') === null
     */
    public static function convertDateWs($strValue, $strFormat = 'd/m/Y')
    {
        return self::convertDateAction($strValue, self::TYPE_DATE_WS, $strFormat);
    }

    /**
     * Metodo responsavel em realizar as operacoes para a convercao da data para qualquer formato de data.
     *
     * @example \CoreZend\Util\Date::convertDateAction('15/07/2014') <br /> \CoreZend\Util\Date::convertDateAction('15/07/2014', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('15/07/2014', 'template' ,'d/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('15/07/2014 15:50:12', 'template', 'd/m/Y H:i:s') <br /> \CoreZend\Util\Date::convertDateAction('2014-07-15') <br /> \CoreZend\Util\Date::convertDateAction('2014-07-15', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('2014-07-15', 'base' ,'d/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('2014-07-15 15:50:12', 'base' ,'d/m/Y H:i:s') <br /> \CoreZend\Util\Date::convertDateAction('20140715') <br /> \CoreZend\Util\Date::convertDateAction('20140715', 'd/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('20140715', 'ws' ,'d/m/Y') <br /> \CoreZend\Util\Date::convertDateAction('20140715 15:50:12', 'ws' ,'d/m/Y H:i:s')
     *
     * @param string $strValue
     * @param string $strTypeDate
     * @param string $strFormat
     * @return string
     *
     * @assert ('15/07/2014') === '2014-07-15'
     * @assert ('2014-04-17') === '2014-04-17'
     * @assert ('20140417') === '2014-04-17'
     *
     * @assert ('15/07/2014', 'template') === '2014-07-15'
     * @assert ('15/07/2014', 'base') === null
     *
     * @assert ('2014-04-17', 'template', 'd/m/Y') === null
     * @assert ('2014-04-17', 'base', 'd/m/Y') === '17/04/2014'
     * @assert ('2014-04-17 12:15:14', 'base', 'd/m/Y H:i:s') === '17/04/2014 12:15:14'
     *
     * @assert ('20140417', 'base') === null
     * @assert ('20140417', 'template') === null
     * @assert ('20140417', 'ws') === '2014-04-17'
     */
    public static function convertDateAction($strValue, $strTypeDate = null, $strFormat = 'Y-m-d')
    {
        $arrInfoDate = self::getInfoDate($strValue, $strTypeDate);
        if (!is_array($arrInfoDate))
            return;
        $arrDate = $arrInfoDate[0];
        $arrTime = $arrInfoDate[1];
        $strTypeDate = $arrInfoDate[3];
        $intTimestamp = null;
        if (($arrDate[2] < 1970) || ($arrDate[2] > 2037)) {
            $intTimestamp = strtotime($strValue);
            if ((is_null($intTimestamp)) || (is_bool($intTimestamp)) || ($intTimestamp < 0)) {
                foreach ($arrDate as $intKey => $strPartDate)
                    $arrDate[$intKey] = str_pad($strPartDate, ($intKey == 2) ? 4 : 2, '0', STR_PAD_LEFT);
                foreach ($arrTime as $intKey => $strPartTime)
                    $arrTime[$intKey] = str_pad($strPartTime, 2, '0', STR_PAD_LEFT);
                $strDateFinal = str_replace(array('Y', 'y', 'o'), $arrDate[2], $strFormat);
                $strDateFinal = str_replace(array('m', 'M', 'n', 'F'), $arrDate[1], $strDateFinal);
                $strDateFinal = str_replace(array('d', 'j'), $arrDate[0], $strDateFinal);
                if (count($arrTime) > 0) {
                    $strDateFinal = str_replace('H', $arrTime[0], $strDateFinal);
                    $strDateFinal = str_replace('i', $arrTime[1], $strDateFinal);
                    $strDateFinal = str_replace('s', $arrTime[2], $strDateFinal);
                }
                return $strDateFinal;
            }
        } else {
            $strMethod = null;
            if ($strTypeDate == self::TYPE_DATE_BASE)
                $strMethod = 'convertDateBaseToTimestamp';
            elseif ($strTypeDate == self::TYPE_DATE_TEMPLATE)
                $strMethod = 'convertDateTemplateToTimestamp';
            elseif ($strTypeDate == self::TYPE_DATE_WS)
                $strMethod = 'convertDateWsToTimestamp';
            if (empty($strMethod))
                return;
            $intTimestamp = self::$strMethod($strValue);
        }
        return (empty($intTimestamp)) ? null : date($strFormat, $intTimestamp);
    }

    /**
     * Metodo responsavel em adicionar ou retira dia(s) a uma data.
     *
     * @example \CoreZend\Util\Date::addDayToDate('15/07/2014', 2) <br /> \CoreZend\Util\Date::addDayToDate('15/07/2014', 2, '-') <br /> \CoreZend\Util\Date::addDayToDate('2014-07-15', 2) <br /> \CoreZend\Util\Date::addDayToDate('2014-07-15', 2, '-') <br /> \CoreZend\Util\Date::addDayToDate('20140715', 2) <br /> \CoreZend\Util\Date::addDayToDate('20140715', 2, '-')
     *
     * @param string $strValue
     * @param integer $intDayToAdd
     * @param string $strSymbolOperation
     * @return string
     *
     * @assert ('15/07/2014', 2) === '17/07/2014'
     * @assert ('15/07/2014', 2, '-') === '13/07/2014'
     *
     * @assert ('2014-07-15', 2) === '2014-07-17'
     * @assert ('2014-07-15', 2, '-') === '2014-07-13'
     *
     * @assert ('20140715', 2) === '20140717'
     * @assert ('20140715', 2, '-') === '20140713'
     */
    public static function addDayToDate($strValue, $intDayToAdd = null, $strSymbolOperation = '+')
    {
        return self::alterDate($strValue, $intDayToAdd, $strSymbolOperation, 'day');
    }

    /**
     * Metodo responsavel em adicionar ou retira hora(s) de uma hora informada.
     *
     * @example \CoreZend\Util\Date::addHourToDate('17/07/2014 19:05:12', 2) <br /> \CoreZend\Util\Date::addHourToDate('17/07/2014 19:05:12', 2, '-') <br /> \CoreZend\Util\Date::addHourToDate('2014-07-15 19:05:12', 2) <br /> \CoreZend\Util\Date::addHourToDate('2014-07-15 19:05:12', 2, '-') <br /> \CoreZend\Util\Date::addHourToDate('20140715 19:05:12', 2) <br /> \CoreZend\Util\Date::addHourToDate('20140715 19:05:12', 2, '-')
     *
     * @param string $strValue
     * @param integer $intHourToAdd
     * @param string $strSymbolOperation
     * @return string
     *
     * @assert ('15/07/2014 19:05:12', 2) === '15/07/2014 21:05:12'
     * @assert ('15/07/2014 19:05:12', 2, '-') === '15/07/2014 17:05:12'
     *
     * @assert ('2014-07-15 19:05:12', 2) === '2014-07-15 21:05:12'
     * @assert ('2014-07-15 19:05:12', 2, '-') === '2014-07-15 17:05:12'
     *
     * @assert ('20140715 19:05:12', 2) === '20140715 21:05:12'
     * @assert ('20140715 19:05:12', 2, '-') === '20140715 17:05:12'
     */
    public static function addHourToDate($strValue, $intHourToAdd = null, $strSymbolOperation = '+')
    {
        return self::alterDate($strValue, $intHourToAdd, $strSymbolOperation, 'hour');
    }

    /**
     * Metodo responsavel em adicionar ou retirar minutos(s) de uma data.
     *
     * @example \CoreZend\Util\Date::addMinuteToDate('17/07/2014 19:05:12', 2) <br /> \CoreZend\Util\Date::addMinuteToDate('17/07/2014 19:05:12', 2, '-') <br /> \CoreZend\Util\Date::addMinuteToDate('2014-07-15 19:05:12', 2) <br /> \CoreZend\Util\Date::addMinuteToDate('2014-07-15 19:05:12', 2, '-') <br /> \CoreZend\Util\Date::addMinuteToDate('20140715 19:05:12', 2) <br /> \CoreZend\Util\Date::addMinuteToDate('20140715 19:05:12', 2, '-')
     *
     * @param string $strValue
     * @param integer $intMinuteToAdd
     * @param string $strSymbolOperation
     * @return string
     *
     * @assert ('15/07/2014 19:05:12', 2) === '15/07/2014 19:07:12'
     * @assert ('15/07/2014 19:05:12', 2, '-') === '15/07/2014 19:03:12'
     *
     * @assert ('2014-07-15 19:05:12', 2) === '2014-07-15 19:07:12'
     * @assert ('2014-07-15 19:05:12', 2, '-') === '2014-07-15 19:03:12'
     *
     * @assert ('20140715 19:05:12', 2) === '20140715 19:07:12'
     * @assert ('20140715 19:05:12', 2, '-') === '20140715 19:03:12'
     */
    public static function addMinuteToDate($strValue, $intMinuteToAdd = null, $strSymbolOperation = '+')
    {
        return self::alterDate($strValue, $intMinuteToAdd, $strSymbolOperation, 'minute');
    }

    /**
     * Metodo responsavel em adicionar ou retirar hora(s)/minutos(s) de uma data.
     *
     * @example \CoreZend\Util\Date::alterDate('18/07/2014', 1) <br /> \CoreZend\Util\Date::alterDate('18/07/2014', 1, '-') <br /> \CoreZend\Util\Date::alterDate('18/07/2014 11:08:10', 1, null, 'hour') <br /> \CoreZend\Util\Date::alterDate('18/07/2014 11:08:10', 1, '-', 'hour')
     *
     * @param string $strValue
     * @param integer $intToAlter
     * @param string $strSymbolOperation
     * @param string $strDateElement
     * @return string
     *
     * @assert ('18/07/2014') === '18/07/2014'
     * @assert ('2014-07-18') === '2014-07-18'
     * @assert ('20140718') === '20140718'
     *
     * @assert ('18/07/2014', 1) === '19/07/2014'
     * @assert ('2014-07-18', 1) === '2014-07-19'
     * @assert ('20140718', 1) === '20140719'
     *
     * @assert ('18/07/2014 11:15:12', 1, null, 'hour') === '18/07/2014 12:15:12'
     * @assert ('2014-07-18 11:15:12', 1, null, 'hour') === '2014-07-18 12:15:12'
     * @assert ('20140718 11:15:12', 1, null, 'hour') === '20140718 12:15:12'
     *
     * @assert ('18/07/2014 11:15:12', 1, null, 'hour') === '18/07/2014 12:15:12'
     * @assert ('2014-07-18 11:15:12', 1, null, 'hour') === '2014-07-18 12:15:12'
     * @assert ('20140718 11:15:12', 1, null, 'hour') === '20140718 12:15:12'
     */
    public static function alterDate($strValue, $intToAlter = null, $strSymbolOperation = '+', $strDateElement = 'day')
    {
        if (empty($strValue))
            return;
        if (empty($intToAlter))
            $intToAlter = 0;
        if (empty($strSymbolOperation))
            $strSymbolOperation = '+';
        if (empty($strDateElement))
            $strDateElement = 'day';
        $arrInfoDate = self::getInfoDate($strValue);
        if (!is_array($arrInfoDate))
            return;
        $arrDate = $arrInfoDate[0];
        $arrTime = $arrInfoDate[1];
        $strFormat = $arrInfoDate[2];
        $intDay = $arrDate[0];
        $intHour = $arrTime[0];
        $intMinute = $arrTime[1];
        if (strtolower($strDateElement) == 'day')
            $intDay = ($strSymbolOperation == '+') ? ($intDay + $intToAlter) : ($intDay - $intToAlter);
        elseif (strtolower($strDateElement) == 'hour')
            $intHour = ($strSymbolOperation == '+') ? ($intHour + $intToAlter) : ($intHour - $intToAlter);
        else
            $intMinute = ($strSymbolOperation == '+') ? ($intMinute + $intToAlter) : ($intMinute - $intToAlter);
        return date($strFormat, mktime($intHour, $intMinute, $arrTime[2], $arrDate[1], $intDay, $arrDate[2]));
    }

    /**
     * Metodo responsavel em retornar a diferenca que existe entre duas datas no formato DD/MM/YYYY, YYYY-MM-DD ou YYYYMMDD em dias.
     *
     * @example \CoreZend\Util\Date::dateDiff('23/07/2014', '25/07/2014')
     *
     * @param string strDate1
     * @param string strDate2
     * @param boolean $booRound
     * @return integer
     *
     * @assert ('23/07/2014', '25/07/2014') === 2.0
     * @assert ('23/07/2014', '25/07/2014') === 2.0
     * @assert ('31/07/2014', '25/07/2014', true) === 6.0
     */
    public static function dateDiff($strDate1 = null, $strDate2 = null, $booRound = true)
    {
        if ((is_null($strDate1)) && (is_null($strDate2)))
            return;
        if (is_null($strDate2))
            $strDate2 = (stripos($strDate1, ' ') === false) ? date('Y-m-d') : date('Y-m-d H:i:s');
        if (is_null($strDate1))
            $strDate1 = (stripos($strDate2, ' ') === false) ? date('Y-m-d') : date('Y-m-d H:i:s');
        $intTimestamp1 = self::convertDateToTimestamp($strDate1);
        if (is_null($intTimestamp1))
            return;
        $intTimestamp2 = self::convertDateToTimestamp($strDate2);
        if (is_null($intTimestamp2))
            return;
        if ($booRound !== false)
            $intReturn = ($intTimestamp1 > $intTimestamp2) ? round(($intTimestamp1 - $intTimestamp2) / (60 * 60 * 24)) : round(($intTimestamp2 - $intTimestamp1) / (60 * 60 * 24));
        else
            $intReturn = ($intTimestamp1 > $intTimestamp2) ? (($intTimestamp1 - $intTimestamp2) / (60 * 60 * 24)) : (($intTimestamp2 - $intTimestamp1) / (60 * 60 * 24));
        return $intReturn;
    }

    /**
     * Metodo responsavel em retornar o proxima dia da semana que nao seja final de semana.
     *
     * @example \CoreZend\Util\Date::nextDayNotWeekend('26/07/2014') <br /> \CoreZend\Util\Date::nextDayNotWeekend('2014-07-26') <br /> \CoreZend\Util\Date::nextDayNotWeekend('20140726')
     *
     * @param string strDate
     * @return string
     *
     * @assert ('26/07/2014') === '28/07/2014'
     * @assert ('23/07/2014') === '23/07/2014'
     *
     * @assert ('2014-07-26') === '2014-07-28'
     * @assert ('2014-07-23') === '2014-07-23'
     *
     * @assert ('20140726') === '20140728'
     * @assert ('20140723') === '20140723'
     */
    public static function nextDayNotWeekend($strDate)
    {
        if (is_null($strDate))
            $strDate = date('Y-m-d');
        $intTimestamp = self::convertDateToTimestamp($strDate);
        if (is_null($intTimestamp))
            return;
        while (in_array(date('N', $intTimestamp), array(6, 7))) {
            $strDate = self::addDayToDate($strDate, 1);
            $intTimestamp = self::convertDateToTimestamp($strDate);
        }
        return $strDate;
    }

    /**
     * Metodo responsavel em retornar o dia da semana abreviado ou nao.
     *
     * @example \CoreZend\Util\Date::getWeekday(1) <br /> \CoreZend\Util\Date::getWeekday(1, true)
     *
     * @param integer $intDiaSemana
     * @param boolean $booAbreviatura
     * @return string
     *
     * @assert (1) === 'segunda-feira'
     * @assert (2) === 'ter&ccedil;a-feira'
     * @assert (3) === 'quarta-feira'
     * @assert (4) === 'quinta-feira'
     * @assert (5) === 'sexta-feira'
     * @assert (6) === 's&aacute;bado'
     * @assert (7) === 'domingo'
     *
     * @assert (1, true) === 'seg'
     * @assert (2, true) === 'ter'
     * @assert (3, true) === 'qua'
     * @assert (4, true) === 'qui'
     * @assert (5, true) === 'sex'
     * @assert (6, true) === 'sab'
     * @assert (7, true) === 'dom'
     */
    public static function getWeekday($intDiaSemana, $booAbreviatura = false)
    {
        $arrWeekday = array(
            1 => array('segunda-feira', 'seg'),
            2 => array('ter&ccedil;a-feira', 'ter'),
            3 => array('quarta-feira', 'qua'),
            4 => array('quinta-feira', 'qui'),
            5 => array('sexta-feira', 'sex'),
            6 => array('s&aacute;bado', 'sab'),
            7 => array('domingo', 'dom'),
        );
        return $arrWeekday[$intDiaSemana][($booAbreviatura === false) ? 0 : 1];
    }

    /**
     * Metodo responsavel em retorna o nome do mes em portugues ou ingles.
     *
     * @example \CoreZend\Util\Date::getPortugueseMonth(1) <br /> \CoreZend\Util\Date::getPortugueseMonth(1, true)
     *
     * @param integer $intMonth
     * @param string $strLanguage
     * @return string
     *
     * @assert (1) === 'janeiro'
     * @assert (2) === 'fevereiro'
     * @assert (3) === 'mar&ccedil;o'
     * @assert (4) === 'abril'
     * @assert (5) === 'maio'
     * @assert (6) === 'junho'
     * @assert (7) === 'julho'
     * @assert (8) === 'agosto'
     * @assert (9) === 'setembro'
     * @assert (10) === 'outubro'
     * @assert (11) === 'novembro'
     * @assert (12) === 'dezembro'
     *
     * @assert (1, 'en') === 'january'
     * @assert (2, 'en') === 'february'
     * @assert (3, 'en') === 'march'
     * @assert (4, 'en') === 'april'
     * @assert (5, 'en') === 'may'
     * @assert (6, 'en') === 'june'
     * @assert (7, 'en') === 'july'
     * @assert (8, 'en') === 'august'
     * @assert (9, 'en') === 'september'
     * @assert (10, 'en') === 'october'
     * @assert (11, 'en') === 'november'
     * @assert (12, 'en') === 'december'
     */
    public static function getPortugueseMonth($intMonth, $strLanguage = 'br')
    {
        if (strtolower($strLanguage) != 'br') {
            $arrMonth = array(
                1 => 'january', 2 => 'february', 3 => 'march', 4 => 'april',
                5 => 'may', 6 => 'june', 7 => 'july', 8 => 'august',
                9 => 'september', 10 => 'october', 11 => 'november', 12 => 'december'
            );
        } else {
            $arrMonth = array(
                1 => 'janeiro', 2 => 'fevereiro', 3 => 'mar&ccedil;o', 4 => 'abril',
                5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
                9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
            );
        }
        return $arrMonth[(integer) $intMonth];
    }

    /**
     * Metodo responsavel em retornar um array de datas (no formato das datas parametrizadas) de um periodo por dia.
     *
     * @example \CoreZend\Util\Date::listDatesOfPeriod('18/07/2014', '25/07/2014')
     *
     * @param string strDate1
     * @param string strDate2
     * @return array
     *
     * @assert ('18/07/2014', '25/07/2014') === array(0 => '18/07/2014', 1 => '19/07/2014', 2 => '20/07/2014', 3 => '21/07/2014', 4 => '22/07/2014', 5 => '23/07/2014', 6 => '24/07/2014', 7 => '25/07/2014')
     * @assert ('2014-07-18', '2014-07-25') === array(0 => '2014-07-18', 1 => '2014-07-19', 2 => '2014-07-20', 3 => '2014-07-21', 4 => '2014-07-22', 5 => '2014-07-23', 6 => '2014-07-24', 7 => '2014-07-25')
     * @assert ('20140718', '20140725') === array(0 => '20140718', 1 => '20140719', 2 => '20140720', 3 => '20140721', 4 => '20140722', 5 => '20140723', 6 => '20140724', 7 => '20140725')
     *
     * @assert ('25/07/2014', '18/07/2014') === array(0 => '18/07/2014', 1 => '19/07/2014', 2 => '20/07/2014', 3 => '21/07/2014', 4 => '22/07/2014', 5 => '23/07/2014', 6 => '24/07/2014', 7 => '25/07/2014')
     * @assert ('2014-07-25', '2014-07-18') === array(0 => '2014-07-18', 1 => '2014-07-19', 2 => '2014-07-20', 3 => '2014-07-21', 4 => '2014-07-22', 5 => '2014-07-23', 6 => '2014-07-24', 7 => '2014-07-25')
     * @assert ('20140725', '20140718') === array(0 => '20140718', 1 => '20140719', 2 => '20140720', 3 => '20140721', 4 => '20140722', 5 => '20140723', 6 => '20140724', 7 => '20140725')
     */
    public static function listDatesOfPeriod($strDate1, $strDate2, $arrReturn = array())
    {
        if ((!isset($strDate1)) || (!isset($strDate2)))
            return array();
        if (self::isDateTemplate($strDate1)) {
            $intTimestamp1 = self::convertDateTemplateToTimestamp($strDate1);
            $strFormat1 = 'd/m/Y';
        } elseif (self::isDateBase($strDate1)) {
            $intTimestamp1 = self::convertDateBaseToTimestamp($strDate1);
            $strFormat1 = 'Y-m-d';
        } elseif (self::isDateWs($strDate1)) {
            $intTimestamp1 = self::convertDateWsToTimestamp($strDate1);
            $strFormat1 = 'Ymd';
        } else
            return array();
        if (self::isDateTemplate($strDate2)) {
            $intTimestamp2 = self::convertDateTemplateToTimestamp($strDate2);
            $strFormat2 = 'd/m/Y';
        } elseif (self::isDateBase($strDate2)) {
            $intTimestamp2 = self::convertDateBaseToTimestamp($strDate2);
            $strFormat2 = 'Y-m-d';
        } elseif (self::isDateWs($strDate2)) {
            $intTimestamp2 = self::convertDateWsToTimestamp($strDate2);
            $strFormat2 = 'Ymd';
        } else
            return array();
        if ($intTimestamp2 < $intTimestamp1) {
            $intTimestampInicial = $intTimestamp2;
            $intTimestampFinal = $intTimestamp1;
            $strFormatInicial = $strFormat2;
            $strFormatFinal = $strFormat1;
        } else {
            $intTimestampInicial = $intTimestamp1;
            $intTimestampFinal = $intTimestamp2;
            $strFormatInicial = $strFormat1;
            $strFormatFinal = $strFormat2;
        }
        $intTimestampInicialAcrescido = ($intTimestampInicial + (60 * 60 * 24));
        if (!in_array($intTimestampInicial, $arrReturn))
            $arrReturn[] = date($strFormatInicial, $intTimestampInicial);
        if ($intTimestampFinal > $intTimestampInicialAcrescido)
            return self::listDatesOfPeriod(date($strFormatInicial, $intTimestampInicialAcrescido), date($strFormatFinal, $intTimestampFinal), $arrReturn);
        $arrReturn[] = date($strFormatFinal, $intTimestampFinal);
        return $arrReturn;
    }

    public static function compareDates($strInicialDate = null, $strFinalDate = null)
    {
        $inicialDate = new \DateTime($strInicialDate);
        $finalDate = new \DateTime($strFinalDate);
        return ($finalDate->getTimestamp() > $inicialDate->getTimestamp()) ? true : false;
    }

    public static function checkDateProfileActive($strDatStart, $strDatEnd)
    {
        if (empty($strDatStart) && empty($strDatEnd)) {
            return true;
        }
        return (Date::compareDates($strDatStart, 'now') && Date::compareDates('now', $strDatEnd));
    }

}
