/* global fcom */
$(document).ready(function () {
    searchPackage(document.search);
    $("input[name='ordcls_tlang']").autocomplete({
        'source': function (request, response) {
            fcom.updateWithAjax(fcom.makeUrl('TeachLanguage', 'autoCompleteJson'), {
                keyword: request
            }, function (result) {
                response($.map(result.data, function (item) {
                    return {
                        label: escapeHtml(item['tlang_name']),
                        value: item['tlang_id'],
                        name: item['tlang_name']
                    };
                }));
            });
        },
        'select': function (item) {
            $("input[name='ordcls_tlang_id']").val(item.value);
            $("input[name='ordcls_tlang']").val(item.name);
        }
    });
    $("input[name='ordcls_tlang']").keyup(function () {
        $("input[name='ordcls_tlang_id']").val('');
    });
});
(function () {
    var dv = '#listing';
    goToSearchPage = function (pageno) {
        var frm = document.frmClassSearchPaging;
        $(frm.pageno).val(pageno);
        searchPackage(frm);
    };
    reloadList = function () {
        search(document.frmClassSearchPaging);
    };
    searchPackage = function (form) {
        fcom.ajax(fcom.makeUrl('Packages', 'search'), fcom.frmData(form), function (res) {
            $(dv).html(res);
        });
    };
    view = function (ordpkgId) {
        fcom.ajax(fcom.makeUrl('Packages', 'view'), {ordpkgId: ordpkgId}, function (res) {
            $.facebox(res, 'facebox-medium');
        });
    };
    clearSearch = function () {
        document.search.reset();
        $("input[name='ordcls_tlang_id']").val('');
        searchPackage(document.search);
    };
})();
