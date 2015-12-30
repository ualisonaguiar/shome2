/**
 * Retorna o objeto XML apartir de uma string deste padrao
 * 
 * @param STRING strXml
 * @return OBJECT
 */
function loadXMLString(strXml)
{
    if (strXml == undefined)
        strXml = '';
    if (window.DOMParser) {
        var DOMParser = new DOMParser();
        var xml = DOMParser.parseFromString(strXml, 'text/xml');
        return xml;
    } else if (window.ActiveXObject) {
        var xml = new ActiveXObject('Microsoft.XMLDOM');
        xml.async = 'false';
        xml.loadXML(strXml);
        return xml;
    } else if ((document.implementation) && (document.implementation.createDocument)) {
        var xml = document.implementation.createDocument('', '', null);
        xml.async = false;
        xml.load(strXml);
        return xml;
    } else {
        alert('Seu navegador nao esta apto a ler um arquivo XML');
        return;
    }
}

/**
 * Retorna o objeto Element do XML, apartir de uma string que se refere a tag do nodo
 * 
 * @param OBJECT xml
 * @param STRING strNodeName
 * @return MIX
 */
function getNodeXml(xml, strNodeName)
{
    var arrHtmlCollection = xml.getElementsByTagName(strNodeName);
    if ((arrHtmlCollection == undefined) || (arrHtmlCollection == null) || (arrHtmlCollection[0] == undefined) || (arrHtmlCollection[0] == null))
        return;
    var arrResult = new Array();
    for (var intCount = 0; intCount < arrHtmlCollection.length; ++intCount)
        arrResult[arrResult.length] = arrHtmlCollection[intCount];
    return (arrResult.length == 1) ? arrResult[0] : arrResult;
}

/**
 * Retorna o valor do objeto Element do XML, apartir de uma string que se refere a tag do nodo
 * 
 * @param OBJECT xml
 * @param STRING strNodeName
 * @return MIX
 */
function getNodeValueXml(xml, strNodeName)
{
    var mixResult = getNodeXml(xml, strNodeName);
    if ((mixResult == undefined) || (mixResult == null))
        return;
    var arrResult = new Array();
    for (var intCount = 0; intCount < mixResult.childNodes.length; ++intCount) {
        var childNode = mixResult.childNodes[intCount];
        if ((childNode.nodeType == 3) && ((childNode.data == undefined) || (childNode.data == null) || (childNode.data == '') || (childNode.data == ' ') || (childNode.data == '\n')))
            continue;
        arrResult[arrResult.length] = (childNode.nodeType == 3) ? childNode.data : childNode;
    }
    return (arrResult.length == 1) ? arrResult[0] : arrResult;
}