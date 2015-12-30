function include(strFilePath, booHead)
{
    if (strFilePath == undefined)
        return;
    if (booHead == undefined)
        booHead = true;
    var strSource = (strFilePath.indexOf(':/') == -1) ? strGlobalBasePath + strFilePath : strFilePath;
    if (booHead) {
        var script = document.createElement('SCRIPT');
        script.setAttribute('type', 'text/javascript');
        script.setAttribute('src', strSource);
        document.head.appendChild(script);
//        $("head").append("<script type='text/javascript' src='" + strSource + "'></script>");
//        $.getScript(strSource);
//        $('head').append(script);
    } else {
//        document.write(unescape("%3Cscript src='" + strSource + "' type='text/javascript' defer%3E%3C/script%3E"));
        document.body.innerHTML += unescape("%3Cscript src='" + strSource + "' type='text/javascript' defer%3E%3C/script%3E");
    }
}

function include_once(strFilePath, booHead)
{
    if (strFilePath == undefined)
        return;
    var arrScript = document.getElementsByTagName('SCRIPT');
    for (var intCount = 0; intCount < arrScript.length; ++intCount) {
        var script = arrScript[intCount];
        if ((script != undefined) && (script.src != null) && (script.src.indexOf(strFilePath) != -1))
            return;
    }
    include(strFilePath, booHead);
}