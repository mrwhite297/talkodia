/* global fcom, langLbl */
(function () {
    var dv = '#listing';
    searchNavigations = function (form) {
        fcom.ajax(fcom.makeUrl('Navigations', 'search'), fcom.frmData(form), function (res) {
            $(dv).html(res);
        });
    };
    reloadlist = function () {
        fcom.ajax(window.location.href, 'shortview=1', function (t) {
            $(dv).html(t);
        });
    };
    addNavigationLinkForm = function (nav_id, nlink_id) {
        navigationLinkForm(nav_id, nlink_id);
    }
    navigationLinkForm = function (nav_id, nlink_id) {
        var data = 'nav_id=' + nav_id + '&nlink_id=' + nlink_id;
        fcom.ajax(fcom.makeUrl('Navigations', 'navigationLinkForm'), data, function (t) {
            fcom.updateFaceboxContent(t)
        });
    }
    setupNavigationLink = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Navigations', 'setupNavigationLink'), data, function (t) {
            reloadlist($(frm.nlink_nav_id).val());
            if (t.langId > 0 && t.nlinkId > 0) {
                navigationLinkLangForm($(frm.nlink_nav_id).val(), t.nlinkId, t.langId);
                return;
            }
            $(document).trigger('close.facebox');
        });
    }
    navigationLinkLangForm = function (nav_id, nlink_id, lang_id) {
        var data = 'nav_id=' + nav_id + '&nlink_id=' + nlink_id + '&lang_id=' + lang_id;
        fcom.ajax(fcom.makeUrl('Navigations', 'navigationLinkLangForm'), data, function (t) {
            fcom.updateFaceboxContent(t);
        });
    }
    setupNavigationLinksLang = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Navigations', 'setupNavigationLinksLang'), data, function (t) {
            reloadlist();
            if (t.langId > 0 && t.nlinkId > 0) {
                navigationLinkLangForm($(frm.nav_id).val(), t.nlinkId, t.langId);
                return;
            }
            $(document).trigger('close.facebox');
        });
    }
    callPageTypePopulate = function (el) {
        var nlink_type = $(el).val();
        if (nlink_type == 0) {
            //if cms Page
            $("#nlink_url_div").hide();
            $("#nlink_category_id_div").hide();
            $("#nlink_cpage_id_div").show();
        } else if (nlink_type == 2) {
            //if External page
            $("#nlink_url_div").show();
            $("#nlink_cpage_id_div").hide();
            $("#nlink_category_id_div").hide();
        } else if (nlink_type == 3) {
            //if External page
            $("#nlink_url_div").hide();
            $("#nlink_cpage_id_div").hide();
            $("#nlink_category_id_div").show();
        }
    };
    deleteNavigationLink = function (navId, nlinkId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        var data = 'nlinkId=' + nlinkId;
        fcom.ajax(fcom.makeUrl('Navigations', 'deleteNavigationLink'), data, function (res) {
            reloadlist(navId);
        });
    };
    toggleStatus = function (e, obj, canEdit) {
        if (canEdit == 0) {
            e.preventDefault();
            return;
        }
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var navId = parseInt(obj.value);
        if (navId < 1) {
            fcom.error(langLbl.invalidRequest);
            return false;
        }
        data = 'navId=' + navId;
        fcom.ajax(fcom.makeUrl('Navigations', 'changeStatus'), data, function (res) {
            $(obj).toggleClass("active");
        });
    };
})();	