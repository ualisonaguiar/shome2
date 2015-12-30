/**
 * Confere se o navegador eh internet explorer ou nao
 *
 * @return BOOL
 */
function isIE()
{
    return document.all;
}

function getBrowser()
{
    return navigator.userAgent;
}