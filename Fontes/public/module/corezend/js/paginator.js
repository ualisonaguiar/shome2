function handlerPaginatorFlexigrid() {
    var strDsRoute,
            arrColumn,
            arrButton,
            strIdTable,
            strDataType = 'json',
            strIdTable,
            intWidth = 700,
            intHeight = 200,
            intQuantidadeItemPagina = 15;

    /**
     * 
     * @param {type} strDsRoute
     * @returns {handlerPaginator}
     */
    this.setDsRoute = function (strDsRoute) {
        this.strDsRoute = strDsRoute;
        return this;
    }

    /**
     * 
     * @returns {type}
     */
    this.getDsRoute = function () {
        return this.strDsRoute;
    }

    /**
     * 
     * @param {type} arrColumn
     * @returns {handlerPaginator}
     */
    this.setColumn = function (arrColumn) {
        this.arrColumn = arrColumn;
        return this;
    }

    /**
     * 
     * @returns {type}
     */
    this.getColumn = function () {
        return this.arrColumn;
    }

    /**
     * 
     * @param {type} arrButton
     * @returns {handlerPaginator}
     */
    this.setButton = function (arrButton) {
        this.arrButton = arrButton;
        return this;
    }

    /**
     * 
     * @returns {type}
     */
    this.getButton = function () {
        return this.arrButton;
    }

    /**
     * 
     * @param {type} strIdTable
     * @returns {handlerPaginator}
     */
    this.setIdTable = function (strIdTable) {
        this.strIdTable = strIdTable;
        return this;
    }

    /**
     * 
     * @returns {type}
     */
    this.getIdTable = function () {
        return this.strIdTable;
    }

    /**
     * 
     * @param {type} strDataType
     * @returns {handlerPaginatorFlexigrid}
     */
    this.setDataType = function (strDataType) {
        this.strDataType = strDataType;
        return this;
    }

    /**
     * 
     * @returns {undefined}
     */
    this.getDatatype = function () {
        this.strDataType;
    }

    /**
     * 
     * @param {type} strTitle
     * @returns {handlerPaginatorFlexigrid}
     */
    this.setTitle = function (strTitle) {
        this.strIdTable = strTitle;
        return this;
    }

    /**
     * 
     * @returns {undefined}
     */
    this.getTitle = function () {
        this.strIdTable;
    }

    /**
     * 
     * @param {type} intWidth
     * @returns {handlerPaginatorFlexigrid}
     */
    this.setWidth = function (intWidth) {
        this.intWidth = intWidth;
        return this;
    }

    /**
     * 
     * @returns {type|Number}
     */
    this.getWidth = function () {
        return this.intWidth;
    }


    /**
     * 
     * @param {type} intHeight
     * @returns {handlerPaginatorFlexigrid}
     */
    this.setHeight = function (intHeight) {
        this.intHeight = intHeight;
        return this;
    }

    /**
     * 
     * @returns {type|Number}
     */
    this.getHeight = function () {
        return this.intHeight;
    }

    /**
     * 
     * @param {type} intHeight
     * @returns {handlerPaginatorFlexigrid}
     */
    this.setQuantidadeItemPagina = function (intQuantidadeItemPagina) {
        this.intQuantidadeItemPagina = intQuantidadeItemPagina;
        return this;
    }

    /**
     * 
     * @returns {type|Number}
     */
    this.getQuantidadeItemPagina = function () {
        return this.intQuantidadeItemPagina;
    }

    /**
     * 
     * @returns {undefined}
     */
    this.getColumnTable = function () {
        if (this.getColumn()) {
            var strColumnTable = '';
            $.each(this.getColumn(), function (intPosicacao, columnTable) {
                strColumnTable += '{"display": "' + columnTable.label + '", "name":"' + columnTable.name + '",';
                strColumnTable += '"width":"' + columnTable.width + '",';
                strColumnTable += '"sortable":"' + columnTable.sortable + '",';
                strColumnTable += '"align":"' + columnTable.align + '"},';
            });
            if (this.getButton()) {
                strColumnTable += '{"display": "<strong>Ação</strong>", "name":"action-button", "width" : "auto"},';
            }
            return JSON.parse('[' + strColumnTable.substr(0, strColumnTable.length - 1) + ']');
        }
    }

    /**
     * 
     * @returns {undefined}
     */
    this.getShowGrid = function () {
        $("#" + this.getIdTable()).flexigrid({
            url: this.getDsRoute(),
            dataType: 'json',
            colModel: this.getColumnTable(),
//            buttons: this.getButtonTable(),
            usepager: true,
            title: this.getTitle(),
            useRp: true,
            rp: this.getQuantidadeItemPagina(),
            showTableToggleBtn: true,
            width: this.getWidth(),
            height: this.getHeight(),
            align: 'center',
            errormsg: "Erro de Conexão",
            pagestat: "Listando {from} até {to} de {total} registro(s)",
            pagetext: "Página",
            outof: "de",
            findtext: "Procurar",
            procmsg: "Processando, por favor aguarde...",
            nomsg: "Sem registro"
        });
    }
}