/* global fcom, layoutDirection, langLbl, weekDayNames, weekDayNames, monthNames  */
var dayShortNames = weekDayNames.shortName.slice(0);
var lastValue = dayShortNames[6];
dayShortNames.pop();
dayShortNames.unshift(lastValue);
defaultsValue = {
    monthNames: monthNames.longName,
    monthNamesShort: monthNames.shortName,
    dayNamesMin: dayShortNames,
    dayNamesShort: dayShortNames,
    currentText: langLbl.today,
    closeText: langLbl.done,
    prevText: langLbl.prev,
    nextText: langLbl.next,
    isRTL: (layoutDirection == 'rtl')
};
$.datepicker.regional[''] = $.extend(true, {}, defaultsValue);
$.datepicker.setDefaults($.datepicker.regional['']);
(function () {
    goToSearchPage = function (pageno) {
        var frm = document.frmSearchPaging;
        $(frm.pageno).val(pageno);
        searchWithdrawRequests(frm);
    };
    searchWithdrawRequests = function (frm) {
        fcom.ajax(fcom.makeUrl('Wallet', 'searchWithdrawRequests'), fcom.frmData(frm), function (res) {
            $("#listing").html(res);
        });
    };
    clearSearch = function () {
        document.withdrawSrchFrm.reset();
        searchWithdrawRequests(document.withdrawSrchFrm);
    };
    closeForm = function () {
        $(document).trigger('close.facebox');
    }
    withdrwalRequestForm = function (methodId) {
        fcom.ajax(fcom.makeUrl('Wallet', 'requestWithdrawal'), 'methodId=' + methodId, function (response) {
            $.facebox(response, 'facebox-medium request-Withdrawal-js');
        });
    };
    getWithdrwalRequestForm = function (methodId) {
        fcom.ajax(fcom.makeUrl('Wallet', 'requestWithdrawal'), 'methodId=' + methodId, function (response) {
            $('.request-Withdrawal-js').html(response);
        });
    };
    setupWithdrawalReq = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Wallet', 'setupRequestWithdrawal'), fcom.frmData(frm), function (t) {
            searchWithdrawRequests(document.withdrawSrchFrm);
            $(document).trigger('close.facebox');
        });
    };
})();