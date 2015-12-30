/**
 * Retorna o objeto JSON apartir de uma string deste padrao
 * 
 * @param STRING strJson
 * @return OBJECT
 */
function getJsonObject(strJson)
{
    return eval('(' + strJson + ')');
}